<?php
namespace App\admin;

class compositioncat extends \App\views\Genere_admin {

    public $container;

    public function __construct($container){
        $this->container = $container;
    }

    public function process($request, $response) {

        $cat = $request->getAttribute('id');
        $idsite = $this->container->globals['idsite'];

        $datas['compo'] = $this->container->actu->getCompositionAdmin($idsite,1,$cat);
        $datas['compo_temp'] = $this->container->actu->getCompositionAdmin($idsite,0,$cat);

        $datas['cat'] = $this->container->actu->getCat($idsite,$cat);
        if(!$datas['cat']):
            $this->flash('error', 'Page indisponible');
            return $this->redirect($request, $response, 200, 'admin.administration');
        endif;

        $filtre = 'art_idsite = '.$idsite.' AND art_cat = '.$cat.' ';
        $datas['liste'] = $this->container->actu->getLastArticlesForComposition($filtre);

        $filtre = 'pub_idsite = '.$idsite.' ';
        $datas['pubs'] = $this->container->actu->getLastPubsForComposition($filtre);

        $page = 'compositioncat';

        $datas['js'] = 'admin_compositioncat';

        $request = $request->withAttribute('datas', $datas);
        return $this->render($request,$response, 'admin/'.$page);

    }

}