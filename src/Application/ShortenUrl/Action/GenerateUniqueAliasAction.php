<?php

namespace App\Application\ShortenUrl\Action;

use App\Application\Common\Domain\Util\RandomStringProviderInterface;
use App\Application\ShortenUrl\Assert\ShortenUrlNotExistsByAliasAssert;
use App\Application\ShortenUrl\Domain\Exception\ShortenUrlAlreadyExistsException;

final readonly class GenerateUniqueAliasAction
{
    private const GENERATE_ALIAS_TRIES = 5;

    public function __construct(
        private int $length,
        private ShortenUrlNotExistsByAliasAssert $shortenUrlNotExistsByAliasAssert,
        private RandomStringProviderInterface $randomStringProvider,
    ) {
    }

    public function run(): string
    {
        $tries = self::GENERATE_ALIAS_TRIES;

        while ($tries--) {
            try {
                $alias = $this->randomStringProvider->provide($this->length);
                $this->shortenUrlNotExistsByAliasAssert->assert($alias);

                return $alias;
            } catch (ShortenUrlAlreadyExistsException) {
            }
        }

        throw new ShortenUrlAlreadyExistsException();
    }
}
