<?php

use App\middlewares\Modules_auth;

/**
 *
 * permissions administrateurs Middlewares
    tous les administrateurs    ->add('App\middlewares\Permission_admin')
    case 0 : "Auteur";          ->add('App\middlewares\Permission_admin_auth')
    case 1 : "Moderateur";      ->add('App\middlewares\Permission_admin_modo')
    case 2 : "Administrateur";  ->add('App\middlewares\Permission_admin_admin')
    case 3 : "Super Admin";     ->add('App\middlewares\Permission_admin_full')
    permissions modules ?  permission_[nom_module]
    mods liste : admin , auteurs,articles,abos,clients,encheres,annonces,archives,services,pubs,params
 *
*/

$app->get('/administration/liste-annonces', 'App\admin\listing:process')->setName('admin.listing');

$app->get('/administration/delete-cache[-{type: [a-z0-9]+}]', 'App\admin\deletecache:process')->setName('admin.deletecache')->add('App\middlewares\Permission_admin');

$app->get('/administration/identification', 'App\admin\identification:process')->setName('admin.identification');
$app->get('/administration/mot-de-passe-oublie', 'App\admin\mdpoubli:process')->setName('admin.mdpoubli');
$app->get('/administration/mot-de-passe-{token: [a-z0-9]+}', 'App\admin\oublimdp:process')->setName('admin.oublimdp');

$app->get('/admin', 'App\admin\accueil:process')->setName('admin.administration');
$app->get('/administration', 'App\admin\accueil2:process')->setName('admin.administration_bis')->add('App\middlewares\Permission_admin');

$app->get('/administration/parametres-{idsite: [0-9]+}', 'App\admin\parametresite:process')->setName('admin.parametresite')->add('App\middlewares\Permission_admin')->add(new Modules_auth($container,'params'));
$app->get('/administration/gestion-pages', 'App\admin\gestionpages:process')->setName('admin.gestionpages')->add('App\middlewares\Permission_admin')->add(new Modules_auth($container,'params'));
$app->get('/administration/modification-page-{id: [0-9]+}', 'App\admin\gestionpagedetail:process')->setName('admin.gestionpagedetail')->add('App\middlewares\Permission_admin')->add(new Modules_auth($container,'params'));
$app->get('/administration/ajout-page', 'App\admin\ajoutpage:process')->setName('admin.ajoutpage')->add('App\middlewares\Permission_admin')->add(new Modules_auth($container,'params'));

$app->get('/administration/ajouter-un-auteur', 'App\admin\ajoutauteur:process')->setName('admin.ajoutauteur')->add('App\middlewares\Permission_admin')->add(new Modules_auth($container,'auteurs'));
$app->get('/administration/gestion-auteurs', 'App\admin\gestionauteurs:process')->setName('admin.gestionauteurs')->add('App\middlewares\Permission_admin')->add(new Modules_auth($container,'auteurs'));
$app->get('/administration/auteur-{id: [0-9]+}', 'App\admin\gestionauteurdetail:process')->setName('admin.gestionauteurdetail')->add('App\middlewares\Permission_admin');

$app->get('/administration/zones-geographiques[-{id: [0-9]+}]', 'App\admin\gestionzones:process')->setName('admin.gestionzones')->add('App\middlewares\Permission_admin')->add(new Modules_auth($container,'params'));

$app->get('/administration/ajouter-une-galerie', 'App\admin\ajoutgalerie:process')->setName('admin.ajoutgalerie')->add('App\middlewares\Permission_admin')->add(new Modules_auth($container,'actus'));
$app->get('/administration/gestion-galeries', 'App\admin\gestiongaleries:process')->setName('admin.gestiongaleries')->add('App\middlewares\Permission_admin')->add(new Modules_auth($container,'actus'));
$app->get('/administration/galerie-{id: [0-9]+}', 'App\admin\gestiongaleriedetail:process')->setName('admin.gestiongaleriedetail')->add('App\middlewares\Permission_admin')->add(new Modules_auth($container,'actus'));

$app->get('/administration/ajouter-une-archive', 'App\admin\ajoutarchive:process')->setName('admin.ajoutarchive')->add('App\middlewares\Permission_admin')->add(new Modules_auth($container,'archives'));
$app->get('/administration/gestion-archives', 'App\admin\gestionarchives:process')->setName('admin.gestionarchives')->add('App\middlewares\Permission_admin')->add(new Modules_auth($container,'archives'));
$app->get('/administration/archive-{id: [0-9]+}', 'App\admin\gestionarchivedetail:process')->setName('admin.gestionarchivedetail')->add('App\middlewares\Permission_admin')->add(new Modules_auth($container,'archives'));

$app->get('/administration/ajouter-un-client', 'App\admin\ajoutclient:process')->setName('admin.ajoutclient')->add('App\middlewares\Permission_admin')->add(new Modules_auth($container,'clients'));
$app->get('/administration/client-{id: [0-9]+}', 'App\admin\gestionclientdetail:process')->setName('admin.gestionclientdetail')->add('App\middlewares\Permission_admin')->add(new Modules_auth($container,'clients'));
$app->get('/administration/gestion-clients', 'App\admin\gestionclients:process')->setName('admin.gestionclients')->add('App\middlewares\Permission_admin')->add(new Modules_auth($container,'clients'));

$app->get('/administration/ecrire-un-article[-{type: edito|flash}]', 'App\admin\ajoutarticle:process')->setName('admin.ajoutarticle')->add('App\middlewares\Permission_admin')->add(new Modules_auth($container,'actus'));
$app->get('/administration/gestion-tags', 'App\admin\gestiontags:process')->setName('admin.gestiontags')->add('App\middlewares\Permission_admin')->add(new Modules_auth($container,'actus','mod'));
$app->get('/administration/gestion-categories[-{idcat: [0-9]+}]', 'App\admin\gestioncategories:process')->setName('admin.gestioncategories')->add('App\middlewares\Permission_admin')->add(new Modules_auth($container,'admin'));
$app->get('/administration/gestion-articles', 'App\admin\gestionarticlesadmin:process')->setName('admin.gestionarticlesadmin')->add('App\middlewares\Permission_admin')->add(new Modules_auth($container,'actus','mod'));
$app->get('/administration/gestion-dossiers', 'App\admin\gestiondossiers:process')->setName('admin.gestiondossiers')->add('App\middlewares\Permission_admin')->add(new Modules_auth($container,'actus'));
$app->get('/administration/articles-par-auteur-{id: [0-9]+}', 'App\admin\gestionarticlesauteur:process')->setName('admin.gestionarticlesauteur')->add('App\middlewares\Permission_admin')->add(new Modules_auth($container,'actus'));
$app->get('/administration/modification-article-{id: [0-9]+}', 'App\admin\articledetailadmin:process')->setName('admin.articledetailadmin')->add('App\middlewares\Permission_admin')->add(new Modules_auth($container,'actus'));
$app->get('/administration/modification-dossier-{id: [0-9]+}', 'App\admin\gestiondossierdetail:process')->setName('admin.gestiondossierdetail')->add('App\middlewares\Permission_admin')->add(new Modules_auth($container,'actus'));

$app->get('/administration/composition-page-accueil', 'App\admin\compositionaccueil:process')->setName('admin.compositionaccueil')->add('App\middlewares\Permission_admin')->add(new Modules_auth($container,'params'));
$app->get('/administration/composition-menu', 'App\admin\compositionmenu:process')->setName('admin.compositionmenu')->add('App\middlewares\Permission_admin')->add(new Modules_auth($container,'params'));
$app->get('/administration/composition-footer', 'App\admin\compositionfooter:process')->setName('admin.compositionfooter')->add('App\middlewares\Permission_admin')->add(new Modules_auth($container,'params'));
$app->get('/administration/composition-sidebar', 'App\admin\compositionsidebar:process')->setName('admin.compositionsidebar')->add('App\middlewares\Permission_admin')->add(new Modules_auth($container,'params'));
$app->get('/administration/composition-cat-{id: [0-9]+}', 'App\admin\compositioncat:process')->setName('admin.compositioncat')->add('App\middlewares\Permission_admin')->add(new Modules_auth($container,'params'));

$app->get('/administration/gestion-abonnements', 'App\admin\gestionabonnementsadmin:process')->setName('admin.gestionabonnementsadmin')->add('App\middlewares\Permission_admin')->add(new Modules_auth($container,'abos'));
$app->get('/administration/creer-un-abonnements[-{idsite: [0-9]+}]', 'App\admin\ajouterabonnement:process')->setName('admin.ajouterabonnement')->add('App\middlewares\Permission_admin')->add(new Modules_auth($container,'abos'));

$app->get('/administration/gestion-anciens-abonnements[-{idsite: [0-9]+}]', 'App\admin\gestionabonnementsold:process')->setName('admin.gestionabonnementsold')->add('App\middlewares\Permission_admin')->add(new Modules_auth($container,'abos'));
$app->get('/administration/ajouter-un-produit', 'App\admin\ajoutproduit:process')->setName('admin.ajoutproduit')->add('App\middlewares\Permission_admin')->add(new Modules_auth($container,'abos'));
$app->get('/administration/gestion-produits', 'App\admin\gestionproduits:process')->setName('admin.gestionproduits')->add('App\middlewares\Permission_admin')->add(new Modules_auth($container,'abos'));
$app->get('/administration/abonnement-{id: [0-9]+}', 'App\admin\gestionabonnementdetailadmin:process')->setName('admin.gestionabonnementdetailadmin')->add('App\middlewares\Permission_admin')->add(new Modules_auth($container,'abos'));
$app->get('/administration/produit-{id: [0-9]+}', 'App\admin\gestionproduit:process')->setName('admin.gestionproduit')->add('App\middlewares\Permission_admin')->add(new Modules_auth($container,'abos'));

$app->get('/administration/gestion-annonces-legales', 'App\admin\gestionannonces:process')->setName('admin.gestionannonces')->add('App\middlewares\Permission_admin')->add(new Modules_auth($container,'annonces'));
$app->get('/administration/annonce-legale-{id: [0-9]+}', 'App\admin\gestionannoncedetail:process')->setName('admin.gestionannoncedetail')->add('App\middlewares\Permission_admin')->add(new Modules_auth($container,'annonces'));
$app->get('/administration/gestion-rubriques', 'App\admin\gestionannoncesrubriques:process')->setName('admin.gestionannoncesrubriques')->add('App\middlewares\Permission_admin')->add(new Modules_auth($container,'annonces'));
$app->get('/administration/ajouter-annonce-legale', 'App\admin\ajouterannoncelegale:process')->setName('admin.ajouterannoncelegale')->add('App\middlewares\Permission_admin')->add(new Modules_auth($container,'annonces'));

$app->get('/administration/gestion-publicites', 'App\admin\gestionpublicites:process')->setName('admin.gestionpublicites')->add('App\middlewares\Permission_admin')->add(new Modules_auth($container,'pubs'));
$app->get('/administration/publicite-{id: [0-9]+}', 'App\admin\gestionpublicitedetail:process')->setName('admin.gestionpublicitedetail')->add('App\middlewares\Permission_admin')->add(new Modules_auth($container,'pubs'));
$app->get('/administration/ajouter-publicite[-{id: [0-9]+}]', 'App\admin\ajouterpublicite:process')->setName('admin.ajouterpublicite')->add('App\middlewares\Permission_admin')->add(new Modules_auth($container,'pubs'));
$app->get('/administration/reporting-publicite-{id: [0-9]+}[-{idShedule: [0-9]+}]', 'App\admin\reportingpublicite:process')->setName('admin.reportingpublicite')->add('App\middlewares\Permission_admin')->add(new Modules_auth($container,'pubs'));
$app->get('/administration/calendrier-publicite', 'App\admin\calendarpublicite:process')->setName('admin.calendarpublicite')->add('App\middlewares\Permission_admin')->add(new Modules_auth($container,'pubs'));

$app->get('/administration/gestion-types', 'App\admin\gestiontypes:process')->setName('admin.gestiontypes')->add('App\middlewares\Permission_admin')->add(new Modules_auth($container,'pubs'));
$app->get('/administration/type-{id: [0-9]+}', 'App\admin\gestiontypedetail:process')->setName('admin.gestiontypedetail')->add('App\middlewares\Permission_admin')->add(new Modules_auth($container,'pubs'));

$app->get('/administration/gestion-annonceurs', 'App\admin\gestionannonceurs:process')->setName('admin.gestionannonceurs')->add('App\middlewares\Permission_admin')->add(new Modules_auth($container,'pubs'));
$app->get('/administration/annonceur-{id: [0-9]+}', 'App\admin\gestionannonceurdetail:process')->setName('admin.gestionannonceurdetail')->add('App\middlewares\Permission_admin')->add(new Modules_auth($container,'pubs'));
$app->get('/administration/ajouter-annonceur', 'App\admin\ajouterannonceur:process')->setName('admin.ajouterannonceur')->add('App\middlewares\Permission_admin')->add(new Modules_auth($container,'pubs'));

$app->get('/administration/gestion-services', 'App\admin\gestionservices:process')->setName('admin.gestionservices')->add('App\middlewares\Permission_admin')->add(new Modules_auth($container,'services'));
$app->get('/administration/service-{id: [0-9]+}', 'App\admin\gestionservicedetail:process')->setName('admin.gestionservicedetail')->add('App\middlewares\Permission_admin')->add(new Modules_auth($container,'services'));

$app->get('/administration/gestion-ventes-aux-encheres', 'App\admin\gestionencheres:process')->setName('admin.gestionencheres')->add('App\middlewares\Permission_admin')->add(new Modules_auth($container,'encheres'));
$app->get('/administration/vente-aux-encheres-{id: [0-9]+}', 'App\admin\gestionencheresdetail:process')->setName('admin.gestionencheresdetail')->add('App\middlewares\Permission_admin')->add(new Modules_auth($container,'encheres'));
$app->get('/administration/gestion-avocats', 'App\admin\gestionavocats:process')->setName('admin.gestionavocats')->add('App\middlewares\Permission_admin')->add(new Modules_auth($container,'encheres'));
$app->get('/administration/avocat-{id: [0-9]+}', 'App\admin\gestionavocatdetail:process')->setName('admin.gestionavocatdetail')->add('App\middlewares\Permission_admin')->add(new Modules_auth($container,'encheres'));
$app->get('/administration/import-avocat-{idimport: [0-9]+}', 'App\admin\gestionavocats:process')->setName('admin.gestionavocatsimport')->add('App\middlewares\Permission_admin')->add(new Modules_auth($container,'encheres'));
$app->get('/administration/gestion-tgi', 'App\admin\gestiontgi:process')->setName('admin.gestiontgi')->add('App\middlewares\Permission_admin')->add(new Modules_auth($container,'encheres'));
$app->get('/administration/tgi-{id: [0-9]+}', 'App\admin\gestiontgidetail:process')->setName('admin.gestiontgidetail')->add('App\middlewares\Permission_admin')->add(new Modules_auth($container,'encheres'));
$app->get('/administration/import-tgi-{idimport: [0-9]+}', 'App\admin\gestiontgis:process')->setName('admin.gestiontgisimport')->add('App\middlewares\Permission_admin')->add(new Modules_auth($container,'encheres'));
$app->get('/administration/ajouter-vente-aux-encheres', 'App\admin\ajouterenchere:process')->setName('admin.ajouterenchere')->add('App\middlewares\Permission_admin')->add(new Modules_auth($container,'encheres'));
$app->get('/administration/gestion-departements[-{id: [0-9]+}]', 'App\admin\gestiondepartements:process')->setName('admin.gestiondepartements')->add('App\middlewares\Permission_admin')->add(new Modules_auth($container,'encheres'));

$app->get('/administration/recherche', 'App\admin\post_recherche_topbar:process')->setName('admin.post_recherche_topbar')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');

$app->get('/administration/export-articles-txt', 'App\admin\export_articles_txt:process')->setName('admin.export_articles_txt')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf')->add(new Modules_auth($container,'actus'));
$app->get('/administration/export-articles-pdf', 'App\admin\export_articles_pdf:process')->setName('admin.export_articles_pdf')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf')->add(new Modules_auth($container,'actus'));
$app->get('/administration/export-rapport-pdf', 'App\admin\export_rapport_pdf:process')->setName('admin.export_rapport_pdf')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf')->add(new Modules_auth($container,'actus'));

$app->get('/administration/metas-google', 'App\admin\metasgoogle:process')->setName('admin.metasgoogle')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf')->add(new Modules_auth($container,'params'));

$app->post('/administration/postajouteavocat', 'App\admin\postajouteavocat:process')->setName('admin.postajouteavocat')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postmodifavocat', 'App\admin\postmodifavocat:process')->setName('admin.postmodifavocat')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postdeleteavocat', 'App\admin\postdeleteavocat:process')->setName('admin.postdeleteavocat')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postajoutetgi', 'App\admin\postajoutetgi:process')->setName('admin.postajoutetgi')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postmodiftgi', 'App\admin\postmodiftgi:process')->setName('admin.postmodiftgi')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postdeletetgi', 'App\admin\postdeletetgi:process')->setName('admin.postdeletetgi')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postajoutedepartement', 'App\admin\postajoutedepartement:process')->setName('admin.postajoutedepartement')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postmodifdepartement', 'App\admin\postmodifdepartement:process')->setName('admin.postmodifdepartement')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postdeletedepartement', 'App\admin\postdeletedepartement:process')->setName('admin.postdeletedepartement')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');

$app->post('/administration/postajoutezone', 'App\admin\postajoutezone:process')->setName('admin.postajoutezone')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postmodifzone', 'App\admin\postmodifzone:process')->setName('admin.postmodifzone')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postdeletezone', 'App\admin\postdeletezone:process')->setName('admin.postdeletezone')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');

$app->post('/administration/postajoutdossier', 'App\admin\postajoutdossier:process')->setName('admin.postajoutdossier')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postmodifdossier', 'App\admin\postmodifdossier:process')->setName('admin.postmodifdossier')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postdeletedossier', 'App\admin\postdeletedossier:process')->setName('admin.postdeletedossier')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postarticlesdossier', 'App\admin\postarticlesdossier:process')->setName('admin.postarticlesdossier')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postactivedossier', 'App\admin\postactivedossier:process')->setName('admin.postactivedossier')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');

$app->post('/administration/postmodifnamesite', 'App\admin\postmodifnamesite:process')->setName('admin.postmodifnamesite')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postdeletesite', 'App\admin\postdeletesite:process')->setName('admin.postdeletesite')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postinsertsite', 'App\admin\postinsertsite:process')->setName('admin.postinsertsite')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postparamsites', 'App\admin\postparamsites:process')->setName('admin.postparamsites')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');

$app->post('/administration/postdeleteauteur', 'App\admin\postdeleteauteur:process')->setName('admin.postdeleteauteur')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postmodifauteur', 'App\admin\postmodifauteur:process')->setName('admin.postmodifauteur')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postajoutauteur', 'App\admin\postajoutauteur:process')->setName('admin.postajoutauteur')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postmodifavatar', 'App\admin\postmodifavatar:process')->setName('admin.postmodifavatar')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postdeleteavatar', 'App\admin\postdeleteavatar:process')->setName('admin.postdeleteavatar')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postactiveauteur', 'App\admin\postactiveauteur:process')->setName('admin.postactiveauteur')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postpermissonsauteur', 'App\admin\postpermissonsauteur:process')->setName('admin.postpermissonsauteur')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postmodifaccesauteur', 'App\admin\postmodifaccesauteur:process')->setName('admin.postmodifaccesauteur')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postsignatureauteur', 'App\admin\postsignatureauteur:process')->setName('admin.postsignatureauteur')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postmodifauteurconnexion', 'App\admin\postmodifauteurconnexion:process')->setName('admin.postmodifauteurconnexion')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');

$app->post('/administration/postajoutclient', 'App\admin\postajoutclient:process')->setName('admin.postajoutclient')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postmodifclient', 'App\admin\postmodifclient:process')->setName('admin.postmodifclient')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postdeleteclient', 'App\admin\postdeleteclient:process')->setName('admin.postdeleteclient')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postmodifaccesclient', 'App\admin\postmodifaccesclient:process')->setName('admin.postmodifaccesclient')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postmodfimdpclient', 'App\admin\postmodfimdpclient:process')->setName('admin.postmodfimdpclient')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');

$app->post('/administration/postajoutredirection', 'App\admin\postajoutredirection:process')->setName('admin.postajoutredirection')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postdeleteredirection', 'App\admin\postdeleteredirection:process')->setName('admin.postdeleteredirection')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');

$app->post('/administration/postajoutupdate', 'App\admin\postajoutupdate:process')->setName('admin.postajoutupdate')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postdeleteupdate', 'App\admin\postdeleteupdate:process')->setName('admin.postdeleteupdate')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');

$app->post('/administration/postdeletetag', 'App\admin\postdeletetag:process')->setName('admin.postdeletetag')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postajouttag', 'App\admin\postajouttag:process')->setName('admin.postajouttag')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postupdatetag', 'App\admin\postupdatetag:process')->setName('admin.postupdatetag')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');

$app->post('/administration/postdeletealbum', 'App\admin\postdeletealbum:process')->setName('admin.postdeletealbum')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postajoutalbum', 'App\admin\postajoutalbum:process')->setName('admin.postajoutalbum')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postupdatealbum', 'App\admin\postupdatealbum:process')->setName('admin.postupdatealbum')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postactivealbum', 'App\admin\postactivealbum:process')->setName('admin.postactivealbum')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');

$app->post('/administration/postdeleteservice', 'App\admin\postdeleteservice:process')->setName('admin.postdeleteservice')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postajoutservice', 'App\admin\postajoutservice:process')->setName('admin.postajoutservice')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postupdateservice', 'App\admin\postupdateservice:process')->setName('admin.postupdateservice')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postactiveservice', 'App\admin\postactiveservice:process')->setName('admin.postactiveservice')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');

$app->post('/administration/postdeleteservicecontact', 'App\admin\postdeleteservicecontact:process')->setName('admin.postdeleteservicecontact')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postajoutservicecontact', 'App\admin\postajoutservicecontact:process')->setName('admin.postajoutservicecontact')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postupdateservicecontact', 'App\admin\postupdateservicecontact:process')->setName('admin.postupdateservicecontact')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');

$app->post('/administration/postdeletearchives', 'App\admin\postdeletearchives:process')->setName('admin.postdeletearchives')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postajoutarchives', 'App\admin\postajoutarchives:process')->setName('admin.postajoutarchives')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postupdatearchives', 'App\admin\postupdatearchives:process')->setName('admin.postupdatearchives')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postactivearchives', 'App\admin\postactivearchives:process')->setName('admin.postactivearchives')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');

$app->post('/administration/postajoutdatepublicite', 'App\admin\postajoutdatepublicite:process')->setName('admin.postajoutdatepublicite')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postdeletedatepublicite', 'App\admin\postdeletedatepublicite:process')->setName('admin.postdeletedatepublicite')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postdeletepublicite', 'App\admin\postdeletepublicite:process')->setName('admin.postdeletepublicite')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postajoutpublicite', 'App\admin\postajoutpublicite:process')->setName('admin.postajoutpublicite')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postupdatepublicite', 'App\admin\postupdatepublicite:process')->setName('admin.postupdatepublicite')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postactivepublicite', 'App\admin\postactivepublicite:process')->setName('admin.postactivepublicite')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postmodifdatepublicite', 'App\admin\postmodifdatepublicite:process')->setName('admin.postmodifdatepublicite')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');


$app->post('/administration/postdeleteabonnement', 'App\admin\postdeleteabonnement:process')->setName('admin.postdeleteabonnement')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postajoutabonnement', 'App\admin\postajoutabonnement:process')->setName('admin.postajoutabonnement')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postmodifabonnement', 'App\admin\postmodifabonnement:process')->setName('admin.postmodifabonnement')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postmodifetat', 'App\admin\postmodifetat:process')->setName('admin.postmodifetat')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');

$app->post('/administration/postdeleteannonceur', 'App\admin\postdeleteannonceur:process')->setName('admin.postdeleteannonceur')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postajoutannonceur', 'App\admin\postajoutannonceur:process')->setName('admin.postajoutannonceur')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postmodifannonceur', 'App\admin\postmodifannonceur:process')->setName('admin.postmodifannonceur')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');

$app->post('/administration/postdeletecontact', 'App\admin\postdeletecontact:process')->setName('admin.postdeletecontact')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postajoutcontact', 'App\admin\postajoutcontact:process')->setName('admin.postajoutcontact')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postmodifcontact', 'App\admin\postmodifcontact:process')->setName('admin.postmodifcontact')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');

$app->post('/administration/postdeletepage', 'App\admin\postdeletepage:process')->setName('admin.postdeletepage')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postajoutpage', 'App\admin\postajoutpage:process')->setName('admin.postajoutpage')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postmodifpage', 'App\admin\postmodifpage:process')->setName('admin.postmodifpage')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');

$app->post('/administration/postmodiffooter', 'App\admin\postmodiffooter:process')->setName('admin.postmodiffooter')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');

$app->post('/administration/postmodifsidebar', 'App\admin\postmodifsidebar:process')->setName('admin.postmodifsidebar')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');

$app->post('/administration/postactiveenchere', 'App\admin\postactiveenchere:process')->setName('admin.postactiveenchere')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postdeleteenchere', 'App\admin\postdeleteenchere:process')->setName('admin.postdeleteenchere')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postajoutenchere', 'App\admin\postajoutenchere:process')->setName('admin.postajoutenchere')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postmodifenchere', 'App\admin\postmodifenchere:process')->setName('admin.postmodifenchere')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postdeletelot', 'App\admin\postdeletelot:process')->setName('admin.postdeletelot')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postajoutlot', 'App\admin\postajoutlot:process')->setName('admin.postajoutlot')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postmodiflot', 'App\admin\postmodiflot:process')->setName('admin.postmodiflot')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');

$app->post('/administration/postajoutarticle', 'App\admin\postajoutarticle:process')->setName('admin.postajoutarticle')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postmodifparamsarticle', 'App\admin\postmodifparamsarticle:process')->setName('admin.postmodifparamsarticle')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postmodifarticle', 'App\admin\postmodifarticle:process')->setName('admin.postmodifarticle')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postdeletearticle', 'App\admin\postdeletearticle:process')->setName('admin.postdeletearticle')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');

$app->post('/administration/postajoutcategorie', 'App\admin\postajoutcategorie:process')->setName('admin.postajoutcategorie')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postmodifcategorie', 'App\admin\postmodifcategorie:process')->setName('admin.postmodifcategorie')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postdeletecategorie', 'App\admin\postdeletecategorie:process')->setName('admin.postdeletecategorie')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');

$app->post('/administration/postinsertrubrique', 'App\admin\postinsertrubrique:process')->setName('admin.postinsertrubrique')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postmodifrubrique', 'App\admin\postmodifrubrique:process')->setName('admin.postmodifrubrique')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postdeleterubrique', 'App\admin\postdeleterubrique:process')->setName('admin.postdeleterubrique')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');

$app->post('/administration/postmodiftype', 'App\admin\postmodiftype:process')->setName('admin.postmodiftype')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postinserttype', 'App\admin\postinserttype:process')->setName('admin.postinserttype')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postinserttypeoption', 'App\admin\postinserttypeoption:process')->setName('admin.postinserttypeoption')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postdeletetype', 'App\admin\postdeletetype:process')->setName('admin.postdeletetype')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postmodifoptiontype', 'App\admin\postmodifoptiontype:process')->setName('admin.postmodifoptiontype')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postdeleteoptiontype', 'App\admin\postdeleteoptiontype:process')->setName('admin.postdeleteoptiontype')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');

$app->post('/administration/postinsertannonce', 'App\admin\postinsertannonce:process')->setName('admin.postinsertannonce')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postmodifannonce', 'App\admin\postmodifannonce:process')->setName('admin.postmodifannonce')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postdeleteannonce', 'App\admin\postdeleteannonce:process')->setName('admin.postdeleteannonce')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postactiveannonce', 'App\admin\postactiveannonce:process')->setName('admin.postactiveannonce')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');

$app->post('/administration/postajoutproduit', 'App\admin\postajoutproduit:process')->setName('admin.postajoutproduit')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postmodifproduit', 'App\admin\postmodifproduit:process')->setName('admin.postmodifproduit')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postactiveproduit', 'App\admin\postactiveproduit:process')->setName('admin.postactiveproduit')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postmodifsiteproduit', 'App\admin\postmodifsiteproduit:process')->setName('admin.postmodifsiteproduit')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postajoutoption', 'App\admin\postajoutoption:process')->setName('admin.postajoutoption')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postmodifoption', 'App\admin\postmodifoption:process')->setName('admin.postmodifoption')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postsupprimeoption', 'App\admin\postsupprimeoption:process')->setName('admin.postsupprimeoption')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postajoutpromo', 'App\admin\postajoutpromo:process')->setName('admin.postajoutpromo')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postmodifpromo', 'App\admin\postmodifpromo:process')->setName('admin.postmodifpromo')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postdeletepromo', 'App\admin\postdeletepromo:process')->setName('admin.postdeletepromo')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postmodifalbumproduit', 'App\admin\postmodifalbumproduit:process')->setName('admin.postmodifalbumproduit')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');

$app->post('/administration/postadmin_connexion', 'App\admin\postadmin_connexion:process')->setName('admin.postadmin_connexion')->add('App\middlewares\Csrf');
$app->post('/administration/postadmin_demande_oubli_mdp', 'App\admin\postadmin_demande_oubli_mdp:process')->setName('admin.postadmin_demande_oubli_mdp')->add('App\middlewares\Csrf');
$app->post('/administration/postregeneremdp', 'App\admin\postregeneremdp:process')->setName('admin.postregeneremdp')->add('App\middlewares\Csrf');

$app->post('/administration/postexport', 'App\admin\postexport:process')->setName('admin.postexport')->add('App\middlewares\Csrf');
$app->post('/administration/postcomposition', 'App\admin\postcomposition:process')->setName('admin.postcomposition')->add('App\middlewares\Csrf');
$app->post('/administration/postcompositionvalidation', 'App\admin\postcompositionvalidation:process')->setName('admin.postcompositionvalidation')->add('App\middlewares\Csrf');
$app->post('/administration/postcompositioncat', 'App\admin\postcompositioncat:process')->setName('admin.postcompositioncat')->add('App\middlewares\Csrf');
$app->post('/administration/postcompositioncatvalidation', 'App\admin\postcompositioncatvalidation:process')->setName('admin.postcompositioncatvalidation')->add('App\middlewares\Csrf');

$app->post('/administration/postmetadonnees', 'App\admin\postmetadonnees:process')->setName('admin.postmetadonnees')->add('App\middlewares\Csrf');
$app->post('/administration/postmetadonneesdelete', 'App\admin\postmetadonneesdelete:process')->setName('admin.postmetadonneesdelete')->add('App\middlewares\Csrf');

// Routes pour afficher le spages qui concernent les catégories des annonces
$app->get('/administration/gestion-ads-categories', 'App\admin\gestionadscategories:process')->setName('admin.gestionadscategories')->add('App\middlewares\Permission_admin');
$app->get('/administration/ajout-ads-categorie', 'App\admin\ajoutadscategorie:process')->setName('admin.ajoutadscategorie')->add('App\middlewares\Permission_admin');
$app->get('/administration/ads-categorie-{id: [0-9]+}', 'App\admin\gestionadscategoriedetail:process')->setName('admin.gestionadscategoriedetail')->add('App\middlewares\Permission_admin');

// Rotues pour les opérations CRUD des catégories
$app->post('/administration/postajoutadscategorie', 'App\admin\postajoutadscategorie:process')->setName('admin.postajoutadscategorie')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postmodifadscategorie', 'App\admin\postmodifadscategorie:process')->setName('admin.postmodifadscategorie')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postdeleteadscategorie', 'App\admin\postdeleteadscategorie:process')->setName('admin.postdeleteadscategorie')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');

// Routes pour afficher les pages qui concernent les annonces
$app->get('/administration/gestion-ads', 'App\admin\gestionads:process')->setName('admin.gestionads')->add('App\middlewares\Permission_admin')->add(new Modules_auth($container,'ads'));
$app->get('/administration/ajout-ad', 'App\admin\ajoutad:process')->setName('admin.ajoutad')->add('App\middlewares\Permission_admin')->add(new Modules_auth($container,'ads'));
$app->get('/administration/ad-{id: [0-9]+}', 'App\admin\gestionaddetail:process')->setName('admin.gestionaddetail')->add('App\middlewares\Permission_admin')->add(new Modules_auth($container,'ads'));

// Routes pour les opérations CRUD des catégories
$app->post('/administration/postajoutad', 'App\admin\postajoutad:process')->setName('admin.postajoutad')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postmodifad', 'App\admin\postmodifad:process')->setName('admin.postmodifad')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postmodifitems', 'App\admin\postmodifitems:process')->setName('admin.postmodifitems')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postdeletead', 'App\admin\postdeletead:process')->setName('admin.postdeletead')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');

// Routes pour afficher les item_types 
$app->get('/administration/gestion-ads-itemtypes', 'App\admin\gestionadsitemtypes:process')->setName('admin.gestionadsitemtypes')->add('App\middlewares\Permission_admin');
$app->get('/administration/ajout-ads-itemtype', 'App\admin\ajoutadsitemtype:process')->setName('admin.ajoutadsitemtype')->add('App\middlewares\Permission_admin');
$app->get('/administration/ads-itemtype-{id: [0-9]+}', 'App\admin\gestionadsitemtypedetail:process')->setName('admin.gestionadsitemtypedetail')->add('App\middlewares\Permission_admin');

// Opérations CRUD des item_types
$app->post('/administration/postajoutadsitemtype', 'App\admin\postajoutadsitemtype:process')->setName('admin.postajoutadsitemtype')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postmodifadsitemtype', 'App\admin\postmodifadsitemtype:process')->setName('admin.postmodifadsitemtype')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
$app->post('/administration/postdeleteadsitemtype', 'App\admin\postdeleteadsitemtype:process')->setName('admin.postdeleteadsitemtype')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');

// Opération CRUD des items
$app->post('/administration/postdeleteadsitem', 'App\admin\postdeleteadsitem:process')->setName('admin.postdeleteadsitem')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');


// Opération CRUD des items par défaut des catégories
$app->post('/administration/postmodifcatitem', 'App\admin\postmodifcatitem:process')->setName('admin.postmodifcatitem')->add('App\middlewares\Permission_admin')->add('App\middlewares\Csrf');
