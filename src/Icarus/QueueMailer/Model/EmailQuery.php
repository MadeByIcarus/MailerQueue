<?php

namespace Icarus\QueueMailer\Model;


use Icarus\Doctrine\QueryObject\TQueryObjectFilter;
use Kdyby;
use Kdyby\Doctrine\QueryBuilder;
use Kdyby\Doctrine\QueryObject;


class EmailQuery extends QueryObject
{

    use TQueryObjectFilter;

    const ALIAS = "email";

    public function notSent()
    {
        $this->filter[] = function (QueryBuilder $qb) {
            $qb->andWhere(self::ALIAS."sent IS NULL");
        };
        return $this;
    }



    /**
     * @param \Kdyby\Persistence\Queryable $repository
     * @return \Doctrine\ORM\Query|\Doctrine\ORM\QueryBuilder
     */
    protected function doCreateQuery(Kdyby\Persistence\Queryable $repository)
    {
        $qb = $repository->createQueryBuilder()
            ->select(self::ALIAS)
            ->from(Email::class, self::ALIAS);

        return $this->applyFilter($qb);
    }
}