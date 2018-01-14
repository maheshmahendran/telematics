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
    public function filter(array $filter = [], string $orderBy = null, string $orderDirection = 'DESC')
    {
        $qb = $this->createQueryBuilder('d');

        $qb->leftJoin('AppBundle:Device','d2',Join::WITH, 'd.deviceId = d2.deviceId and d.id < d2.id');

        $qb->where('d2.id IS NULL');

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
            ->leftJoin('AppBundle:Device','d2',Join::WITH, 'd.deviceId = d2.deviceId and d.id < d2.id')
            ->where('d2.id IS NULL')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
