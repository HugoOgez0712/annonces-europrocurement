<?php
namespace App\admin;

use App\classes\ClassAdmin;
use App\classes\ClassAds;
use App\helpers\Validation;
use App\helpers\Util;

class postmodifitems extends \App\views\Genere_admin {

    public $container;

    public function __construct($container){
        $this->container = $container;
    }

    public function process($request, $response) {

        $validation = new Validation($request->getParsedBody());
       

        $valid = $validation
        ->numeric('ann_id','num_item')
        ->getDatas();

        if($valid):
      
            $ad = new ClassAds($this->container);
            $num_item = $valid['num_item'];
    
            $delete = array(
                'ann_id' => $valid['ann_id'],
            );
            $ad->deleteItem($delete);
          
            if($num_item > 0):
                for($i = 0 ; $i < $num_item; $i++):
                    $insert = array(
                        'ann_id' => $valid['ann_id'],
                        'item_type_id_fk' => $valid['item_type_id_fk_' . $i],
                        'item_order' => $valid['item_order_' . $i],
                        'item_value' => $valid['item_value_' . $i],
                    );
                    $ad->insertItem($insert);
                endfor;
            endif;
            $this->flash('success', 'Les données supplméntaires ont bien éte modifiées !');
        else:
            $this->flash('error', 'Les informations transmises sont incorrectes.');
        endif;
        return $this->redirect($request, $response, 200, 'admin.gestionaddetail', ['id'=>$valid['ann_id']]);
    }
}