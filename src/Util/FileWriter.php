<?php

namespace Estev\Sitemap\Util;

use Estev\Sitemap\Enums\FileType;
use Estev\Sitemap\Exceptions\FileCreateException;
use Estev\Sitemap\Exceptions\FileWriteException;

class FileWriter
{
    /**
     * @param string $data
     * @return string
     */
    public static function writeToFile(string $data, string $pathForSave, FileType $resultFileType): string
    {
        try {
            if (!file_exists($pathForSave )) {
                mkdir($pathForSave, 0644, true);
            }
            $path = $pathForSave . '/sitemap.' . $resultFileType->value;
            $file = fopen($path, "w") or throw new FileCreateException($path);
            fwrite($file, $data) or throw new FileWriteException($path);
            fclose($file);
        }catch (FileWriteException|FileCreateException $exception){
            return $exception->getMessage();
        }

        return $path;
    }
}