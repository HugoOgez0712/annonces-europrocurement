<?php
namespace App\modules\ajax;

use App\helpers\Util;
use App\classes\ClassAds;

class datatable_ads {

    public $container;

    public function __construct($container){
        $this->container = $container;
    }

    public function process($request, $response) {
        

        if($request->isXhr()) {

            $post = $request->getParsedBody();

            $output = [];
            
            $idsite = $this->container->globals['idsite'];
            $query = 'WHERE site_id = '.$idsite.' ';

            if(!empty($post["columns"][1]["search"]["value"])):
                $query .= 'AND ann_titre LIKE "%'. $post["columns"][1]["search"]["value"] .'%" ';
            endif;
            if(!empty($post["columns"][2]["search"]["value"])):
                $query .= 'AND ann_desc LIKE "%'. $post["columns"][2]["search"]["value"] .'%" ';
            endif;
            if(!empty($post["columns"][3]["search"]["value"])):
                $query .= 'AND cat_nom LIKE "%'. $post["columns"][3]["search"]["value"] .'%" ';
            endif;
            if(!empty($post["columns"][4]["search"]["value"])):
                $date = Util::formatDateTable($post["columns"][4]["search"]["value"]);
                $query .= 'AND ann_date_publication LIKE "%'. $date .'%" ';
            endif;
            if(!empty($post["columns"][5]["search"]["value"])):
                $query .= 'AND ann_geoloc LIKE "%'. $post["columns"][5]["search"]["value"] .'%" ';
            endif;

            $q = $query;

            if(isset($post["order"][0]["column"]) && $post["order"][0]["column"] != 0):
                $col = $post["columns"][$post["order"][0]["column"]]["name"];
                $dir = $post["order"][0]["dir"];
                $query .= 'ORDER BY '.$col.' '.$dir.' ';
            else:
                $query .= 'ORDER BY ann_id DESC ';
            endif;

            $ads = new ClassAds($this->container);
            $datas = [];
            $d = $ads->getAdsAdmin($query);

            foreach($d as $a):
                $subarray = [];
                $subarray[] = $a->ann_id;
                $subarray[] = "<a href='".$this->container->get('router')->pathFor('admin.gestionaddetail', ['id'=> $a->ann_id ])."' >".$a->ann_titre."</a>";
                $subarray[] = "<a href='".$this->container->get('router')->pathFor('admin.gestionaddetail', ['id'=> $a->ann_id ])."' >".$a->ann_desc."</a>";
                $subarray[] = "<a href='".$this->container->get('router')->pathFor('admin.gestionaddetail', ['id'=> $a->ann_id ])."' >".$a->cat_nom ."</a>";
                $subarray[] = Util::inverseDate($a->ann_date_publication);
                $subarray[] = $a->ann_geoloc;
                $datas[] = $subarray;
            endforeach;

            $total = $ads->getcountAds($q);

            $output = [
                "draw" => intval($_POST["draw"]),
                "recordsTotal" => $total,
                "recordsFiltered" => count($d),
                "data" => $datas
            ];

            echo json_encode($output);


        } else {
            $url = $this->container->get('router')->pathFor('site.index');
            $response->withStatus(404);
            return $response->withRedirect((string)$url);
        }

    }

}