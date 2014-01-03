<?php
namespace Kasjroet\EntityRepository;

use Doctrine\ORM\EntityRepository as EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata as ClassMetadata;
use Doctrine\DBAL\DBALException;
use Doctrine\ORM\UnexpectedResultException;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Kasjroet\Entity\Brand as BrandEntity;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory;

class Brand extends EntityRepository
{
	protected $em;

    /**
     * @param \Doctrine\ORM\EntityManager $em
     * @param ClassMetadata $class
     */
    public function __construct($em,ClassMetadata $class )
	{
		parent::__construct($em, $class);
		$this->em = $em;
	}

    /**
     * This function adds a brand to the repository
     * @param $data
     */
    public function addBrand($data)
	{
        try {
            $hydrator = $this->getHydrator();
            $brand = $hydrator->hydrate($data, new BrandEntity());
            $this->em->persist($brand);
            $this->em->flush();
        } catch (UnexpectedResultException $e) {
            var_dump($e);
            exit;
        }
	}

    /**
     * @param $brand
     * @return bool
     */
    public function updateBrand($id, $brandData)
    {
        try{

            $brand = $this->find($id);
            $hydrator = $this->getHydrator();
            $brand = $hydrator->hydrate($brandData, $brand);
            $this->em->persist($brand);
            $this->em->flush();
        } catch(UnexpectedResultException $e) {
            var_dump($e);
            exit;
        }
        return true;
    }

    public function removeBrand($id)
    {
        try {
            $brand = $this->find($id);
            $this->em->remove($brand);
            $this->em->flush();
        } catch (DBALException $e) {
            return $e->getMessage();
        }
    }

    private function getHydrator()
    {
        return  new DoctrineHydrator($this->em, 'Kasjroet\Entity\Brand');
    }
} 