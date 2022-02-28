<?php
$list = $request['list'] ?? null;
$categories = $request['cats'] ?? null;
$today = date("Y-m-d H:i:s");
$currentCat = $request['currentCat'] ?? null;
$slug = $request['slug'] ?? null;


$itemtypes  = $request['item_types'] ?? null;


$items = $request['currentItems'];


$civ_array = ['M.' => 'M.', 'Mme.' => 'Mme.'];

$liste_items = null;
foreach ($itemtypes as $itemtype) :
    $liste_items .= '<option value="' . $itemtype->item_type_id . '" data-type="' . $itemtype->item_type_input . '">' . $itemtype->item_type_nom . '</option>';
endforeach;

// $util::dump($list);

/* 
Reprendre le template de detail.php
1) Créer une table utilisateur -> id, civilité*, nom*, prenom*, mail*, tel
-> Ajouter une partie "Coordonnées" avant bouton d'envoi


POST ANNONCE
->  Verifier si utilisateur existe avec l'adresse mail
    1) Il existe tu récupères l'ID
    2) Sinon tu le créées
-> L'annonce est invisible
*/
?>

<div class="container first">

    <div class="row">

        <div class="col-lg-8 col-md-12 content encheres">

            <div class="row">
                <div class="bread col-12">
                    <span><a href="<?= $router->pathFor('site.index') ?>">Accueil</a></span>
                    <span><a href="<?= $router->pathFor('ads.listing') ?>">Annonces</a></span>
                    <span><a href="<?= $router->pathFor('ads.listingcategorie', ['cat_slug' => $slug]) ?>"><?= $currentCat->cat_nom ?></a></span>

                </div>
            </div>

            <?php
            $form = new App\helpers\Forms($request['csrf']);
            $form->uploadfile();
            $form->setForm($router->pathFor('ads.postannonces'), 'post', 'needs-validation');
            ?>


          
            <div class="annonces-titre mt-3">
                <h1>
                    Vous êtes nouveau client ?
                </h1>
            </div>



            <div class="row">
                <!--  DEBUT COLONNE DE GAUCHE -->
                <div class="col-12 col-md-8 col-lg-8">
                    <!-- DEBUT CONTENU -->
                    <div class="card">

                        <div class="card-body">

                            <div class="col-12 article-txt" id="article-txt">
                                <?php

                                $form->select([
                                    'name' => 'c_civ',
                                    'label' => 'Sélectionner la civilité',
                                    'required' => true,
                                    'datas' => $civ_array,
                                    'classbox' => 'mt-3'
                                ]);


                                $form->input([
                                    'type' => 'text',
                                    'name' => 'c_prenom',
                                    'label' => 'Prénom du client',
                                    'required' => false,
                                    'classinput' => 'cleave_firstupper',
                                    'classbox' => 'mt-3'
                                ]);

                                $form->input([
                                    'type' => 'text',
                                    'name' => 'c_nom',
                                    'label' => 'Nom du client',
                                    'required' => true,
                                    'classinput' => 'cleave_firstupper',
                                    'classbox' => 'mt-3'
                                ]);


                                // TITRE : Localisation
                                $form->input([
                                    'type' => 'email',
                                    'name' => 'c_mail',
                                    'label' => 'Mail du client',
                                    'required' => true,
                                    'classbox' => 'mt-3'
                                ]);



                                ?>
                            </div>
                        </div>
                    </div>
                    <!-- FIN CONTENU -->
                </div>
            </div>

            <!-- Page Heading -->

            <div class="annonces-titre mt-3">
                <h1>
                    Ajouter une annonce <?= $currentCat->cat_nom ?>
                </h1>
            </div>

            <div class="row">
                <!--  DEBUT COLONNE DE GAUCHE -->
                <div class="col-12 col-md-8 col-lg-8">
                    <!-- DEBUT CONTENU -->
                    <div class="card">

                        <div class="card-body">

                            <div class="col-12 article-txt" id="article-txt">
                                <?php
                                $form = new App\helpers\Forms($request['csrf']);
                                $form->setForm($router->pathFor('ads.postannonces'), 'post', 'needs-validation');
                                // $form->setDatas([
                                //     'liv_pays' => 'France',
                                //     'fac_pays' => 'France'
                                // ]);
                                $form->hidden([
                                    'name' => 'ann_site_id',
                                    'value' => 9
                                ]);

                                $form->hidden([
                                    'name' => 'ann_cat_id',
                                    'value' => $currentCat->cat_id
                                ]);

                                $form->hidden([
                                    'name' => 'ann_date_publication',
                                    'value' => $today
                                ]);


                                $form->hidden([
                                    'id' => 'num_item',
                                    'name' => 'num_item',
                                    'value' => count($items)
                                ]);

                                $form->input([
                                    'type' => 'text',
                                    'name' => 'ann_titre',
                                    'label' => 'Titre de l\'annonce',
                                    'required' => false,
                                    'classinput' => 'uppercase',
                                    'classbox' => 'mt-3'
                                ]);

                                $form->input([
                                    'type' => 'text',
                                    'name' => 'ann_desc',
                                    'label' => 'Description',
                                    'required' => true,
                                    'classinput' => 'cleave_firstupper',
                                    'classbox' => 'mt-3'
                                ]);

                                // $form->input([
                                //     'type' => 'text',
                                //     'name' => 'info_nom',
                                //     'label' => 'Nom',
                                //     'required' => true,
                                //     'classinput' => 'uppercase'
                                // ]);

                                // AFFICHER LES CHAMPS SUPPLEMENTAIRES (ITEMS)
                                /*                     foreach($itemtypes as $itemtype):
                        $liste_items .= '<option value="' . $itemtype->item_type_id . '" data-type="' . $itemtype->item_type_input . '">' . $itemtype->item_type_nom . '</option>';
                    endforeach; */


                                // TITRE : Localisation
                                $form->input([
                                    'type' => 'text',
                                    'name' => 'ann_geoloc',
                                    'label' => 'Ville',
                                    'required' => true,
                                    'classinput' => 'cleave_firstupper',
                                    'classbox' => 'mt-3'
                                ]);


                                if ($items) :
                                    $html = null;
                                    $j = 0;
                                    foreach ($items as $i) :
                                        // data('order');
                                        $html .= '<input type="hidden" class="order" name="item_order_' . $j . '" value="' . $j . '">';
                                        $html .= '<input type="hidden" class="cat_id" name="cat_id_' . $j . '" value="' . $currentCat->cat_id . '">';
                                        $html .= '<input type="hidden" class="type" name="item_type_id_fk_' . $j . '" value="' . $i->item_type_id . '">';
                                        if ($i->item_type_input == "textarea") {
                                            $html .= '<div class="mt-3 input-group"> <label for="item_value_' . $j . '">' . $i->item_type_nom . '</label><textarea class="value form-control" aria-label="With textarea" name="item_value_' . $j . '" required></textarea> </div>';
                                        } else {
                                            $html .=  '<div class="mt-3 input-group mb-3"> <label for="item_value_' . $j . '">' . $i->item_type_nom . '</label><input class="value form-control" type="' . $i->item_type_input .'" name="item_value_' .  $j . '" required></div>';
                                            // <button class="btn btn-sm btn-warning"><i class="fa fa-trash"></i></button>
                                        }
                                        $j++;
                                    endforeach;
                                    echo $html;
                                endif;
    
                                $form->button([
                                    'name' => 'sub',
                                    'label' => 'Ajouter',
                                    'classbox' => 'form-group text-left',
                                    'classinput' => 'btn medium yellow-pure full-width',
                                    'classbox' => 'mt-3'
                                ]);


                                ?>
                            </div>
                        </div>
                    </div>
                    <!-- FIN CONTENU -->
                </div>
            </div>
            <?php
            $form->end();
            ?>


           
        </div>
        <?php require_once __DIR__ . "/../site/coldroite.php";

?>
   

        <!--  fin  <div class="col-lg-8 col-md-12 content encheres"> -->
        

    </div>
    <!-- fin du row -->


</div>

<!-- fin du container-first -->