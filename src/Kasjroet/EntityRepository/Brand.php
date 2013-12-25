<?php
namespace Kasjroet\EntityRepository;

use Doctrine\ORM\EntityRepository as EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata as ClassMetadata;
use Doctrine\ORM\UnexpectedResultException;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Kasjroet\Entity\Brand as BrandEntity;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory;

class Brand extends EntityRepository
{
	protected $em;

	public function __construct($em,ClassMetadata $class )
	{
		parent::__construct($em, $class);
		$this->em = $em;
	}

	public function addBrand($data)
	{
        try {
            $hydrator = new DoctrineHydrator($this->em, 'Kasjroet\Entity\Brand');
            $brand = $hydrator->hydrate($data, new BrandEntity());
            $this->em->persist($brand);
            $this->em->flush();
        } catch (UnexpectedResultException $e) {
            var_dump($e);
            exit;
        }
	}
} 