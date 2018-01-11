<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;

class DeviceRepository extends EntityRepository
{
    /**
     * @param $orderBy
     * @param $orderDirection
     * @return \Doctrine\ORM\Query
     */
    public function filter(array $filter = [], string $orderBy = null, string $orderDirection = 'ASC')
    {
        $qb = $this->createQueryBuilder('d');

        if (!empty($filter['deviceId'])) {
            $qb->andWhere($qb->expr()->like('d.deviceId', ':deviceId'))
                ->setParameter('deviceId', $filter['deviceId'].'%');
        }

        switch (strtolower($orderBy)) {
            case ('deviceId'):
                $qb->orderBy('d.deviceId', $orderDirection);
                break;
            case ('deviceLabel'):
                $qb->orderBy('d.deviceLabel', $orderDirection);
                break;
            default:
                $qb->orderBy('d.id', $orderDirection);
        }

        return $qb->getQuery();
    }

    /**
     * @return mixed
     */
    public function getCount()
    {
        $qb = $this->createQueryBuilder('d');

        return $qb
            ->select('count(d.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
