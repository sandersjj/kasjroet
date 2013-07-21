<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jigal
 * Date: 7/21/13
 * Time: 11:16 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Kasjroet\EntityRepository;


use Doctrine\ORM\EntityRepository;
use Doctrine\Common\Collections;

class ProductGroup extends EntityRepository {

    /**
     * Function returns all related product groups in one go.
     * @param array $ids
     * @return Collections\ArrayCollection
     */
    public function findList($ids) {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('pq')
            ->from('Kasjroet\Entity\ProductGroup', 'pq')
            ->where('pq.id IN (:ids)')
            ->setParameter('ids', $ids);
        return new Collections\ArrayCollection($qb->getQuery()->getResult());
    }

}