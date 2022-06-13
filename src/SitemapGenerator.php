<?php

namespace Estev\Sitemap;

use Estev\Sitemap\Enums\FileType;
use Estev\Sitemap\Exceptions\EmptyParamsArrayException;
use Estev\Sitemap\Exceptions\FileCreateException;
use Estev\Sitemap\Exceptions\FileWriteException;
use Estev\Sitemap\Generators\Csv;
use Estev\Sitemap\Generators\Json;
use Estev\Sitemap\Generators\Xml;
use Estev\Sitemap\Interfaces\IGenerator;

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
     * @throws Exceptions\CreateSiteMapElementException
     */
    public function create():string | false
    {
        if ($this->resultFileType == FileType::Json) {
            return $this->build(new Json());
        } elseif ($this->resultFileType == FileType::Csv) {
            return $this->build(new Csv());
        } elseif ($this->resultFileType == FileType::Xml) {
            return $this->build(new Xml());
        }else{
            return false;
        }
    }
    /**
     * @throws Exceptions\CreateSiteMapElementException
     * @throws \Exception
     */
    private function build(IGenerator $generator): string
    {
        $elements = array();
        foreach ($this->params as $data) {
            $elements[] = new Element($data);
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