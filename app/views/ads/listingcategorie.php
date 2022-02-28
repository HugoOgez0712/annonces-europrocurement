<?php
    $list = $request['list'] ?? null;
    $cats = $request['cats'] ?? null;
    $pages = $request['pages'] ??  [];
    $listVilles = $request['list-places'] ?? null;
    $pagination = $request['pagination'] ?? null;
    $tt = $request['tt'] ?? null;
    $pagination = $request['pagination'] ?? null;
    $catOptions = $request['catOptions'] ?? null;
    $depOptions = $request['depOptions'] ?? null;
    $cat = $request['cat'] ?? null;
    // var_dump($cat->cat_slug);
    // die;
?>

<div class="container first">
    <div class="row">
        <div class="col-lg-8 col-md-12 content annonce-wrapper">
            <div class="row">
                <div class="bread col-12">
                    <span><a href="<?= $router->pathFor('site.index') ?>">Accueil</a></span><span><a href="<?= $router->pathFor('ads.listing') ?>">Liste annonces</a></span>
                    <span><a href="<?= $cat->cat_nom ?>"</a></span>
                    <span></span>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="annonces-titre">
                        <h1 class="serif">Annonces <?= $cat->cat_nom ?></h1>
                        <a href="<?= $router->pathFor('ads.formulaire',['cat_slug'=>$cat->cat_slug]) ?>" class="btn medium blue-medium-border">Publier dans la catégorie <?= $cat->cat_nom ?></a>
                    </div>
                </div>
            </div>
           
            <?php
                require_once(__DIR__ . '/searchform.php');
           ?>
            <div class="row">
                <div class="col-12 tableau">
                    <table class="events-table annonce-liste">
                        <thead>
                            <tr>
                                <th class="DATE">Date</th>
                                <th class="REF.">Type</th>
                                <th class="SOCIÉTÉ">Titre</th>
                                <th class="TYPE D’ANNONCE">Ville</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php
                            if($list):
                                foreach($list as $row):
                                ?>
                                    <!-- // $lien = $router->pathFor('ads.detail',['Lien'=>$row->Lien]); -->
                                    
                                        <tr> <a href="<?= $router->pathFor('ads.detail', ['ann_id'=>$row->ann_id]) ?>"> 
                                            <td data-label="DATE"> <a href="<?= $router->pathFor('ads.detail', ['ann_id'=>$row->ann_id])?>"><?= $row->ann_date_publication ?></a></td>
                                            <td data-label="REF."><a href="<?= $router->pathFor('ads.detail', ['ann_id'=>$row->ann_id])?>"><?=$row->cat_nom?></a></td>
                                            <td data-label="SOCIÉTÉ"><a href="<?= $router->pathFor('ads.detail', ['ann_id'=>$row->ann_id])?>"><?=$row->ann_titre?></a></td>
                                            <td data-label="TYPE D’ANNONCE"><a href="<?= $router->pathFor('ads.detail', ['ann_id'=>$row->ann_id])?>"><?=$row->ann_geoloc?></a></td>

                                        </a></tr>
                                    <?php
                                endforeach;
                            endif;
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?= $pagination ?>
        </div>
        <?php require_once __DIR__ ."/../site/coldroite.php"; ?>
    </div>
</div>

    <!-- <form autocomplete="off" action="">
  <div class="autocomplete" style="width:300px;" style="position: relative;
  display: inline-block;">
    <input id="myInput" type="text" name="ville" placeholder="ville">
  </div>
  <input type="submit">
</form> -->

        <h3>Chercher une annonce
        </h3>

        <?= !empty($pagination) ? $pagination : '<br><br>' ?>
</body>
</html>