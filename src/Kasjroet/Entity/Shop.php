<?php
/**
 * Created by PhpStorm.
 * User: jigal
 * Date: 4/13/14
 * Time: 4:08 PM
 */
namespace Kasjroet\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @todo add Geo Location
 */


/**
 * Class Shop
 * @ORM\Entity$this
 * @ORM\Table(name="Shop")
 */
class Shop {

	/**
	 * @ORM\id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 * @ORM\Column(type="integer")
	 */
	protected $id;

	/**
	 * @ORM\Column(type="string", length=50, unique=true, nullable=false)
	 *
	 */
	protected $shopName;

	/**
	 * @ORM\Column(type="string", length=50, unique=true, nullable=false)
	 *
	 */
	protected $street;

	/**
	 * @ORM\Column(type="string", length=50, unique=true, nullable=false)
	 *
	 */
	protected $houseNo;

	/**
	 * @ORM\Column(type="string", length=50, unique=true, nullable=false)
	 *
	 */
	protected $zipcode;


	/**
	 * @ORM\Column(type="string", length=50, unique=true, nullable=false)
	 *
	 */
	protected $city;

	/**
	 * @ORM\Column(type="string", length=50, unique=true, nullable=false)
	 *
	 */
	protected $country;


	/**
	 * @ORM\Column(type="string", length=50, unique=true, nullable=false)
	 *
	 */
	protected $phoneNumber;

	/**
	 * @ORM\Column(type="string", length=50, unique=true, nullable=false)
	 *
	 */
	protected $fax;

	/**
	 * @ORM\Column(type="string", length=50, unique=true, nullable=false)
	 *
	 */
	protected $email;

	/**
	 * @ORM\Column(type="string", length=50, unique=true, nullable=false)
	 *
	 */
	protected $website;

	/**
	 * @param mixed $city
	 */
	public function setCity($city)
	{
		$this->city = $city;
	}

	/**
	 * @return mixed
	 */
	public function getCity()
	{
		return $this->city;
	}

	/**
	 * @param mixed $country
	 */
	public function setCountry($country)
	{
		$this->country = $country;
	}

	/**
	 * @return mixed
	 */
	public function getCountry()
	{
		return $this->country;
	}

	/**
	 * @param mixed $email
	 */
	public function setEmail($email)
	{
		$this->email = $email;
	}

	/**
	 * @return mixed
	 */
	public function getEmail()
	{
		return $this->email;
	}

	/**
	 * @param mixed $fax
	 */
	public function setFax($fax)
	{
		$this->fax = $fax;
	}

	/**
	 * @return mixed
	 */
	public function getFax()
	{
		return $this->fax;
	}

	/**
	 * @param mixed $houseNo
	 */
	public function setHouseNo($houseNo)
	{
		$this->houseNo = $houseNo;
	}

	/**
	 * @return mixed
	 */
	public function getHouseNo()
	{
		return $this->houseNo;
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
	 * @param mixed $phoneNumber
	 */
	public function setPhoneNumber($phoneNumber)
	{
		$this->phoneNumber = $phoneNumber;
	}

	/**
	 * @return mixed
	 */
	public function getPhoneNumber()
	{
		return $this->phoneNumber;
	}

	/**
	 * @param mixed $shopName
	 */
	public function setShopName($shopName)
	{
		$this->shopName = $shopName;
	}

	/**
	 * @return mixed
	 */
	public function getShopName()
	{
		return $this->shopName;
	}

	/**
	 * @param mixed $street
	 */
	public function setStreet($street)
	{
		$this->street = $street;
	}

	/**
	 * @return mixed
	 */
	public function getStreet()
	{
		return $this->street;
	}

	/**
	 * @param mixed $zipcode
	 */
	public function setZipcode($zipcode)
	{
		$this->zipcode = $zipcode;
	}

	/**
	 * @return mixed
	 */
	public function getZipcode()
	{
		return $this->zipcode;
	}





} 