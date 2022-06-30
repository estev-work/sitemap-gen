<?php

namespace Estev\Sitemap\Util;

use DateTime;
use Estev\Sitemap\Element;
use Estev\Sitemap\Enums\ChangeFreq;
use Estev\Sitemap\Exceptions\CreateSiteMapElementException;

class Validate
{
    /**
     * @param array $pageParam ["loc"=>"https://site.ru/", "lastmod"=>"2020-12-14", "priority"=>1, "changefreq"=>"hourly"]
     * @throws CreateSiteMapElementException
     * @throws \Exception
     */
    public static function validateElementParam(array &$pageParam): void
    {
        self::checkEmpty($pageParam, 'loc');
        self::checkEmpty($pageParam, 'lastmod');
        self::checkEmpty($pageParam, 'priority');
        self::checkEmpty($pageParam, 'changefreq');

        $dateData = date_parse($pageParam['lastmod']);
        if (count($dateData['errors'])) {
            throw new CreateSiteMapElementException('"lastmod" date not valid');
        }

        if (!is_numeric($pageParam['priority'])) {
            throw new CreateSiteMapElementException('"lastmod" not numeric');
        }

        if (ChangeFreq::from($pageParam['changefreq']) == null){
            throw new CreateSiteMapElementException('"changefreq" not valid ('.$pageParam['changefreq'].')');
        }
    }

    /**
     * @throws CreateSiteMapElementException
     */
    private static function checkEmpty(array $pageParams, string $paramName): void
    {
        if (empty($pageParams[$paramName])) {
            throw new CreateSiteMapElementException('"'.$paramName.'" empty');
        }
    }
}