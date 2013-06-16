<?php

namespace Kasjroet\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;

/**
 * @ORM\Entity
 * @ORM\Table(name="memo")
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ArraySerializable")
 */

class Memo {

    /**
     * @ORM\id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column 
     */
    protected $memo;
    
    


}