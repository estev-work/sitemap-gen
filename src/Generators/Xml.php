<?php

namespace Estev\Sitemap\Generators;

use DateTimeInterface;
use Estev\Sitemap\Element;
use Estev\Sitemap\Interfaces\IGenerator;
use SimpleXMLElement;

class Xml implements IGenerator
{
    /**
     * @param Element[] $elements
     * @return string
     */
    public function buildData(array $elements): string
    {
        $xml = new SimpleXMLElement(
            '<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 
                  xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" 
                  xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9"></urlset>'
        );
        foreach ($elements as $index=>$value) {
            $url = $xml->addChild('url');
            $url->addChild("loc", htmlspecialchars($value->getLoc()));
            $url->addChild("lastmod", htmlspecialchars($value->getLastmod()));
            $url->addChild("priority", htmlspecialchars($value->getPriority()));
            $url->addChild("changefreq", htmlspecialchars($value->getChangefreq()));
        }
        return $xml->asXML();
    }
}