<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jigal
 * Date: 7/22/13
 * Time: 12:16 AM
 * To change this template use File | Settings | File Templates.
 */

namespace Kasjroet\EntityRepository;


use Doctrine\ORM\EntityRepository;
use Doctrine\Common\Collections;

class Hechsher extends EntityRepository{

    /**
     * Function returns all related product groups in one go.
     * @param array $ids
     * @return Collections\ArrayCollection
     */
    public function findList($ids) {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('h')
            ->from('Kasjroet\Entity\Hechsher', 'h')
            ->where('h.id IN (:ids)')
            ->setParameter('ids', $ids);
        return new Collections\ArrayCollection($qb->getQuery()->getResult());
    }
}