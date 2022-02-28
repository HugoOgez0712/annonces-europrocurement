<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center"
        href="<?= $router->pathFor('site.index') ?>">
        <div class="sidebar-brand-text mx-3"><?= $site_nom ?></div>
    </a>


    <hr class="sidebar-divider my-0">

    <?php
    $show = in_array($path, ['admin.administration']) ? 'active' : null;
    ?>

    <!-- Nav Item - Dashboard  -->
    <li class="nav-item <?= $show ?>">
        <a class="nav-link" href="<?= $router->pathFor('admin.administration_bis') ?>">
            <i class="fas fa-home"></i>
            <span>Tableau de bord</span>
        </a>
    </li>

    <?php if(in_array($_SESSION['admin']['aut_lvl_admin'], [3,4]) || in_array('auteurs', $_SESSION['admin']['modules'])): ?>


    <hr class="sidebar-divider">

    <?php
    $show = in_array($path, ['admin.gestionauteurs','admin.ajoutauteur','admin.gestionauteurdetail']) ? 'active' : null;
    ?>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item <?= $show ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true"
            aria-controls="collapseTwo">
            <i class="fas fa-user-edit"></i>
            <span>Auteurs</span>
        </a>

        <div id="collapseTwo" class="collapse " aria-labelledby="headingTwo"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="<?= $router->pathFor('admin.gestionauteurs') ?>">Tous les auteurs</a>
                <a class="collapse-item" href="<?= $router->pathFor('admin.ajoutauteur') ?>">Ajouter un auteur</a>
            </div>
        </div>
    </li>
    <?php endif; ?>

    <?php if(in_array($_SESSION['admin']['aut_lvl_admin'], [3,4]) || in_array('actus', $_SESSION['admin']['modules'])): ?>
        <hr class="sidebar-divider">
        <?php
            $show = in_array($path, ['admin.gestionarticlesadmin','admin.gestiondossierdetail','admin.gestiondossiers','admin.articledetailadmin','admin.gestioncategories','admin.gestionarticlesauteur','admin.ajoutarticle','admin.gestiontags','admin.gestioncategories','admin.gestiongaleries','admin.gestiongaleriedetail','admin.ajoutgalerie']) ? 'active' : null;
        ?>

        <?php if($_SESSION['admin']['aut_lvl_admin'] == 1 ): ?>

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item <?= $show ?>">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse4" aria-expanded="true" aria-controls="collapse4">
                <i class="fas fa-edit"></i>
                <span>Articles</span>
            </a>
            <div id="collapse4" class="collapse " aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="<?= $router->pathFor('admin.gestionarticlesauteur',['id' => $_SESSION['admin']['aut_id']]) ?>">Mes articles</a>
                    <a class="collapse-item" href="<?= $router->pathFor('admin.ajoutarticle') ?>">Ajouter un article</a>
                </div>
            </div>
        </li>

        <?php else: ?>

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item <?= $show ?>">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse4" aria-expanded="true" aria-controls="collapse4">
                <i class="fas fa-edit"></i>
                <span>Articles</span>
            </a>
            <div id="collapse4" class="collapse " aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="<?= $router->pathFor('admin.gestionarticlesadmin') ?>">Les articles</a>
                    <a class="collapse-item" href="<?= $router->pathFor('admin.ajoutarticle') ?>">Ajouter un article</a>
                    <hr>
                    <?php if($_SESSION['admin']['aut_lvl_admin'] >= 2): ?>
                    <a class="collapse-item" href="<?= $router->pathFor('admin.compositionaccueil') ?>">Composition accueil</a>
                    <hr>
                    <?php endif; ?>
                    <a class="collapse-item" href="<?= $router->pathFor('admin.gestiondossiers') ?>">Les dossiers</a>
                    <hr>
                    <a class="collapse-item" href="<?= $router->pathFor('admin.gestiongaleries') ?>">Les galeries</a>
                    <a class="collapse-item" href="<?= $router->pathFor('admin.ajoutgalerie') ?>">Ajouter une galerie</a>
                    <?php if($_SESSION['admin']['aut_lvl_admin'] >= 2): ?>
                    <hr>
                    <a class="collapse-item" href="<?= $router->pathFor('admin.gestioncategories') ?>">Les catégories</a>
                    <?php endif; ?>
                    <hr>
                    <a class="collapse-item" href="<?= $router->pathFor('admin.gestiontags') ?>">Les tags</a>
                </div>
            </div>
        </li>
        <?php endif; ?>

    <?php endif; ?>
    <?php if($_SESSION['admin']['aut_lvl_admin'] >= 3 ): ?>
    <hr class="sidebar-divider">
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#page" aria-expanded="true" aria-controls="page">
            <i class="fas fa-file-alt"></i>
            <span>Pages</span>
        </a>
        <div id="page" class="collapse " aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="<?= $router->pathFor('admin.ajoutpage') ?>">Ajouter une page</a>
                <a class="collapse-item" href="<?= $router->pathFor('admin.gestionpages') ?>">Gestion des pages</a>
            </div>
        </div>
    </li>
    <?php endif; ?>
    <?php
    if(in_array($_SESSION['admin']['aut_lvl_admin'], [3,4]) || in_array('abos', $_SESSION['admin']['modules'])):
        $show = in_array($path, ['admin.gestionabonnementsadmin','admin.gestionabonnementdetailadmin','admin.gestionproduit','admin.ajouterabonnement','admin.gestionproduits','admin.ajoutproduit','admin.gestionabonnementsold']) ? 'active' : null;
    ?>
    <hr class="sidebar-divider">
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item <?= $show ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse5" aria-expanded="true"
            aria-controls="collapse5">
            <i class="fas fa-shopping-cart"></i>
            <span>Abonnements</span>
        </a>
        <div id="collapse5" class="collapse " aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="<?= $router->pathFor('admin.gestionproduits') ?>">Les produits</a>
                <a class="collapse-item" href="<?= $router->pathFor('admin.ajoutproduit') ?>">Ajouter un produit</a>
                <hr>
                <a class="collapse-item" href="<?= $router->pathFor('admin.gestionabonnementsadmin') ?>">Tous les abonnements</a>
                <a class="collapse-item" href="<?= $router->pathFor('admin.ajouterabonnement') ?>">Ajouter un abonnement</a>
                <hr>
                <a class="collapse-item" href="<?= $router->pathFor('admin.gestionabonnementsold') ?>">Anciens abonnements</a>
            </div>
        </div>
    </li>
    <?php endif; ?>

    <?php if(in_array($_SESSION['admin']['aut_lvl_admin'], [3,4]) || in_array('cliens', $_SESSION['admin']['modules'])): ?>
    <?php
        $show = in_array($path, ['admin.gestionclients','admin.ajoutclient','admin.gestionclientdetail']) ? 'active' : null;
    ?>
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item <?= $show ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse3" aria-expanded="true"
            aria-controls="collapse3">
            <i class="fas fa-users"></i>
            <span>Clients</span>
        </a>
        <div id="collapse3" class="collapse " aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="<?= $router->pathFor('admin.gestionclients') ?>">Tous les clients</a>
                <a class="collapse-item" href="<?= $router->pathFor('admin.ajoutclient') ?>">Ajouter un client</a>
            </div>
        </div>
    </li>
    <?php endif; ?>




<!--  Ajout d'une annonce (ads)  -->
<?php if(in_array($_SESSION['admin']['aut_lvl_admin'], [3,4]) || in_array('ads', $_SESSION['admin']['modules'])): ?>
    <?php
        $show = in_array($path, ['admin.gestionads','admin.ajoutad', 'admin.gestionadscategories', 'admin.ajoutadscategorie', 'admin.gestionadsitemtypes', 'admin.ajoutadsitemtype']) ? 'active' : null;
    ?>
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#annonces-menu" aria-expanded="true"
            aria-controls="annonces-menu">
            <i class="fa fa-bell"></i>
            <span>Annonces</span>
        </a>
        <div id="annonces-menu" class="collapse " aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="<?= $router->pathFor('admin.gestionads') ?>">Toutes les annonces</a>
                <a class="collapse-item" href="<?= $router->pathFor('admin.ajoutad') ?>">Ajouter une annonce</a>
                <a class="collapse-item" href="<?= $router->pathFor('admin.gestionadscategories') ?> ">Toutes les catégories</a> 
                 <a class="collapse-item" href="<?= $router->pathFor('admin.ajoutadscategorie') ?> ">Ajouter une catégorie</a> 
                 <a class="collapse-item" href="<?= $router->pathFor('admin.gestionadsitemtypes') ?> ">Tous les type d'items</a> 
                 <a class="collapse-item" href="<?= $router->pathFor('admin.ajoutadsitemtype') ?> ">Ajouter un type d'item</a> 
               
            </div>
        </div>
    </li>
    <?php endif; ?>


    



    <?php if(in_array($_SESSION['admin']['aut_lvl_admin'], [3,4]) || in_array('encheres', $_SESSION['admin']['modules'])): ?>
    <?php
        $show = in_array($path, ['admin.gestionencheres','admin.gestionencheresdetail','admin.ajouterenchere','admin.gestionavocats','admin.gestiontgidetail','admin.gestiontgi','admin.gestiondepartements']) ? 'active' : null;
    ?>

    <hr class="sidebar-divider">

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item <?= $show ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse6" aria-expanded="true"
            aria-controls="collapse6">
            <i class="fas fa-gavel"></i>
            <span>Ventes aux enchères</span>
        </a>
        <div id="collapse6" class="collapse " aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="<?= $router->pathFor('admin.gestionencheres') ?>">Toutes les enchères</a>
                <a class="collapse-item" href="<?= $router->pathFor('admin.ajouterenchere') ?>">Ajouter une enchère</a>
                <hr>
                <a class="collapse-item" href="<?= $router->pathFor('admin.gestionavocats') ?>">Les avocats</a>
                <hr>
                <a class="collapse-item" href="<?= $router->pathFor('admin.gestiontgi') ?>">Les TGI</a>
                <hr>
                <a class="collapse-item" href="<?= $router->pathFor('admin.gestiondepartements') ?>">Les départements</a>
            </div>
        </div>
    </li>
    <?php endif; ?>

    <?php if(in_array($_SESSION['admin']['aut_lvl_admin'], [3,4]) || in_array('annonces', $_SESSION['admin']['modules'])): ?>
    <?php
        $show = in_array($path, ['admin.gestionannonces','admin.ajouterannoncelegale','admin.gestionannoncedetail','admin.gestionannoncesrubriques','admin.ajouterannoncelegale']) ? 'active' : null;
    ?>

    <hr class="sidebar-divider">

    <!-- Nav Item - Pages Collapse Menu -->
    <!--
    <li class="nav-item <?= $show ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse7" aria-expanded="true"
            aria-controls="collapse6">
            <i class="fas fa-newspaper"></i>
            <span>Annonces légales</span>
        </a>
        <div id="collapse7" class="collapse " aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="<?= $router->pathFor('admin.gestionannonces') ?>">Toutes les annonces</a>
                <a class="collapse-item" href="<?= $router->pathFor('admin.ajouterannoncelegale') ?>">Ajouter une annonce</a>
                <hr>
                <a class="collapse-item" href="<?= $router->pathFor('admin.gestionannoncesrubriques') ?>">Les rubriques</a>
            </div>
        </div>
    </li>
    <?php endif; ?>

    <?php if(in_array($_SESSION['admin']['aut_lvl_admin'], [3,4]) || in_array('archives', $_SESSION['admin']['modules'])): ?>
    <?php
        $show = in_array($path, ['admin.gestionarchives','admin.ajouterarchivelegale','admin.gestionarchivedetail','admin.gestionarchivesrubriques','admin.ajouterarchivelegale']) ? 'active' : null;
    ?>

    <hr class="sidebar-divider">
    -->
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item <?= $show ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse7b" aria-expanded="true"
            aria-controls="collapse6">
            <i class="fa fa-newspaper-o" aria-hidden="true"></i>
            <span>Journaux PDF</span>
        </a>
        <div id="collapse7b" class="collapse " aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="<?= $router->pathFor('admin.gestionarchives') ?>">Tous les journaux</a>
                <a class="collapse-item" href="<?= $router->pathFor('admin.ajoutarchive') ?>">Ajouter un journal</a>
            </div>
        </div>
    </li>
    <?php endif; ?>

    <?php if(in_array($_SESSION['admin']['aut_lvl_admin'], [3,4]) || in_array('services', $_SESSION['admin']['modules'])): ?>

    <?php
        $show = in_array($path, ['admin.gestionservices','admin.gestionservicedetail']) ? 'active' : null;
    ?>
    <hr class="sidebar-divider">

    <!-- Nav Item - Pages Collapse Menu -->
    <!--
    <li class="nav-item <?= $show ?>">
        <a class="nav-link" href="<?= $router->pathFor('admin.gestionservices') ?>">
            <i class="fas fa-sitemap"></i>
            <span>Services</span>
        </a>
    </li>
    <?php endif; ?>

    <?php if(in_array($_SESSION['admin']['aut_lvl_admin'], [3,4]) || in_array('pubs', $_SESSION['admin']['modules'])): ?>

    <hr class="sidebar-divider">
    -->
    <?php
        $show = in_array($path, ['admin.gestionpublicites','admin.gestiontypedetail','admin.gestionpublicitedetail','admin.gestionannonceurdetail','admin.ajouterannonceur','admin.gestioncontacts','admin.gestiontypes','admin.ajouterpublicite','admin.reportingpublicite','admin.gestionannonceurs']) ? 'active' : null;
    ?>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item <?= $show ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse8" aria-expanded="true"
            aria-controls="collapse8">
            <i class="fas fa-bullhorn"></i>
            <span>Publicité</span>
        </a>
        <div id="collapse8" class="collapse " aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="<?= $router->pathFor('admin.gestionpublicites') ?>">Toutes les publicités</a>
                <a class="collapse-item" href="<?= $router->pathFor('admin.ajouterpublicite') ?>">Ajouter une publicité</a>
                <hr>
                <a class="collapse-item" href="<?= $router->pathFor('admin.gestionannonceurs') ?>">Les annonceurs</a>
                <a class="collapse-item" href="<?= $router->pathFor('admin.ajouterannonceur') ?>">Ajouter un annonceur</a>
                <hr>
                <a class="collapse-item" href="<?= $router->pathFor('admin.gestiontypes') ?>">Types de publicité</a>
            </div>
        </div>
    </li>
    <?php endif; ?>

    <?php if($_SESSION['admin']['aut_lvl_admin'] == 4): ?>

    <hr class="sidebar-divider">

    <?php
        $show = in_array($path, ['admin.parametresite','admin.gestionzones','admin.compositionfooter','admin.compositionsidebar','admin.compositionmenu','admin.gestionpages','admin.gestionpagedetail','admin.ajoutpage']) ? 'active' : null;
    ?>
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item <?= $show ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse9" aria-expanded="true"
            aria-controls="collapse9">
            <i class="fas fa-cog"></i>
            <span>Paramètres</span>
        </a>
        <div id="collapse9" class="collapse " aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="<?= $router->pathFor('admin.parametresite',['idsite' => $idsite]) ?>">Paramètres</a>
                <a class="collapse-item" href="<?= $router->pathFor('admin.metasgoogle') ?>">Metas Google</a>
                <a class="collapse-item" href="<?= $router->pathFor('admin.compositionmenu') ?>">Composition Menu</a>
                <!-- <a class="collapse-item" href="<?= $router->pathFor('admin.compositionfooter') ?>">Composition Footer</a> -->
                <a class="collapse-item" href="<?= $router->pathFor('admin.compositionsidebar') ?>">Composition Sidebar</a>
                <a class="collapse-item" href="<?= $router->pathFor('admin.gestionzones') ?>">Zones géographiques</a>
            </div>
        </div>
    </li>
    <?php endif; ?>


    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->