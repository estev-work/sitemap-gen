<?php

namespace Estev\Sitemap\Exceptions;

use JetBrains\PhpStorm\Pure;

class FileWriteException extends \Exception
{
    /**
     * @param string $path
     */
    #[Pure] public function __construct(string $path)
    {
        parent::__construct('[FileWriteException] File ('.$path.') write error.', 0, null);
    }
}