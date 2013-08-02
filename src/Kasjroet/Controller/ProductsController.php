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
        $request = $this->getRequest();
        var_dump($request->getHeaders()->get('Accept')->getFieldValue());

        exit;
        $id = (int) $this->getEvent()->getRouteMatch()->getParam('id');
        if($id && is_numeric($id)){

            $em = $this->getEntityManager();
            $repo = $em->getRepository('Kasjroet\Entity\Product');
            $product = $repo->find($id);
            if($product){
                $response = $this->getResponseWithHeader()
                    ->setStatusCode(self::OK_200)
                    ->setContent(json_encode($product));
            }else{
                $response = $this->getResponseWithHeader()
                    ->setStatusCode(self::NOT_FOUND_404);
            }
        }else{
            $response = $this->getResponseWithHeader()
                ->setStatusCode(self::BAD_REQUEST_400);
        }
        return $response;
    }

    /**
     * returns a list with all products
     * @return mixed|void
     */
    public function getList() {

        $em = $this->getEntityManager();
        $repo = $em->getRepository('Kasjroet\Entity\Product');
        $response = $this->getResponseWithHeader()
                    ->setStatusCode(200)
                    ->setContent($repo->findAll());
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
