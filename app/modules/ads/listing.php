<?php
 //instance de la class Ads pour récupérer les méthodes nécessaires à l'ajout d'une catégorie
   //initialisation d'un array vide pour récupérer toutes les données envoyées à la view grâce à la variable $request
     //création d'une variable qui récupère l'id du site courant grâce aux informations du container envoyées par globals
     // récupération de l'id de la catégorie selectionnée dans notre URL 
     // redirection vers la liste des catégories si l'id n'existe pas
      //récupération des catégories dans l'admin
         //Fichier javascript récupéré grâce à data
          //récupération des catégories dans l'admin
           //récupération des catégories dans l'admin
            //récupération des auteurs avec méthode de l'objet auteurs compris dans le container et grâce à l'id du site courant
              // La variable $request reprendre toutes les informations de l'array data grâce à la fonction "withAttribute"
             // La fonction render nous permet de créer notre view. Elle a en attribut les données stockées dans $request, les données renvoyées dans $response et 
        // la route dont le nom a été défini dans notre fichier routes.php
   // Ce module est déclenché lorsque l'on cherche à afficher une annonce et ses informations. Cette page affichera également les annonces qui ont la même catégorie et la même ville
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
         //initialisation d'un array vide pour récupérer toutes les données envoyées à la view grâce à la variable $request
        $datas = array();
        // il faut faire apparaitre sur la page listing
        //instance de la class Ads pour récupérer les méthodes nécessaires à l'ajout d'une catégorie 
        $ads = new ClassAds($this->container);
         //instance de la class Validation pour récupérer, à la soumission du formulaire, les informations transmises par l'utilisateur
        $validation = new Validation($request->getParsedBody());
        $valid = $validation->getDatas();

        // Ces variables servent à déterminer le nombre d'annonce par page et le nombre de pages sur la liste des annonces
        $nbpage = 50;
        $page = $request->getAttribute('page') ?? 0;
        $where = ' 1 ';

        // Cette condition sert à réinitialiser les données de la recherche des annonces si elles sont déjà déterminées
        if(isset($_SESSION['ads']['post']) && $_SESSION['ads']['post']){
            extract($_SESSION['ads']);
            unset($_SESSION['ads']['post']);
        }else{ 
            // $cat_slug = $request->getAttribute('cat_slug') ?? null;
            // $ann_geoloc = $request->getAttribute('ann_geoloc') ?? null;

            // Si la session existe, on extrait la clé ads
            if($_SESSION['ads']){
                extract($_SESSION['ads']);
            }

            // Ces variables servent à déterminer les différentes requêtes possibles en BDD en fonction de ce que l'utilisateur a mis dans sa recherche
            // $where prendra les résultats de la recherche de l'utilisateur pour faire ses requêtes en BDD en 
            $where .= isset($search) && !is_null($search) ? ' AND ann_titre LIKE "%' . $search . '%" ' : null;
            $cat_id = isset($cat_slug) ? $ads->getCatBySlug($cat_slug)->cat_id : null;
            $where .= !is_null($cat_id) ? ' AND ann_cat_id = ' . $cat_id . ' ' : null;
            $where .= isset($ann_geoloc) && !is_null($ann_geoloc) ? ' AND ann_geoloc LIKE "%' . $ann_geoloc . '%" ' : null;

            // On stocke en Session toutes les informations récupérées précédemment en BDD si elles sont définies. 
            // Le lieu est stocké en session
            $_SESSION['ads']['ann_geoloc'] = isset($_SESSION['ads']['ann_geoloc'])  && !is_null($_SESSION['ads']['ann_geoloc']) ? $_SESSION['ads']['ann_geoloc'] : null;
            // Le nom de la catégorie ici 
            $_SESSION['ads']['cat_slug'] = isset($_SESSION['ads']['cat_slug'])  && !is_null($_SESSION['ads']['cat_slug']) ? $_SESSION['ads']['cat_slug'] : null;
            // L'id de la catégorie
            $_SESSION['ads']['cat'] = !is_null($cat_id) ? $cat_id : null;
            // La recherche de l'utilisateur
            $_SESSION['ads']['search'] = isset($_SESSION['ads']['search'])  && !is_null($_SESSION['ads']['search']) ? $_SESSION['ads']['search'] : null;
            // Toutes les
            $_SESSION['ads']['where'] = $where;
        }



        $list = $ads->getAds($page, $nbpage, $where);
        $datas['list'] = $list;
        $tt = $ads->getTotal();
        $datas['tt'] = $tt;
        

        $nbPage = ceil($tt / $nbpage);
        if($page > 0 && $page > $nbPage){
            return $this->redirect($request, $response, 301, 'ads.listing',['page' => $nbPage]);
        }

        $url = $this->container->get('router')->pathFor('ads.listing');

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
        return $this->render($request,$response, 'ads/listing');

    }

}