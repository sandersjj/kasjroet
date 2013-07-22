<?php

namespace Kasjroet\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Kasjroet\EntityRepository\Hechsher")
 * @ORM\Table(name="Hechsher")
 */
class Hechsher {
    /**
     * @ORM\id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;
    
    /**
     * @ORM\Column
     */
    protected $hechsherName;
    
    /**
     * @ORM\Column
     */
    protected $hechsherDescription;

    public function __toString(){
        return $this->hechsherName;
    }

}

