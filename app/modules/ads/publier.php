<?php
namespace App\modules\ads;

use App\helpers\Util;
use App\helpers\Pagination;
use App\helpers\PaginationBis;
use App\helpers\Validation;
use App\classes\ClassAds;

class publier extends \App\views\Genere_views {

    public $container;

    public function __construct($container){
        $this->container = $container;
        
    }

    public function process($request, $response) {
        $datas = array();
        $datas['test'] = 'test';
        $ads = new ClassAds($this->container);
        $v = ['bonjour'];
        // $publish = $ads->insertAd($v) ?null : null;

        // $datas['publish'] = $publish;

        $request = $request->withAttribute('datas', $datas);
        return $this->render($request,$response, 'ads/publier');

    }

}