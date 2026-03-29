<?php

namespace App\Application\ShortenUrl\Action;

use App\Application\ShortenUrl\Assert\ShortenUrlNotExistsByAliasAssert;
use App\Application\ShortenUrl\Domain\Exception\ShortenUrlAlreadyExistsException;
use Random\RandomException;
use Symfony\Component\String\ByteString;

final readonly class GenerateUniqueAliasAction
{
    private const GENERATE_ALIAS_TRIES = 5;

    public function __construct(
        private string $length,
        private ShortenUrlNotExistsByAliasAssert $shortenUrlNotExistsByAliasAssert
    ) {
    }

    /**
     * @throws RandomException
     */
    public function run(): string
    {
        $tries = self::GENERATE_ALIAS_TRIES;
        while ($tries--) {
            try {
                $alias = ByteString::fromRandom($this->length)->toString();
                $this->shortenUrlNotExistsByAliasAssert->assert($alias);

                return $alias;
            } catch (ShortenUrlAlreadyExistsException $e) {
            }
        }

        throw new ShortenUrlAlreadyExistsException();
    }
}
