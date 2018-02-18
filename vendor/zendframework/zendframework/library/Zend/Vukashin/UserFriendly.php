<?php
namespace Zend\Vukashin;

use Zend\Mvc\Controller\AbstractActionController;
use GoogleMaps\Request;
use GoogleMaps\Geocoder;
use GMaps\Service\GoogleMap;

class UserFriendly extends AbstractActionController
{
    public function generateGoogleMap($address)
    {
        $request = new Request();
        $request->setAddress($address);
        
        $proxy = new Geocoder();
        $response = $proxy->geocode($request);
        $resultset=$response->getResults();
        $result = $resultset[0];
        $geometry = $result->getGeometry();
        $location = $geometry->getLocation();
         
        $config = array(
            'sensor' => 'true',
            'div_id' => 'map',
            'div_class' => 'grid_6',
            'zoom' => 17,
            'width' => "600px",
            'height' => "300px",
            'lat' => $location->getLat(),
            'lon' => $location->getLng(),
            'animation' => 'none',
        );
        
        $map = new GoogleMap();
        $map->initialize($config);
        $html = $map->generate();
        
        return $html;
    }
}