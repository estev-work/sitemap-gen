<?php

namespace Estev\Sitemap;

use Estev\Sitemap\Enums\FileType;
use Estev\Sitemap\Exceptions\CreateSiteMapElementException;
use Estev\Sitemap\Exceptions\EmptyParamsArrayException;
use Estev\Sitemap\Generators\Csv;
use Estev\Sitemap\Generators\Json;
use Estev\Sitemap\Generators\Xml;
use Estev\Sitemap\Interfaces\IGenerator;
use Estev\Sitemap\Util\FileWriter;
use Estev\Sitemap\Util\Validate;
use Exception;

class SitemapGenerator
{
    private array $params;
    private IGenerator $generator;
    private string $pathForSave;
    private FileType $resultFileType;

    /**
     * @param array $params
     * @param FileType $resultFileType
     * @param string $outputDir
     * @throws Exception
     */
    public function __construct(array $params, FileType $resultFileType, string $outputDir)
    {
        if (!empty($params)) {
            $this->params = $params;
        } else {
            throw new EmptyParamsArrayException();
        }
        $this->pathForSave = $outputDir;
        $this->resultFileType = $resultFileType;
    }

    /**
     * @param array $params
     * @param FileType $resultFileType
     * @param string $outputDir
     * @return string
     * @throws CreateSiteMapElementException
     */
    public static function generate(array $params, FileType $resultFileType, string $outputDir): string
    {
        return (new self($params, $resultFileType, $outputDir))->create();
    }

    /**
     * @throws Exceptions\CreateSiteMapElementException
     */
    public function create():string
    {
        return match ($this->resultFileType) {
            FileType::Json => $this->build(new Json()),
            FileType::Csv => $this->build(new Csv()),
            FileType::Xml => $this->build(new Xml()),
        };
    }
    /**
     * @throws Exceptions\CreateSiteMapElementException
     * @throws Exception
     */
    private function build(IGenerator $generator): string
    {
        $elements = array();
        foreach ($this->params as $data) {
            Validate::validateElementParam($data);
            $elements[] = new Element($data['loc'], new \DateTime($data['lastmod']),  $data['priority'], $data['changefreq']);
        }

        $fileData = $generator->buildData($elements);
        return FileWriter::writeToFile($fileData, $this->pathForSave, $this->resultFileType);
    }
}