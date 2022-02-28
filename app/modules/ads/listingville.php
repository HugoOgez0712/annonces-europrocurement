<?php
namespace App\modules\ads;

use App\helpers\Util;
use App\helpers\Pagination;
use App\helpers\PaginationBis;
use App\helpers\Validation;
use App\classes\ClassAds;

class listingville extends \App\views\Genere_views {

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
        $ville = $request->getAttribute('ann_geoloc') ?? null;
        $ann_geoloc = $request->getAttribute('ann_geoloc') ?? null;
        $datas['ville'] = $ann_geoloc;
        $where = ' 1 ';

        if(isset($_SESSION['ads']['post']) && $_SESSION['ads']['post']){
            extract($_SESSION['ads']);
            unset($_SESSION['ads']['post']);
        }else{ 
            unset($_SESSION['ads']['cat']);
            unset($_SESSION['ads']['cat_slug']);
            unset($_SESSION['ads']['where']);
            if($_SESSION['ads']){
                extract($_SESSION['ads']);
            }
            $where .= isset($search) && !is_null($search) ? ' AND ann_titre LIKE "%' . $search . '%" ' : null;
            $where .= isset($ann_geoloc) && !is_null($ann_geoloc) ? ' AND ann_geoloc LIKE "%' . $ann_geoloc . '%" ' : null;
            $_SESSION['ads']['ann_geoloc'] = isset($_SESSION['ads']['ann_geoloc'])  && !is_null($_SESSION['ads']['ann_geoloc']) ? $_SESSION['ads']['ann_geoloc'] : null;
            $_SESSION['ads']['search'] = isset($_SESSION['ads']['search'])  && !is_null($_SESSION['ads']['search']) ? $_SESSION['ads']['search'] : null;
        }

        $paramroute = array(
            'ann_geoloc' => $ann_geoloc
        );

        $list = $ads->getAds($page, $nbpage, $where);
        $datas['list'] = $list;
        $tt = $ads->getTotal();
        $datas['tt'] = $tt;
        

        $nbPage = ceil($tt / $nbpage);
        if($page > 0 && $page > $nbPage){
            return $this->redirect($request, $response, 301, 'ads.listingville',['page' => $nbPage, 'ann_geoloc' => $ann_geoloc]);
        }

        $url = $this->container->get('router')->pathFor('ads.listingville',$paramroute);

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

        $_SESSION['ads']['ann_geoloc'] = $ann_geoloc;
        // $datas['ville'] = (!empty($valid['ville']) && !is_null($valid['ville'])) ? $valid['ville'] : null;
        // $datas['search'] = (!empty($valid['search']) && !is_null($valid['search'])) ? $valid['search'] : null;

        $request = $request->withAttribute('datas', $datas);
        return $this->render($request,$response, 'ads/listingville');

    }

}