<?php

namespace Estev\Sitemap\Interfaces;
use Estev\Sitemap\Element;

interface IGenerator
{

    /**
     * @param Element[] $elements
     * @return string
     */
    public function buildData(array $elements):string;
}