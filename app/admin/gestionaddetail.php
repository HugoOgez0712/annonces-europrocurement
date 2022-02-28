<?php

namespace App\admin;

use App\helpers\Util;
use App\helpers\Pagination;
use App\helpers\PaginationBis;
use App\helpers\Validation;
use App\classes\ClassAds;

class gestionaddetail extends \App\views\Genere_admin {

    public $container;

    public function __construct($container){
        $this->container = $container;
    }

    public function process($request, $response) {
        $datas = array();
        $datas['test'] = 'test';
        $id = $request->getAttribute('id');
        if(!$id){
            $this->flash('success', 'Page introuvable !');
            return $this->redirect($request, $response, 200, 'admin.gestionads');
        }


        $ads = new ClassAds($this->container);
        $currentAd = $ads->getAd($id);

        $currentItems = $ads->getItems($id);

        $defaultItems = $ads->getCatsAndItems($currentAd->ann_cat_id);

        // $var = 'test';
        // $test = 'test 2';
        // echo '$test est égale à ' . $test . '<br>';
        // echo '$var est égale à : ' . $var . '<br>';
        // echo '$$var est égale à  : ' . $$var . '<br>';

 
 
        $datas['js'] = 'admin_addetail';

        $datas['currentAd'] = $currentAd;

        $datas['default'] = $defaultItems;

        $datas['currentItems'] = $currentItems;

        $datas['item_types'] = $ads->getItemTypes();

        $datas['images'] = $ads->getImagesAdmin($id);

        $request = $request->withAttribute('datas', $datas);
        return $this->render($request,$response, 'admin/gestionaddetail');

    }

}