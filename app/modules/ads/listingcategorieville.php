<?php
namespace App\modules\ads;

use App\helpers\Util;
use App\helpers\Pagination;
use App\helpers\PaginationBis;
use App\helpers\Validation;
use App\classes\ClassAds;

class listingcategorieville extends \App\views\Genere_views {

    public $container;

    public function __construct($container){
        $this->container = $container;
        
    }

    public function process($request, $response) {
        $datas = array();
        // il faut faire apparaitre sur la page listing 
        $ads = new ClassAds($this->container);
        $validation = new Validation($request->getParsedBody());
        $valid = $validation->getDatas();
        $nbpage = 50;
        
        $page = $request->getAttribute('page') ?? 0;
        $cat_slug = $request->getAttribute('cat_slug') ?? null;
        $ann_geoloc = $request->getAttribute('ann_geoloc') ?? null;
        $cat_id = isset($cat_slug) ? $ads->getCatBySlug($cat_slug)->cat_id : null;
        $datas['cat'] = $ads->getCat($cat_id);
        $datas['ville'] = $ann_geoloc;


        if(isset($_SESSION['ads']['post']) && $_SESSION['ads']['post']){
            extract($_SESSION['ads']);
            unset($_SESSION['ads']['post']);
        }else{
            $cat_slug = $request->getAttribute('cat_slug') ?? null;
            $ann_geoloc = $request->getAttribute('ann_geoloc') ?? null;
            $cat_id = $ads->getCatBySlug($cat_slug)->cat_id;
            $where = ' ann_geoloc LIKE "%' . $ann_geoloc . '%" AND ann_cat_id = ' . $cat_id . ' '; 
            $_SESSION['ads']['ann_geoloc'] = $ann_geoloc;
            $_SESSION['ads']['cat_slug'] = $cat_slug;
            $_SESSION['ads']['where'] = $where;
        }


        $paramroute = array(
            'cat_slug' => $cat_slug,
            'ann_geoloc' => $ann_geoloc
        );

        $list = $ads->getAds($page, $nbpage, $where);
        $datas['list'] = $list;
        $tt = $ads->getTotal();
        $datas['tt'] = $tt;
        

        $nbPage = ceil($tt / $nbpage);
        if($page > 0 && $page > $nbPage){
            return $this->redirect($request, $response, 301, 'ads.listingcategorieville',['page' => $nbPage, 'cat_slug' => $cat_slug, 'ann_geoloc' => $ann_geoloc]);
        }

        $url = $this->container->get('router')->pathFor('ads.listingcategorieville',$paramroute);

        $Pagination2 = new PaginationBis();
        $currentPage = ($page == 0) ? 1 : $page;
        $Pagination2->setUrl($url);
        $Pagination2->setCurrentPage($currentPage);
        $Pagination2->setInnerLinks(6);
        $Pagination2->setNbElementsInPage($nbpage);
        $Pagination2->setNbMaxElements($datas['tt']);
        $Pagination2->setLinksSeparator('...');

        // Util::dump($Pagination2);
        $datas['pagination']  = $Pagination2->renderBootstrapPagination();

        $cats = $ads->getCats();
        $datas['cats'] = $cats;

        $datas['js'] = 'ads';

        $villesList = $ads->getAdsPlaces();
        $datas['list-places'] = $villesList;

        // $datas['ville'] = (!empty($valid['ville']) && !is_null($valid['ville'])) ? $valid['ville'] : null;
        // $datas['search'] = (!empty($valid['search']) && !is_null($valid['search'])) ? $valid['search'] : null;

        $request = $request->withAttribute('datas', $datas);
        return $this->render($request,$response, 'ads/listingcategorieville');

    }

}