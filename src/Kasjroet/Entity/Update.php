<?php
namespace Kasjroet\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Zend\Form\Annotation;

/**
 * @ORM\Entity
 * @ORM\Table(name="Update")
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ArraySerializable")
 * @Annotation\Name("Update")
 */
class Update {

    /**
     * @ORM\id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\
     */
    protected $product;
    protected $processed;
    public function __construct() {
        $this->products = new ArrayCollection();
    }


}
