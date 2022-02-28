<?php

        // Ce module est déclenché lors de la soumission du formulaire sur la page d'ajout d'une annonce. Il va servir à créer une nouvelle annonce en BDD et à l'afficher
        // avec ses informations sur la liste des annonces et lors de sa sélection sur le FO et le BO
namespace App\admin;

use App\helpers\Validation;
use App\classes\ClassAds;
use App\helpers\Util;

class postajoutad extends \App\views\Genere_admin {

    public $container;

    public function __construct($container){
        $this->container = $container;
    }

    public function process($request, $response) {

        //instance de la class Validation pour récupérer, à la soumission du formulaire, les informations transmises par l'utilisateurs 
        $validation = new Validation($request->getParsedBody());

        // valid est un array qui contient les informations nécessaires à la création d'une annonce que l'utilisateur transmet par les différents champs sur la view de l'ajout
        // d'une annonce
        $valid = $validation
        ->numeric('ann_site_id','num_item')
        ->notEmpty('ann_date_publication','ann_aut_id','ann_titre','ann_cat_id', 'ann_geoloc', 'ann_active')
        ->getDatas();
        //instance de la class Ads pour récupérer les méthodes nécessaires à l'ajout d'une annonce
        $ads = new ClassAds($this->container);
        // Util::dump($request->getParsedBody());exit;

        // Si les informations transmises sont toutes existantes, la méthode pour créer une annonce en BDD est utlisée avec les informations transmises par l'utilisateur
        if($valid):
            $in = $ads->insertAd($valid);
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
                return $this->redirect($request, $response, 200, 'admin.gestionaddetail', ['id'=>$in]);
            else:
                 // Sinon, si l'annonce ou ses items contiennent des erreurs, l'utilisateur est redirigé sur la page de création d'une annonce
                $this->flash('error', 'Les informations transmises sont incorrectes.');
            endif;

        else:
            $this->flash('error', 'Les informations transmises sont incorrectes.');
        endif;

        return $this->redirect($request, $response, 200, 'admin.ajoutad');

    }

}