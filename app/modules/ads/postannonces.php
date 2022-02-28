<?php
namespace App\modules\ads;

use App\helpers\Util;
use App\helpers\Pagination;
use App\helpers\PaginationBis;
use App\helpers\Validation;
use App\classes\ClassAds;

class postannonces extends \App\views\Genere_views {

    public $container;

    public function __construct($container){
        $this->container = $container;
        
    }

    public function process($request, $response) {

// il faut faire apparaitre sur la page listing 
        $ads = new ClassAds($this->container);
        $validation = new Validation($request->getParsedBody());

        $nbpage = 10;
        $page = $request->getAttribute('page') ?? 0;

        // var_dump($valid);
        // Util::dump($valid, 'hello valid');
        $datas = array();

        $validClient = $validation
        ->numeric()
        ->notEmpty('c_civ','c_prenom','c_nom','c_mail')
        ->getDatas();

        $valid = $validation
        ->numeric('ann_site_id','num_item')
        ->notEmpty('ann_date_publication','ann_titre','ann_cat_id', 'ann_geoloc')
        ->getDatas();

    

        if ($validClient) :
        $ads->insertClient($validClient);

        if($valid):
            
            
        // Util::dump($valid);
        // die();
        
            $in = $ads->insertAdPublic($valid);
            // Si l'annonce est créée en BDD, on utilise la clé 'num_items' de  l'array pour compter le nombre d'items transmis par l'utilisateur
            if($in):
                $num_item = $valid['num_item'];

                // Si le nombre d'items transmis par l'utilisateur dans num_item est supérieur à 0, pour chacun d'entre eux, un item est crée en BDD 
                // avec chacune des informations 
                if($num_item > 0):
                    for($i = 0 ; $i < $num_item; $i++):
                        $insert = array(
                            'ann_id' => $in,
                            'item_type_id_fk' => $valid['item_type_id_fk_' . $i],
                            'item_order' => $valid['item_order_' . $i],
                            'item_value' => $valid['item_value_' . $i],
                        );
                        $ads->insertItem($insert);
                    endfor;
                endif;

                // Si l'annonce est créée, l'utilisateur est redirigé sur la page de détail de la nouvelle annonce
                $this->flash('success', 'L\'annonce est ajoutée !');
                return $this->redirect($request, $response, 200, 'ads.listing');
            else:
                 // Sinon, si l'annonce ou ses items contiennent des erreurs, l'utilisateur est redirigé sur la page de création d'une annonce
                $this->flash('error', 'Les informations transmises sont incorrectes.');
            endif;

        else:
            $this->flash('error', 'Les informations transmises sont incorrectes.');
        endif;
        endif;


        return $this->redirect($request, $response, 200, 'ads.listing');
    }
}