<?php
namespace Kasjroet\EntityRepository;


use \Doctrine\ORM\EntityRepository as EntityRepository;
use Doctrine\Common\Collections;
use Kasjroet\Entity\Product as EntityProduct;
use Kasjroet\Entity\Brand;
/**
 * Description of Product
 *
 * @author jigal
 */
class Product extends EntityRepository{
    
    protected $_em;
    
    public function __construct($em, \Doctrine\ORM\Mapping\ClassMetadata $class) {
        parent::__construct($em, $class);
        $this->_em = $this->getEntityManager();
    }
    
    public function listProducts(){
        $em = $this->getEntityManager();
        return $this->findAll();
    }

    public function getProducts(){
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('p')
            ->from('Kasjroet\Entity\Product', 'p');
      return new Collections\ArrayCollection($qb->getQuery()->getResult());
    }

    /**
     * @param $id
     * @return Collections\ArrayCollection
     */
    public function getProductsByProductGroup($id){

        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('p')
            ->from('Kasjroet\Entity\Product', 'p')
            ->leftJoin('p.productGroups', 'pg')
            ->where('pg.id = :productgroup_id')
            ->setParameter(':productgroup_id', $id);
        return new Collections\ArrayCollection($qb->getQuery()->getResult());
    }
    /**
     * 
     * @param type $id
     * @param type $productData
     */
    public function editProduct($id, $productData){
        $em = $this->getEntityManager();

            $productGroupsArray  =$productData->productGroups;
            $hechsheriemArray = $productData->hechsheriem;

            $product = $this->find($id);

            $product->setProductName($productData->productName);
            $product->setDescription($productData->description);
            $product->setVisible($productData->visible);
            if (!empty($productGroupsArray )) {
                $productGroups = $this->getEntityManager()->getRepository('Kasjroet\Entity\ProductGroup')->findList($productGroupsArray );
                $product->setProductGroups($productGroups);
            } else {
                $product->unsetProductsGroups();
            }

            if (!empty($hechsheriemArray )) {
                $hechsheriem = $this->getEntityManager()->getRepository('Kasjroet\Entity\Hechsher')->findList($hechsheriemArray );
                $product->setHechsheriem($hechsheriem);
            } else {
                $product->unsetHechsheriem();
            }
            
            if(isset($productData['brand'])){
                $brand = $this->getEntityManager()->getRepository('Kasjroet\Entity\Brand')->find($productData['brand']['id']);
                $product->setBrand($brand);
            }

            $em->persist($product);
            $em->flush();

    }
    
    /**
     * @param type $productData
     * @return type
     */
    public function addProduct($productData){
        $em = $this->getEntityManager();

        $model = new EntityProduct();
        $brand = $em->find('Kasjroet\Entity\Brand',$productData['brand']);
        $model->setBrand($brand);
        $model->setProductName($productData['productName']);
        $model->setDescription($productData['description']);
        $model->setBrand($productData['brand']);
        $model->setVisible(false);

        try{
            $em->persist($model);
            $em->flush();
        }catch(\Doctrine\ORM\UnexpectedResultException $e){

            var_dump($e);
            exit;
        }
        
        return;
    }
    /**
     * removes a product
     * @todo consider soft delete 
     * @param type $id
     */
    public function removeProduct($id){
        $em = $this->getEntityManager();
        if($id){
            $product = $this->find($id);
            if($product){
                $em->remove($product);
                $em->flush();
            }
        }
    }
    
    public function addNewBrand($brandData = nulll){
        $result = false;
        if (!$this->_em->getRepository('Kasjroet\Entity\Brand')->findOneBy(array('brandName' => 'Heints'))) {
            $model = new \Kasjroet\Entity\Brand();
            $model->setBrandName('Heints');
        
            $this->_em->persist($model);
            $this->_em->flush();
            $result = true;
        }
        return $result;
    }
 }