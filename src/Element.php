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
     * @param array $pageParam ["loc"=>"https://site.ru/", "lastmod"=>"2020-12-14", "priority"=>1, "changefreq"=>"hourly"]
     * @throws CreateSiteMapElementException
     */
    public function __construct(array $pageParam)
    {
        if (empty($pageParam['loc'])) {
            throw new CreateSiteMapElementException('"loc" empty');
        } else {
            $this->loc = $pageParam['loc'];
        }

        if (empty($pageParam['lastmod'])) {
            throw new CreateSiteMapElementException('"lastmod" empty');
        } else {
            try {
                $this->lastmod = new DateTime($pageParam['lastmod']);
            } catch (\Exception $exception) {
                throw new CreateSiteMapElementException($exception);
            }
        }

        if (empty($pageParam['priority'])) {
            throw new CreateSiteMapElementException('"lastmod" empty');
        } else if (!is_numeric($pageParam['priority'])) {
            throw new CreateSiteMapElementException('"lastmod" not numeric');
        } else {
            $this->priority = $pageParam['priority'];
        }

        if (empty($pageParam['changefreq'])) {
            throw new CreateSiteMapElementException('"lastmod" empty');
        } else {
            $this->changefreq = ChangeFreq::from($pageParam['changefreq']);
        }
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