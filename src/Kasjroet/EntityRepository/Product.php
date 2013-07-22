<?php
namespace Kasjroet\EntityRepository;


use \Doctrine\ORM\EntityRepository as EntityRepository;
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
    
    public function addNewProduct($productData){
        $em = $this->getEntityManager();
        //Check if product exists
        $model = new \Kasjroet\Entity\Product();
        $model->setProductName($productData['productName']);
        $model->setDescription($productData['description']);
        $model->setVisible(false);
        
        
        if(isset($productData['brand'])){
            $brand = new \Kasjroet\Entity\Brand();
            $brand->setId($productData['brand']['id']);
            $brand->setBrandName($productData['brand']['id']);
            $model->setBrand($brand);
        }
        
  
        try{
            $em->persist($model);
            $em->flush();
        }catch(\Doctrine\ORM\UnexpectedResultException $e){
              
            
        }
        
        return;
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


