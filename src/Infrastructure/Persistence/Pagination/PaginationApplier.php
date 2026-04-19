<?php

namespace App\Infrastructure\Persistence\Pagination;

use App\Application\Common\Domain\ValueObject\Pagination;
use Doctrine\ORM\QueryBuilder;

final readonly class PaginationApplier
{
    public static function apply(QueryBuilder $qb, Pagination $pagination): QueryBuilder
    {
        return $qb->setMaxResults($pagination->limit)
            ->setFirstResult($pagination->offset);
    }
}
