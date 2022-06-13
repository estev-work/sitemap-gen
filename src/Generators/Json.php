<?php

namespace Estev\Sitemap\Generators;

use Estev\Sitemap\Element;
use Estev\Sitemap\Interfaces\IGenerator;

class Json implements IGenerator
{
    /**
     * @param Element[] $elements
     * @return string
     */
    public function buildData(array $elements): string
    {
        $data = array();
        foreach ($elements as $element){
            $data[] = array(
                'loc'=>$element->getLoc(),
                'lastmod'=>$element->getLastmod(),
                'priority'=>$element->getPriority(),
                'changefreq'=>$element->getChangefreq(),
            );
        }
        return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
        //return str_replace("\/","/",json_encode($elements, 0,JSON_UNESCAPED_SLASHES));
    }
}