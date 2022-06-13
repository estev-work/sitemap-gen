<?php

namespace Estev\Sitemap\Generators;

use Estev\Sitemap\Element;
use Estev\Sitemap\Interfaces\IGenerator;

class Csv implements IGenerator
{
    /**
     * @param Element[] $elements
     * @return string
     */
    public function buildData(array $elements): string
    {
        $rows = 'loc;lastmod;priority;changefreq\r\n';
        foreach ($elements as $element){
            $rows.= $element->getLoc().';'.$element->getLastmod().';'.$element->getPriority().';'.$element->getChangefreq().'\r\n';
        }
        return $rows;
    }
}