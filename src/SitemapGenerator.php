<?php

namespace Estev\Sitemap;

use Estev\Sitemap\Enums\FileType;
use Estev\Sitemap\Exceptions\CreateSiteMapElementException;
use Estev\Sitemap\Exceptions\EmptyParamsArrayException;
use Estev\Sitemap\Exceptions\FileCreateException;
use Estev\Sitemap\Exceptions\FileWriteException;
use Estev\Sitemap\Generators\Csv;
use Estev\Sitemap\Generators\Json;
use Estev\Sitemap\Generators\Xml;
use Estev\Sitemap\Interfaces\IGenerator;
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
     * @param string $pathForSave
     * @throws \Exception
     */
    public function __construct(array $params, FileType $resultFileType, string $pathForSave)
    {
        if (!empty($params)) {
            $this->params = $params;
        } else {
            throw new EmptyParamsArrayException();
        }
        $this->pathForSave = $pathForSave;
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
     * @throws \Exception
     */
    private function build(IGenerator $generator): string
    {
        $elements = array();
        foreach ($this->params as $data) {
            Validate::validateElementParam($data);
            $elements[] = new Element($data['loc'], new \DateTime($data['lastmod']),  $data['priority'], $data['changefreq']);
        }

        $fileData = $generator->buildData($elements);
        return $this->writeToFile($fileData);
    }

    /**
     * @throws FileCreateException
     * @throws FileWriteException
     */
    public function writeToFile(string $data): string
    {
        try {
            $path = $this->pathForSave . '/sitemap.' . $this->resultFileType->value;
            $file = fopen($path, "w") or throw new FileCreateException($path);
            fwrite($file, $data) or throw new FileWriteException($path);
            fclose($file);
        }catch (FileWriteException|FileCreateException $exception){
            return $exception->getMessage();
        }

        return $path;
    }
}