<?php

namespace Kasjroet\Controller;

use Zend\View\Model\JsonModel;


/**
 * Description of RestController
 *
 * @author jigal
 */
class ProductsController extends AbstractKasjroetRestController {

   

    //Call Komt Binnen
    //Systeem haalt een lijst op van producten 
    //Als er geen producten zijn lege array
    //Return data is Json

    
//    /**
//     * 
//     * @return type
//     */
//    public function options() {
//        $response = $this->getResponse();
//        $headers = $response->getHeaders();
//
//        $model = $this->acceptableViewModelSelector($this->viewModelMap);
//
//
//        if ($this->params()->fromRoute('id', false)) {
//            $headers->addHeaderLine('Allow', implode(',', $this->allowedResourceMethods));
//            $model->setVariables($this->getResourceDocumentationSpec());
//            return $model();
//        }
//
//
//        $headers->addHeaderLine('Allow', implode(',', $this->allowedCollectionMethods));
//        $model->setVariables($this->getResourceDocumentationSpec());
//        return $model();
//    }

    public function get($id) {
        $response = $this->getResponseWithHeader()
                ->setMetadata('HTTP', 200)
                ->setContent(__METHOD__ . ' get current data with id =  ' );
        return $response;
    }

    public function getList() {
        $em = $this->getEntityManager();
        $repo = $em->getRepository('Kasjroet\Entity\Product');
        $response = $this->getResponseWithHeader()
                ->setContent($repo->listProducts());
        return $response;
    }

    public function create($data) {
        $em = $this->getEntityManager();
        $repo = $em->getRepository('Kasjroet\Entity\Product');
        if($repo->addNewBrand(array())){
            $response = $this->getResponseWithHeader()
                    ->setMetadata('HTTP', 201)
                    ->setContent(__METHOD__ . ' create new item of data :');
        }else{
            $response = $this->getResponseWithHeader()
                    ->setStatusCode(202)
                    ->setContent(__METHOD__ . ' create new item of data :');
        }
        
        
        return $response;

    }

    public function update($id, $data) {
        $response = $this->getResponseWithHeader()
                ->setContent(__METHOD__ . ' update current data with id =  ' . $id .
                ' with data of name is ' . $data['name']);
        return $response;
    }

    public function delete($id) {
        $response = $this->getResponseWithHeader()
                ->setContent(__METHOD__ . ' delete current data with id =  ' . $id);
        return $response;
    }


    

}
