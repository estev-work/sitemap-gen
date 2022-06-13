<?php

namespace Estev\Sitemap\Exceptions;

use JetBrains\PhpStorm\Pure;

class FileCreateException extends \Exception
{
    /**
     * @param string $path
     */
    #[Pure] public function __construct(string $path)
    {
        parent::__construct('[FileCreateException] File ('.$path.') create error.');
    }
}