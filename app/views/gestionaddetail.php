<?php
// Cette view correspond à la page de détail d'une annonce que l'on a préalablement choisie
$ad = $request['currentAd'];
// On récupère les infos de l'annonce courante
$images = $request['images'];
// On stocke ici les images présentes
$ann_id = $ad->ann_id;


$ann_date_creation = $ad->ann_date_creation ?? date('Y-m-d H:i:s');
// On récupère la date de création, à défault on attribue la date du jour à cette variable
$date = strtotime($ann_date_creation);
$year = date('Y',$date);
$month = date('m',$date);
$day = date('d',$date);
// On décompose la date en plusieurs variables

$dir = 'content/annonces/'.$year.'/'.$month.'/'.$day.'/'.$ann_id.'/';
// On crée une direction pour stocker des images
$items = $request['currentItems'] ?? null;
// Récupération des items si certains sont présents
$default = $request['default'] ?? null;
// Récupération des champs par défaut de la catégorie sélectionnée pour l'annonce
$itemtypes = $request['item_types'] ?? null;
// Récupération des types d'items existants pour un éventuel ajout
$liste_items = null;
// On stockera dans cette variable l'ensemble des options de type d'items récupérés avec le foreach

foreach($itemtypes as $itemtype):
    $liste_items .= '<option value="' . $itemtype->item_type_id . '" data-type="' . $itemtype->item_type_input . '">' . $itemtype->item_type_nom . '</option>';
endforeach;
// récupération de chacun des typesd'items
?>
<style type="text/css">
    .input-group-text{
        border-radius: 0;
    }
    .suppr-item{
    border: 0;
    background-color: white;
}

</style>
<div class="container-fluid">
    <!-- Page Heading-->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Modification d'une annonce
        <br>
      
            <span>
                <div class="mt-3">
            <a href='<?= $router->pathFor('ads.detail', ['ann_id'=> $ann_id])  ?>'>Voir l'annonce</a>
            </div>
 <!-- lien vers le frontoffice de l'annonce -->
            </span>
        </h1>
        <?php
                        $form = new App\helpers\Forms($request['csrf']);
                        $form->setForm($router->pathFor('admin.postdeletead'),'post','needs-validation');
                    $form->hidden(['name' => 'ann_id',
                            'value' => $ad->ann_id
                        ]);
                        // Bouton de suppression de l'article
                        $form->button([
                            'name' => 'sub',
                            'label' => 'Supprimer l\'annonce',
                            'classbox' => 'form-group text-right',
                            'classinput' => 'btn btn-danger',
                            'icone' => 'fas fa-trash'
                        ]);
                        $form->end();
                        // Formulaire de suppression de l'annonce, envoie les informations au module postdeletead
                    ?>
    </div>

           
            
                  
                 
         
      


    <!--  DEBUT DU CONTAINER EN ROW -->
    <div class="row">


        <!--  DEBUT COLONNE DE GAUCHE -->
        <div class="col-md-8 col-12">
            <!-- DEBUT CONTENU -->
            <div class="card mt-4 ml-4">
                <div class="card-header text-primary bg-gray-800 text-gray-100">
                    Détail de l'annonce
                </div>
                <div class="card-body">
                    <?php
                    // Formulaire de modification des informations de l'annonce
                        $form = new App\helpers\Forms($request['csrf']);
                        $form->uploadfile();
                        $form->setForm($router->pathFor('admin.postmodifad'),'post','needs-validation');
                        $form->setDatas($ad);
                        $form->hidden([
                            'name' => 'ann_id',
                            'value' => $ann_id
                        ]);
                        $form->hidden([
                            'name' => 'ann_date_creation',
                            'value' => $ann_date_creation
                        ]);

                         // Ces éléments du formulaires en hidden sont ajoutés automatiquement , on y retrouve la date de publication à la date du jour et l'id de l'annonce
                      
                        $form->input([
                            'type' => 'text',
                            'name' => 'ann_titre',
                            'id' => 'input_titre',
                            'label' => 'Titre de la page',
                            'required' => true,
                            'classbox'=> 'mt-3',
                            'value' => $ad->ann_titre
                        ]);
                        // On propose ici un titre pour l'annonce
                        $form->textarea([
                            'type' => 'text',
                            'name' => 'ann_desc',
                            'label' => 'Description',
                            'required' => true,
                            'classbox'=> 'mt-3',
                            'value' => $ad->ann_desc
                        ]);
                         // On propose ici une description pour l'annonce
                        $form->button([
                            'name' => 'sub',
                            'label' => 'Modifier l\'annonce',
                            'classbox' => 'form-group text-left',
                            'classinput' => 'btn btn-success',
                            'icone' => 'fas fa-check',
                            'classbox'=> 'mt-3'
                        ]);
                        // Soumission du formulaire jusqu'à postmodifad
                        $form->end();
                    ?>
                </div>
            </div>

            <div class="card mt-4 ml-4">
                <div class="card-header text-primary bg-gray-800 text-gray-100">
                    Photos de l'annonce
                </div>
                <div class="card-body">
                <form action="submit" method="post" enctype="multipart/form-data">
                        <!-- file input -->
                        <span id="dirfile" data-baseurl="<?= BASEURL.'/' ?>" data-dir="<?= $dir ?>"></span>
                        <?php
                            
                            $uploadDir = __DIR__.'/../../../'.ROOT.'/'.$dir;
                        // On réutilise notre $dir pour prévoir un chemin qui nous emmène vers l'endroit où l'image sera sauvegardée
                            $preloadedFiles = array();
                        // Création d'un array vide pour récupérer les données des images téléchargées
                            if($images): 
                                foreach($images as $p):
                                    
                                    
                                    $img = $p->img_nom;
                                    $file = $uploadDir.$img;

                                    if(file_exists($file)):
                                            $url = $dir . $img;                                           
                                            $preloadedFiles[] = array(
                                                "name" => basename($img),
                                                "type" => $util::mime_content_type($file),
                                                "size" => filesize($file),
                                                "file" => $url,
                                                "local" => $url, // same as in form_upload.php
                                                "data" => array(
                                                    "id" => $p->img_id,
                                                    "nom" => $p->img_nom, // (optional)
                                                    "order" => $p->img_order,
                                                    "url" => $url                              
                                                ),
                                            );
                                    endif;
                                 endforeach;
                            endif;
                            // Conversion du tableau en string json
                            $preloadedFiles = json_encode($preloadedFiles,JSON_HEX_QUOT | JSON_HEX_APOS);
                        ?>
                        <input type="file" name="files" data-fileuploader-files='<?= $preloadedFiles ?>'>
                        <!-- upload des images  -->
                        <label for="art_photo_auteur">Auteur de l'image </label>
                        <input class="form-control" type="text" id="new_img_nom" name="img_nom" value="" autocomplete="false">

                        <div class="mt-3 form-group">
                    </form>
                </div>
            </div>




        
            <!-- FIN CONTENU -->
        
        <!-- FIN COLONNE DE GAUCHE -->
    </div>
    <div class="card mt-4 ml-4">
                <div class="card-header text-primary bg-gray-800 text-gray-100">
                   Données supplémentaires
                </div>

                <!-- DEBUT CARD BODY ITEMS -->
                <div class="card-body">
                        <?php
                        // formulaire destiné à ajouter des items dans l'annonce correspondante
                        $form = new App\helpers\Forms($request['csrf']);
                        $form->uploadfile();
                        $form->setForm($router->pathFor('admin.postmodifitems'),'post','needs-validation');
                        $form->setDatas($ad);
                        $form->hidden([
                            'name' => 'ann_id',
                            'value' => $ann_id
                        ]);
                        
                        $count = $items ? count($items) : count($default);
                        // Le count sert à calculer le nombre d'items ajoutés ou par défault présents dans une annonce
                        $form->hidden([
                            'id' => 'num_item',
                            'name' => 'num_item',
                            'value' => $count
                        ]);
                        ?>

                        <div id="items">
                        <?php
                        if($items):
                            foreach($items as $i):
                                // On liste chacun des items, en leur attribuant un id et en leur donnant un numéro d'ordre modifiable en drag and drop
                                $html = '<div class="item" id="item_' . $i->item_order . '" data-order="' . $i->item_order . '">';
                                // data('order');
                                $html .= '<input type="hidden" class="order" name="item_order_' . $i->item_order . '" value="' . $i->item_order .'">';
                                $html .= '<input type="hidden" class="ann_id" name="ann_id_' . $i->item_order . '" value="' . $ann_id .'">';
                                $html .= '<input type="hidden" class="type" name="item_type_id_fk_' . $i->item_order . '" value="' . $i->item_type_id_fk .'">';
                                // On prend en compte les différents cas de figure. 
                                if($i->item_type_input == "textarea"){
                                    $html .= '<div class="mt-3 input-group"> <span class="input-group-text handle"><i class="fas fa-ellipsis-v "></i></span> <span class="input-group-text">' . $i->item_type_nom . '</span><textarea class="value form-control" aria-label="With textarea" name="item_value_' . $i->item_order . '">' . $i->item_value . '</textarea><button data-id="' . $i->item_order . '" class="suppr-item"type="button"> <span class="input-group-text btn btn-primary"><i class="fa fa-trash"></i></span></button> </div>' ;
                                }else{
                                    $html .=  '<div class="mt-3 input-group mb-3"> <span class="input-group-text handle"><i class="fas fa-ellipsis-v "></i></span> <span class="input-group-text">' . $i->item_type_nom . '</span><input class="value form-control" type="' . $i->item_type_input . '" name="item_value_' . $i->item_order . '" value="' . $i->item_value . '"><button data-id="' . $i->item_order . '" class="suppr-item"type="button"> <span class="input-group-text btn btn-primary"><i class="fa fa-trash"></i></span></button></div>';
                                    // <button class="btn btn-sm btn-warning"><i class="fa fa-trash"></i></button>
                                }
                                $html .= '</div>';
                                echo $html;
                            endforeach;
                        elseif($default):
                            $j = 0;
                            foreach($default as $i):
                                // Même principe que liste que la précédente avec les items par défault 
                                $html = '<div class="item" id="item_' . $j . '" data-order="' . $j . '">';
                                // data('order');
                                $html .= '<input type="hidden" class="order" name="item_order_' . $j . '" value="' . $j .'">';
                                $html .= '<input type="hidden" class="ann_id" name="ann_id_' . $j . '" value="' . $ann_id .'">';
                                $html .= '<input type="hidden" class="type" name="item_type_id_fk_' . $j . '" value="'. $i->item_type_id .'">';
                                if($i->item_type_input == "textarea"){
                                    $html .= '<div class="mt-3 input-group"> <span class="input-group-text handle"><i class="fas fa-ellipsis-v "></i></span> <span class="input-group-text">' . $i->item_type_nom . '</span><textarea class="value form-control" aria-label="With textarea" name="item_value_' . $j . '"></textarea><button data-id="' . $j . '" class="suppr-item"type="button"> <span class="input-group-text btn btn-primary"><i class="fa fa-trash"></i></span></button> </div>' ;
                                }else{
                                    $html .=  '<div class="mt-3 input-group mb-3"> <span class="input-group-text handle"><i class="fas fa-ellipsis-v "></i></span> <span class="input-group-text">' . $i->item_type_nom . '</span><input class="value form-control" type="' . $i->item_type_input . '" name="item_value_' . $j . '" value=""><button data-id="' . $j . '" class="suppr-item"type="button"> <span class="input-group-text btn btn-primary"><i class="fa fa-trash"></i></span></button></div>';
                                    // <button class="btn btn-sm btn-warning"><i class="fa fa-trash"></i></button>
                                }
                                $html .= '</div>';
                                echo $html;
                                $j++;
                            endforeach;      
                        endif;
                        ?>
                        </div>



                        <div class="mt-3">

                        <div class="row">
                            <!-- Section du formulaire pour l'ajout des items -->
                            <div class="col-10 mt-3 mb-3">
                                <label for="types">Quelle donnée voulez vous ajouter?</label>
                               
                                <select name="types" class='form-control' id="types">
                                    <?= $liste_items ?>
                                </select>
                                <!-- On propose un sélecteur pour choisir un item parmis la liste -->

                            </div>
                            <div class="col-2 mt-3 mb-3">
                                <a href="#" class="ad btn btn-primary mb-3" style="margin-top:2rem;"><i class="fas fa-plus"></i></a>
                            </div>
                        </div>
                        
                        </div>


                        <?php
                        $form->button([
                            'name' => 'sub',
                            'label' => 'Enregistrer',
                            'classbox' => 'form-group text-left',
                            'classinput' => 'btn btn-success',
                            'icone' => 'fas fa-check',
                            'classbox'=> 'mt-3'
                        ]);
                        // bouton pour valider l'envoi du formulaire
                        $form->end();
                        ?>
                    <!-- FIN CARD BODY ITEMS -->
                    </div>
                </div>
            </div>
</div>

<!-- Modal -->
<div class="modal fade" id="component" tabindex="-1" role="dialog" aria-labelledby="componentLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="componentLabel">Composants disponibles</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div><button type="button" data-id="0" class="btn btn-primary composants">Formulaire de contact</button></div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
        </div>
        </div>
    </div>
</div>