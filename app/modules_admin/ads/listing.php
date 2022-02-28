<?php
namespace App\modules\ads;

use App\classes\ClassAds;

class listing extends \App\views\Genere_views {

    public $container;

    public function __construct($container){
        $this->container = $container;
    }

    public function process($request, $response) {
            $ads = new ClassAds($this->container);
            $datas = [];
        // $request = $request->withAttribute('datas', $datas);
        // return $this->render($request,$response, 'abonnements/modification');

    }

}