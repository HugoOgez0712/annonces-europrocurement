<?php 
  $form = new App\helpers\Forms();
    $form->setForm($router->pathFor('ads.postsearchads'),'post','block_search bloc_form toggle-search');
            ?>
            <div class="row">
                <div class="col-12">
                    <div class="annonces-search card">
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div id="recherche">

                                <?php 

                                //  $form->input([
                                //     'type' => 'text',
                                //     'name' => 'search',
                                //     'label' => 'Recherche',
                                //     'required' => false,
                                //     'classlabel' => 'bleu',
                                //     'classinput' => 'text',
                                //     'classbox' => 'col-lg-6 col-md-12',
                                //     'maxlength' => 50,
                                //     'value' =>  (isset($request['search'])) ? $request['search'] : null 
                                // ]);
                                // var_dump($_SESSION['ads']);
                                // die();
                                ?>
                                    <input name="search" type="text" class="text size1" value="<?= (isset($_SESSION['ads']['search'])) ? $_SESSION['ads']['search'] : null ?>"/>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <?php if($cats): ?>
                                <div id="categorie">
                                    <select name="cat" id="cat">
                                        <option value=""></option>
                                        <?php   foreach($cats as $cat): ?>
                                        <option id="categorie" value="<?= $cat->cat_id ?>"
                                        <?php if(isset($_SESSION['ads']['cat']) && (($_SESSION['ads']['cat']) == $cat->cat_id)):?>
                                            selected="selected" 
                                        <?php endif;?>
                                        > 
                                        <?=$cat->cat_nom ?></option>
                                         <?php endforeach; ?>
                                    </select>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="row">


                            <div class="col-md-6 col-sm-12">
                               
                                <div class="autocomplete" style="width:300px;" style="position: relative; display: inline-block;">
                                    <input id="myInput" type="text" name="ville" placeholder="ville" value="<?= isset($_SESSION['ads']['ann_geoloc']) && !is_null($_SESSION['ads']['ann_geoloc']) ? $_SESSION['ads']['ann_geoloc'] : null ?>">
                                </div>
                           

                            </div>

                            <div class="col-xl-4 col-md-6">

                                <div id="date">
                                    <input id="date-input" data-provide="datepicker" name="date" type="text" class="text fdat" value="<?= (isset($request['query-date'])) ? $request['query-date'] : null ?>" maxlength="20" placeholder="<?= date('d/m/Y'); ?>" />
                                </div>

                            </div>
                            <div class="col-xl-2 col-md-12">
                                <div id="submit">
                                    <input type="submit" class="btn medium blue-medium" value="Rechercher">
                                </div>
                            </div>
                        </div>
                        <p><span><?= $tt ?></span> annonce<?= $util::pluriel($tt) ?> légale<?= $util::pluriel($tt) ?> trouvée<?= $util::pluriel($tt) ?></p>
                    </div>
                </div>
            </div>
            <?php
            $form->end();
            ?>