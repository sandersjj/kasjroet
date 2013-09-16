<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jigal
 * Date: 9/16/13
 * Time: 4:50 PM
 * To change this template use File | Settings | File Templates.
 */

namespace KasjroetTest\Assets\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Product
 * @package KasjroetTest\Assets\Entity
 * @ORM\Entity
 * @ORM\Table(name="
 * ")
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

    /**
     * @param mixed $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $hechsherDescription
     */
    public function setHechsherDescription($hechsherDescription)
    {
        $this->hechsherDescription = $hechsherDescription;
    }

    /**
     * @return mixed
     */
    public function getHechsherDescription()
    {
        return $this->hechsherDescription;
    }

    /**
     * @param mixed $hechsherName
     */
    public function setHechsherName($hechsherName)
    {
        $this->hechsherName = $hechsherName;
    }

    /**
     * @return mixed
     */
    public function getHechsherName()
    {
        return $this->hechsherName;
    }

    /**
     * @param mixed $hechsherstamp
     */
    public function setHechsherstamp($hechsherstamp)
    {
        $this->hechsherstamp = $hechsherstamp;
    }

    /**
     * @return mixed
     */
    public function getHechsherstamp()
    {
        return $this->hechsherstamp;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

}