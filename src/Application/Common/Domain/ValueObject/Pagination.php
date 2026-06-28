<?php

namespace App\Application\Common\Domain\ValueObject;

final readonly class Pagination
{
    public int $offset;

    public function __construct(
        public int $page,
        public int $limit,
    ) {
        $this->offset = ($this->page - 1) * $limit;
    }
}
