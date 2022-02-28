<?php
$list = $request['list'] ?? null;
$currentAd = $request['currentAd'] ?? null;
$currentAdItems = $request['currentAdItems'] ?? null;
$currentAdAut = $request['currentAdAut'] ?? null;
$AdsByCity = $request['AdsByCity'] ?? null;
$AdsByAut = $request['AdsByAut'] ?? null;
$AdsByCat = $request['AdsByCat'] ?? null;
// $util::dump($list);

$images = $request['images'];


$ann_date_creation = $currentAd->ann_date_creation ?? date('Y-m-d H:i:s');
$date = strtotime($ann_date_creation);
$year = date('Y', $date);
$month = date('m', $date);
$day = date('d', $date);

$dir = 'content/annonces/' . $year . '/' . $month . '/' . $day . '/' . $currentAd->ann_id . '/';


?>

<div class="container first">
    <!-- Début Container  -->
    <div class="row">

        <div class="col-lg-8 col-md-12 content encheres">
            <div class="row">
                <div class="bread col-12">
                    <span><a href="<?= $router->pathFor('site.index') ?>">Accueil</a></span>
                    <span><a href="<?= $router->pathFor('ads.listing') ?>">Annonces</a></span>
                    <span><a href="<?= $router->pathFor('ads.listingcategorie', ['cat_slug' => $currentAd->cat_slug]) ?>"><?= $currentAd->cat_nom ?></a></span>
                    <span><a href="<?= $router->pathFor('ads.listingcategorieville', ['cat_slug' => $currentAd->cat_slug, 'ann_geoloc' => $currentAd->ann_geoloc]) ?>"><?= $currentAd->ann_geoloc ?></a></span>
                </div>
            </div>
            <div class="annonces-titre mt-3">
                <h1>
                    <?= $currentAd->ann_titre ?>
                </h1>
            </div>
            <div class="row">
                <div class="col-12">
                    <ul class="vaeliste">
                        <li class="vaeaudience">
                            <div class="infos card">
                                <div class="infos-inner">
                                    <p class="info-date">
                                        <?= $currentAd->ann_date_publication ?>
                                    </p>
                                    <p class="info-tj">
                                        <?= $currentAd->ann_geoloc ?>
                                    </p>
                                    <p class="info-cat">
                                        <?= $currentAd->cat_nom ?>
                                    </p>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>

                <!-- <div class="col-12">
                    <p class="small grey-medium">
   



                      <div class="annonces-titre">
                <h1>
      
                </h1>
            </div>
                </div> -->

                <div class="card">
                    <div class="card-body">

                        <!-- file input -->

                        <?php

                        $uploadDir = __DIR__ . '/../../../' . ROOT . '/' . $dir;


                        $preloadedFiles = array();

                        if ($images) :

                            foreach ($images as $i => $p) :
                                $file = $dir . $p->img_nom;
                                if (file_exists(__DIR__ . '/../../../' . ROOT . '/' . $file)) :
                                    if ($i == 1) :
                                        echo '<figure><img src="' . $file . '"  class="medium-zoom-image"/> 
                                    </figure>';
                                    endif;
                                endif;
                            endforeach;
                        endif;
                        // convert our array into json string
                        $preloadedFiles = json_encode($preloadedFiles, JSON_HEX_QUOT | JSON_HEX_APOS);
                        ?>



                    </div>



                    <div class="col-12 article-txt" id="article-txt">
                        <div class="article-content">
                            <div id="enchere">
                                <div id="enchere_lots">
                                    <div class="lot_text">



                                        <p class="MsoTitle"><span><strong><?= $currentAd->ann_titre ?></strong></span></p>
                                        <p class="MsoTitle"><span><strong>Description :
                                                    <?= $currentAd->ann_desc ?></strong></span></p>
                                        <p class="MsoTitle"><span><strong>Ville :
                                                    <?= $currentAd->ann_geoloc ?></strong></span></p>
                                        <?php if ($currentAdAut) : ?>
                                            <p class="MsoTitle"><span><strong>Auteur : <?= $currentAdAut[0]->aut_nom ?>
                                                        <?= $currentAdAut[0]->aut_prenom ?></strong></span></p>
                                        <?php endif; ?>
                                        <?php if ($currentAdItems) : ?>
                                            <?php foreach ($currentAdItems as $currentItem) : ?>
                                                <ul>
                                                    <li>
                                                        <p class="MsoTitle"><span><strong><?= $currentItem->item_type_nom ?>
                                                                    (<?= $currentItem->item_type_desc ?>) :
                                                                    <?= $currentItem->item_value ?></strong></span></p>
                                                    </li>
                                                </ul>
                                            <?php endforeach; ?>
                                        <?php endif; ?>





                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="col-12">
                    <div class="tags">
                        <span class="tag"></span>
                    </div>
                </div> -->
                    <?php if (!empty($AdsByCity)) :
                    ?>
                        <div class="col-12 annonce-liste-similaire annonce-wrapper">
                            <h2 class="h4 serif">Les dernières annonces à <?= $currentAd->ann_geoloc ?></h2>
                            <table class="events-table annonce-liste">
                                <thead>
                                    <tr>
                                        <th class="DATE">DATE</th>
                                        <th class="TITRE.">TITRE.</th>
                                        <th class="CATEGORIE">CATEGORIE</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($AdsByCity as $adCity) :


                                        echo '
                                <tr class="clickable-row" data-href="' . $router->pathFor('ads.detail', ['ann_id' => $adCity->ann_id]) . '" onclick="document.location = ' . $router->pathFor('ads.detail',  ['ann_id' => $adCity->ann_id])  . ';">
                                    <td data-label="DATE">' . $adCity->ann_date_publication . '</td>
                                    <td data-label="TITRE.">' . $adCity->ann_titre . '</td>
                                    <td data-label="CATEGORIE">' . $adCity->cat_nom . '</td>
                                </tr>
                            ';
                                    endforeach;
                                    // foreach($deps as $row):
                                    //     $lien = $router->pathFor('annonces.detail',['Lien'=>$row->Lien]);
                                    //     echo '
                                    //         <tr onclick="document.location = \''. $lien .'\';">
                                    //             <td data-label="DATE">'.$util::ConvDate($row->DDemandee,1,0).'</td>
                                    //             <td data-label="REF.">'.$row->NumeroPresta.'</td>
                                    //             <td data-label="SOCIÉTÉ"><a href="'. $lien .'">'.$row->Annonceur.'</a></td>
                                    //             <td data-label="TYPE D’ANNONCE">'.$row->Type.'</td>
                                    //             <td data-label="DÉPARTEMENT">'.$row->departement_code.' '.$row->departement_nom.'</td>
                                    //         </tr>
                                    //     ';
                                    // endforeach;
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>


                    <?php if (!empty($AdsByCat)) :
                    ?>
                        <div class="col-12 annonce-liste-similaire annonce-wrapper">
                            <h2 class="h4 serif">Les dernières annonces <?= strtolower($currentAd->cat_nom) ?></h2>
                            <table class="events-table annonce-liste">
                                <thead>
                                    <tr>
                                        <th class="DATE">DATE</th>
                                        <th class="TITRE.">TITRE.</th>

                                        <th class="LIEU">LIEU</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    foreach ($AdsByCat as $adCat) :


                                        echo '
                                <tr class="clickable-row" data-href="' . $router->pathFor('ads.detail',  ['ann_id' => $adCat->ann_id]) . '" onclick="document.location = ' . $router->pathFor('ads.detail',  ['ann_id' => $adCat->ann_id])  . ';">
                                    <td data-label="DATE">' . $adCat->ann_date_publication . '</td>
                                    <td data-label="TITRE.">' . $adCat->ann_titre . '</td>
                                    <td data-label="LIEU">' . $adCat->ann_geoloc . '</td>
                                </tr>
                            ';
                                    endforeach;
                                    // foreach($deps as $row):
                                    //     $lien = $router->pathFor('annonces.detail',['Lien'=>$row->Lien]);
                                    //     echo '
                                    //         <tr onclick="document.location = \''. $lien .'\';">
                                    //             <td data-label="DATE">'.$util::ConvDate($row->DDemandee,1,0).'</td>
                                    //             <td data-label="REF.">'.$row->NumeroPresta.'</td>
                                    //             <td data-label="SOCIÉTÉ"><a href="'. $lien .'">'.$row->Annonceur.'</a></td>
                                    //             <td data-label="TYPE D’ANNONCE">'.$row->Type.'</td>
                                    //             <td data-label="DÉPARTEMENT">'.$row->departement_code.' '.$row->departement_nom.'</td>
                                    //         </tr>
                                    //     ';
                                    // endforeach;
                                    ?>
                                </tbody>
                            </table>
                        </div>
                </div>
            </div>
        <?php endif; ?>
        </div>
        <?php require_once __DIR__ . "/../site/coldroite.php"; ?>
    </div><!-- Fin Container  -->