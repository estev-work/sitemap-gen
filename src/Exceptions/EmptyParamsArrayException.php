<?php

namespace Estev\Sitemap\Exceptions;
use JetBrains\PhpStorm\Pure;

class EmptyParamsArrayException extends \Exception
{
    #[Pure] public function __construct()
    {
        parent::__construct("[EmptyParamsArrayException] Array params empty.");
    }
}