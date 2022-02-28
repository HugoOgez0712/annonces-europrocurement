<?php
namespace App\admin;

use App\helpers\Util;
use App\classes\ClassAdmin;
use App\classes\ClassAuteurs;
use App\classes\ClassMigr;
use App\helpers\SimpleImage;
use App\helpers\Exc;
use Exception;
use Google\Service\Script;

// Ce module sert à envoyer toutes les données nécessaires à la création de la page d'ajout d'une annonce en se basant sur les méthodes de la classAds
class accueil2 extends \App\views\Genere_admin {

    public $container;

    public function __construct($container){
        $this->container = $container;
        $image = null;
    }

    public function process($request, $response) {

        $datas = [];


        $admin = new ClassAdmin($this->container);

        $auteurs = new ClassAuteurs($this->container);
        

    //     try{
    //         $image = new SimpleImage();
       

    //   $image->fromFile(__DIR__ . '/chiot.jpg')
    //   ->resize(800, null)
    //   ->toFile( __DIR__ .'/images-test/chiot-copie.webp', "image/webp");

    //     }catch( Exception $err) {
    //         // Handle errors
    //         echo $err->getMessage();
    //       }
        

     


        // PARTIE MIGR 

        $migr = new ClassMigr($this->container);

        $id = 48925;
        
        $article = $migr->getArticle($id);
        $path = __DIR__ . "/../../" . ROOT;
       
        
        $countImgMain = $migr->countMainImgFromArticle($id);
       
        $like = '<img';
        $countImgText = $migr->countTextImgFromArticle($id);
 
 
        $count = $countImgMain + $countImgText;

        $html = '<p> Trois ans de travaux et un investissement de 57,4 millions d&rsquo;euros* : c&rsquo;est le temps et l&rsquo;argent qui auront été nécessaires à la Communauté urbaine Marseille Provence Métropole (MPM) pour réaliser l&rsquo;extension de son réseau de tramway. Ce projet controversé, car aménagé dans un secteur déjà doté de deux lignes de métro, a permis de déployer le tram sur la rue de Rome, l&rsquo;une des artères commerçantes de l&rsquo;hyper-centre (1,2 km). Le nouvel axe relie Arenc, au c&oelig;ur du quartier d&rsquo;affaires d&rsquo;Euroméditerranée, à la place Castellane, l&rsquo;un des principaux hubs du réseau de transport en commun en site propre (TCSP) marseillais, où convergent deux lignes de métro et les bus des réseaux urbains et départementaux.</p> <h2> Une rue apaisée</h2> <p> A l&rsquo;instar de la cure de jouvence subie par les autres grandes artères du centre-ville (Canebière, rue de la République, boulevard Longchamp, cours Belsunce...), la création du tram a été l&rsquo;occasion de revoir entièrement l&rsquo;aménagement de la rue de Rome et du cours Saint-Louis.</p> <p> Le lifting piloté par Christophe Fayel a joué la carte de la sobriété. Revêtement en granit gris clair, signalétique épurée, éclairage discret mettant en valeur les façades des immeubles, mobilier urbain contemporain dénué de bling-bling..., l&rsquo;ancienne rue commerçante en souffrance, envahie par les gaz d&rsquo;échappement, s&rsquo;est transformée en boulevard urbain propice à la déambulation. Entre La Préfecture et Castellane, les passants peuvent ainsi cheminer entre deux rangées de magnolias. «La plus grande récompense, c&rsquo;est quand j&rsquo;entends les gens me dire qu&rsquo;ils ne se souviennent plus comment la rue était avant», sourit l&rsquo;architecte.</p> <p> Sur le plan fonctionnel, le lifting a été pensé en trois séquences : la partie étroite (entre Canebière et Préfecture) est entièrement piétonne ; au niveau de Préfecture, l&rsquo;espace piéton a été élargi donnant un visage apaisé à la place de Rome ; enfin, sur la partie large (Préfecture-Castellane), une voie de circulation montante de 3,5 m de large a été aménagée le long de la plateforme du tram.</p> <h2> Les commerc&#8203;es en reconquête</h2> <p> Le chantier du tram a-t-il fait dérailler les commerces de la rue de Rome ? A compter le nombre de rideaux baissés le long de l&rsquo;artère (63 au total), la question mérite d&rsquo;être posée. Selon Nicole Richard-Verspieren, vice-présidente commerce, à la CGPME des Bouches-du-Rhône (Confédération Générale des Petites et Moyennes Entreprises), «20% des commerces de la rue de Rome ont fermé». Déjà chancelante avant le tram, l&rsquo;activité de ces boutiques n&rsquo;a pas résisté à la conjonction des travaux et de l&rsquo;ouverture des Terrasses du Port.</p> <p> Plus de la moitié des 259 commerces de la rue, a déposé un dossier à MPM pour obtenir indemnisation. Selon Guy Teissier «62 demandes ont été acceptées pour un montant d&rsquo;indemnisation global de 809.294 euros». Conscient de «la galère» endurée par les commerçants, le président de MPM espère que la requalification de la rue «lui rendra sa vocation d&rsquo;artère dédiée au commerce de proximité». Histoire également de lui permettre «de résister à la concurrence farouche des grands centres commerciaux» actuels (Centre Bourse, Terrasses du Port) et futurs (Centre commercial du Stade, Bleu Capelette).</p><div class="encadre"><h2> Booster la fréque&#8203;ntation</h2> <p> Après des débuts très timides (39.000 voyageurs/jour en 2009), la fréquentation du tramway monte en puissance : l&rsquo;an dernier, le réseau de tramway marseillais a transporté plus de 18 millions de voyageurs (soit 11% des voyageurs transportés sur le réseau de la RTM). Maxime Tommasini, président de la RTM, espère que la mise en service de cette troisième ligne permettra au tram de se rapprocher de l&rsquo;objectif de 120.000 voyageurs/jour, voire de le dépasser si les prolongements se réalisent d&rsquo;ici 2022&hellip;</p> <p> A cette échéance, le patron de la RTM espère que la densification de son réseau de TCSP, permettra de faire grimper «à 20% la part modale des transports collectifs dans les déplacements des Marseillais». Un ratio qui rapprochera alors Marseille des autres grandes villes. Car en dépit des efforts déployés ces dernières années, pour étoffer l&rsquo;offre de TCSP, la deuxième ville du pays reste à la traîne : avec 53.000 voyageurs quotidiens, son tramway est à des années-lumière des résultats de villes pourtant moins peuplées, comme Strasbourg (300.000 voyageurs/jour), Bordeaux (282.000), Nantes (274.000), Lyon (244.000) et Grenoble (210.000).</p> <p> <img alt="" src="/content/articles/80/raseau-tram.jpg" style="width: 100%;" /></p> <p> <strong>Larticle de William Allaire est à lire dans le numéro 9847 des Nouvelles Publications.</strong></p></div>';

        $doc = new \DOMDocument();
        @$doc->loadHTML($html);


   
        $tags = $doc->getElementsByTagName('img');
        $nbImage = 0;

        $arrayImage = [];
        foreach ($tags as $tag) {
            $src =  $tag->getAttribute('src'); 
            $arrayImage[] =  $src;
            $nbImage++;
            
        }

        $taille = getimagesize($path.$article->art_img_principale);
        $src = $path.$article->art_img_principale;
        $check = 1;
        $width = $taille[0];
        $height = $taille[1];
        $poids = filesize($path.$article->art_img_principale);


        $imageText = $article->art_photo_desc;
        $imageSizeInfo = getimagesize($path.$article->art_img_principale, $infos);
        $iptc = null;
        if(isset($infos)){
            $iptc =null;
        }

        $imageInfos = [
            'art_id' => $article->art_id,
            'src' => $article->art_img_principale,
            'check'=> $check, 
            'poids'=> $poids, 
            'width'=> $width, 
            'height'=> $height, 
            'iptc'=> $iptc, 
            'imageText'=> $imageText
        ];

    


        // $migr->insertArticle($article, $count);
       
        $migr->insertPublicImages($imageInfos);

   

        // FIN PARTIE MIGR


        $idsite = $this->container->globals['idsite'];

        $currentYear = date("Y");

        $totalAuteurs = $auteurs->getcountAuteurs();

        $liste_cat_art = null;

        $allCats = $admin->get_cat_stats($idsite); 

        $datas['countAuteurs'] =  $totalAuteurs;

        $datas['allCats'] =  $allCats;

        $datas['allArt'] = $admin->stat_nbarticles($idsite);

        $datas['monthly_stat'] = $admin->stat_monthly($idsite);

        $datas['currentyear_stat'] = $admin->stat_currentyear($currentYear);

        $monthStats = $admin->stat_monthly($idsite);
    
        $mois = [
            '01' => 'janvier',
            '02' => 'février',
            '03' => 'mars',
            '04' => 'avril',
            '05' => 'mai',
            '06' => 'juin',
            '07' => 'juillet',
            '08' => 'août',
            '09' => 'septembre',
            '10' => 'octobre',
            '11' => 'novembre',
            '12' => 'décembre'
        
        ];
        $labels = [];
        foreach($monthStats as $month){
            if(!is_null($month->month) && $month->year >= 2019):
                $goodMonth = strlen($month->month) == 1 ? '0' . $month->month : $month->month;
            $labels[] = "'" . $mois[$goodMonth] . " " . $month->year . "'";
            endif;
        }

   

        $vues = [];
        foreach($monthStats as $count){
            if(!is_null($count->month) && $count->year >= 2019):
                $vues[] = $count->count;
                endif;
        }

        
        $datas['labels'] =  $labels;
        $datas['vues'] =  $vues;
    
        // $datas['sites'] = $admin->liste_sites();
        // $datas['stat'] = $admin->statistiques_accueil($this->container->globals['idsite']);//Util::dump($datas['stat']);exit;

        $datas['js'] = 'admin_accueil';

      

       

        $request = $request->withAttribute('datas', $datas);
        return $this->render($request,$response, 'admin/accueil');

    }

}