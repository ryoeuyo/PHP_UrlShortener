<?php

namespace App\Infrastructure\Persistence\Cache;

use App\Application\ShortenUrl\Domain\Entity\ShortenUrl as DomainShortenUrl;
use App\Application\ShortenUrl\Domain\Repository\ShortenUrlRepositoryInterface;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\DependencyInjection\Attribute\AsDecorator;
use Symfony\Component\DependencyInjection\Attribute\AutowireDecorated;
use Symfony\Component\DependencyInjection\Attribute\Target;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

#[AsDecorator(decorates: ShortenUrlRepositoryInterface::class)]
final readonly class CachedShortenUrlRepository implements ShortenUrlRepositoryInterface
{
    private const KEY_PREFIX = 'shorten_url.';

    public function __construct(
        #[AutowireDecorated] private ShortenUrlRepositoryInterface $inner,
        #[Target('cache.shorten_url')] private CacheInterface $cache,
    ) {
    }

    /**
     * @throws InvalidArgumentException
     */
    public function save(DomainShortenUrl $shortenUrl): DomainShortenUrl
    {
        $saved = $this->inner->save($shortenUrl);
        $this->cache->delete(
            $this->key($saved->alias)
        );

        return $saved;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function findActiveByAlias(string $alias): ?DomainShortenUrl
    {
        return $this->cache->get(
            'shorten_url.' . $alias,
            function (ItemInterface $item) use ($alias): ?DomainShortenUrl {
                $url = $this->inner->findActiveByAlias($alias);

                $item->expiresAfter($url === null ? 60 : 3600);

                return $url;
            },
        );
    }

    private function key(string $alias): string
    {
        return self::KEY_PREFIX . $alias;
    }
}
