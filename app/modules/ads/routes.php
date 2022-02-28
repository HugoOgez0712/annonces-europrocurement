<?php

$app->post('/postsearchads', 'App\modules\ads\postsearchads:process')->setName('ads.postsearchads');

//Listing annonces
$app->get('/liste-annonces[/{page:[0-9]+}]', 'App\modules\ads\listing:process')->setName('ads.listing');

// Listing des annonces avec ville selectionnée
$app->get('/liste-annonces/ville/{ann_geoloc:[a-zA-Z]+}[/{page:[0-9]+}]', 'App\modules\ads\listingville:process')->setName('ads.listingville');

// Listing des annonces avec catégorie selectionnée
$app->get('/liste-annonces/{cat_slug:[0-9a-zA-Z]+}[/{page:[0-9]+}]', 'App\modules\ads\listingcategorie:process')->setName('ads.listingcategorie');
// Listing des annonces avec catégorie et ville selectionnées
$app->get('/liste-annonces/{cat_slug:[0-9a-zA-Z]+}/{ann_geoloc:[0-9a-zA-Z]+}[/{page:[0-9]+}]', 'App\modules\ads\listingcategorieville:process')->setName('ads.listingcategorieville');

//Voir l'annonce
$app->get('/annonce-{ann_id:[0-9]+}', 'App\modules\ads\detail:process')->setName('ads.detail');



//liste des annonces en fonction de la catégorie
$app->get('/liste-annonces-categorie[-{cat_slug:[0-9a-zA-Z]+}]', 'App\modules\ads\categorie:process')->setName('ads.categorie');

$app->get('/annonces-map[/{map_slug:[0-9a-zA-Z]+}]', 'App\modules\ads\map:process')->setName('ads.map');


//publier une annonce
$app->get('/envoi-annonce-{cat_slug:[0-9a-zA-Z]+}', 'App\modules\ads\formulaire:process')->setName('ads.formulaire');
//post des informations publiées
$app->post('/postannonces', 'App\modules\ads\postannonces:process')->setName('ads.postannonces');