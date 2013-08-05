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
     * @ORM\Column(unique=true)
     */
    protected $hechsherName;
    
    /**
     * @ORM\Column
     */
    protected $hechsherDescription;

    /**
     * @ORM\Column
     */
    protected $url;

    /**
     * @ORM\Column
     */
    protected $address;
    /**
     *  @ORM\Column(type="blob")
     */
    protected $hechsherstamp;

    public function __toString(){
        return $this->hechsherName;
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

}

