<?php
namespace App\modules\ads;

use App\helpers\Util;
use App\helpers\Pagination;
use App\helpers\PaginationBis;
use App\helpers\Validation;
use App\classes\ClassAds;

class postsearchads extends \App\views\Genere_views {

    public $container;

    public function __construct($container){
        $this->container = $container;
        
    }

    public function process($request, $response) {

// il faut faire apparaitre sur la page listing 
        $ads = new ClassAds($this->container);
        $validation = new Validation($request->getParsedBody());
        $valid = $validation->getDatas();

        

        $nbpage = 10;
        $page = $request->getAttribute('page') ?? 0;

        // var_dump($valid);
        // Util::dump($valid, 'hello valid');
        $datas = array();

        $filtres = array();

        $redirect = null;
        $params = array();
        unset($_SESSION['ads']);

        if($valid && (!empty($valid['ville']) OR !empty($valid['search']) OR !empty($valid['cat'])) ){
            
            if(isset($valid['search']) && !empty($valid['search'])){
                $filtres[] = ' ann_titre LIKE "%' . $valid['search'] . '%" ';
                $_SESSION['ads']['search'] = $valid['search'];

            }
            if(isset($valid['ville']) && !empty($valid['ville'])){
                // $redirect = 'ads.listingville';
                $redirect = 'ads.listingville';
                $filtres[] = ' ann_geoloc LIKE "%' . $valid['ville'] . '%" ';
                $params['ann_geoloc'] =   $_SESSION['ads']['ann_geoloc'] = $valid['ville'];

            }
            if(isset($valid['cat']) && !empty($valid['cat'])){
                $redirect = is_null($redirect) ? 'ads.listingcategorie' : 'ads.listingcategorieville';
                $filtres[] = ' ann_cat_id = ' . $valid['cat'] . ' ';
                // A FAIRE : récup^érer le clug de la catégorie ET l'attribuer à $params['cat_slug']
                $slug = $ads->getCat($valid['cat'])->cat_slug;
              
                $params['cat'] = $_SESSION['ads']['cat'] = $valid['cat'];
                $params['cat_slug'] =  $_SESSION['ads']['cat_slug'] =  $slug;
            }
        }
        $redirect = is_null($redirect) ? 'ads.listing' : $redirect;

        $where = !empty($filtres) ? implode(' AND ',$filtres) : " 1";
        $_SESSION['ads']['where'] = $where;
        $_SESSION['ads']['post'] = true;

        $request = $request->withAttribute('datas', $datas);
        return $this->redirect($request,$response,200,$redirect,$params);   
    }
}