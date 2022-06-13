<?php

namespace Estev\Sitemap\Enums;

enum FileType:string
{
    case Csv = 'csv';
    case Xml = 'xml';
    case Json = 'json';
}