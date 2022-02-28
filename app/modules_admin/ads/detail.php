<?php
namespace App\modules\ads;

use App\helpers\Util;
use App\helpers\Pagination;
use App\helpers\PaginationBis;
use App\helpers\Validation;
use App\classes\ClassAds;

class listing extends \App\views\Genere_views {

    public $container;

    public function __construct($container){
        $this->container = $container;
    }

    public function process($request, $response) {
        $datas = array();
        $datas['test'] = 'test';
        $urlExpl =  explode('-', $_SERVER['REQUEST_URI']);
        $id = (int)$urlExpl[2];
        $ads = new ClassAds($this->container);
        $list = $ads->getAds();
        $currentAd = $ads->getAd($id);

        $datas['list'] = $list;

        $request = $request->withAttribute('datas', $datas);
        return $this->render($request,$response, 'ads/listing');

    }

}