<?php

namespace Estev\Sitemap\Exceptions;

use JetBrains\PhpStorm\Pure;

class CreateSiteMapElementException extends \Exception
{
    #[Pure] public function __construct(string $errorObject)
    {
        parent::__construct(sprintf('[CreateSiteMapElementException] %s', $errorObject));
    }
}