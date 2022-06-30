<?php

namespace Estev\Sitemap;

use DateTime;
use Estev\Sitemap\Enums\ChangeFreq;
use Estev\Sitemap\Exceptions\CreateSiteMapElementException;

class Element
{
    private string $loc;
    private DateTime $lastmod;
    private float $priority;
    private ChangeFreq $changefreq;

    /**
     * @param string $loc
     * @param DateTime $lastmod
     * @param float $priority
     * @param ChangeFreq $changefreq
     * @throws CreateSiteMapElementException
     */
    public function __construct(string $loc, DateTime $lastmod, float $priority, ChangeFreq $changefreq)
    {
        $this->loc = $loc;
        $this->lastmod = $lastmod;
        $this->priority = $priority;
        $this->changefreq = $changefreq;
    }

    /**
     * @return string
     */
    public function getLoc(): string
    {
        return $this->loc;
    }

    /**
     * @return string
     */
    public function getLastmod(): string
    {
        //return $this->lastmod->format(\DateTimeInterface::W3C);
        return $this->lastmod->format('Y-m-d');
    }

    /**
     * @return float
     */
    public function getPriority(): float
    {
        return (float)$this->priority;
    }

    /**
     * @return string
     */
    public function getChangefreq(): string
    {
        return $this->changefreq->value;
    }
}