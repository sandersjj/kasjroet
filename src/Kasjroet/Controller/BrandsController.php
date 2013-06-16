<?php

namespace Kasjroet\Controller;
/**
 * Description of BrandsController
 * @ORM\Entity(repositoryClass="Kasjroet\EntityRepository\Brand ")
 * @author jigal
 */
class BrandsController extends AbstractKasjroetRestController {
    
    //put your code here
    
    public function create($data) {
        
        $result = false;
        $response = $this->getResponseWithHeader();
        if(!empty($data) && is_array($data))
        {
            $em = $this->getEntityManager();
            $repo = $em->getRepository('Kasjroet\Entity\Brand');
            if(!$repo->findOneBy(array('brandName' => $data['brandName']))){
                $model = new \Kasjroet\Entity\Brand();
                $model->setBrandName($data['brandName']);
                $em->persist($model);
                $em->flush();
                $result = true;

            }
        }
        if($result){
            $response->setStatusCode(201);
        }else{
            $response->setStatusCode(202);
        }
        return $response;
    }
    
    
    public function getList(){
        $em = $this->getEntityManager();
        $repo = $em->getRepository('Kasjroet\Entity\Brand');
        $result = $repo->findAll();
        $response = $this->getResponseWithHeader();
        $response->setContent($result);
        
        return $response;
    }
    
}

