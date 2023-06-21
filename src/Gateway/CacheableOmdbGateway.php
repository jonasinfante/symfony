<?php

namespace App\Gateway;

use Symfony\Component\DependencyInjection\Attribute\AsDecorator;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

#[AsDecorator(OmdbGateway::class)]
class CacheableOmdbGateway extends OmdbGateway
{
    public function __construct(
        private readonly OmdbGateway $omdbGateway,
        private readonly CacheInterface $cache,
    )
    {
    }

    public function getPoster(string $title): ?string
    {
        $cacheKey = 'poster_' . md5($title);

        return $this->cache->get(
            $cacheKey,
            function (ItemInterface $cacheItem) use ($title): ?string  {
                $cacheItem->expiresAfter(10);
                return $this->omdbGateway->getPoster($title);
            }
        );
    }
}