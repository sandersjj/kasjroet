<?php

namespace Kasjroet\Controller;

use Zend\Stdlib\ArrayObject;
use Zend\View\Model\JsonModel;
use Zend\Stdlib\Hydrator;
use Kasjroet\Util\Hydrator\Product as ProductHydtrator;
use Kasjroet\Util\Hydrator\ProductGroups as ProductGroupsHydtrator;
use Kasjroet\Util\Hydrator\ProductGroup as ProductGroupHydtrator;

/**
 * Description of RestController
 *
 * @author jigal
 */
class ProductsRestController extends AbstractKasjroetRestController {

    public function get($id) {
        $request = $this->getRequest();
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

        $products = $repo->findAll();
        $productsArray = array();
        $hydrator = $this->getServiceLocator()->get('ProductHydrator');

        foreach($products as $product){
            $productsArray[] = $hydrator->extract($product);

        }
        return new JsonModel($productsArray);
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