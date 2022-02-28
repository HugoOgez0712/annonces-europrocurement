<?php 

namespace App\classes;

use App\helpers\Util;

class ClassMigr {
    private $bd;
	private $container;
    private $total;
    private $site_id;


    public function __construct($container){
        $this->container = $container;
        $this->bd = $this->container->bdd;
        $this->site_id = $container['globals']['idsite'];
    }

     /**
     *  Cette méthode permet de savoir si une image principale existe ou non
     *
     * @param  int $id
     * 
     * @return int
     **/
    public function countTextImgFromArticle($id){
        // $sql = "SELECT COUNT(art_img_principale) AS count FROM articles WHERE art_id = " . $id;
        // return $this->bd->count($sql); 
        $like = '<img';
        return $this->bd
        ->count("art_texte")
        ->table("articles")
        ->where("art_texte LIKE '%".$like."%'", "art_id = ?")
        ->fetchcount($id);
    }
    
     /**
     *  Cette méthode permet de savoir si une image principale existe ou non
     *
     * @param  int $id
     * 
     * @return int
     **/
    public function countMainImgFromArticle($id){
        // $sql = "SELECT COUNT(art_img_principale) AS count FROM articles WHERE art_id = " . $id;
        // return $this->bd->count($sql); 
        return $this->bd
        ->count("art_img_principale")
        ->table("articles")
        ->where("art_id = ?" )
        ->fetchcount($id);
    }
       /**
     * mémorise total d'enregistrements pour les requets avec pagination
     *
     * @return int
     */
    public function getTotal(){
        return $this->total;
    }


      /**
     *  Cette méthode permet de trouver un article grâce à son id
     *
     * @param  int $id
     * 
     * @return object
     **/
    public function getArticle($id){
        $sql = "SELECT art_id, art_datecrea, art_img_principale, art_photo_desc, art_idsite FROM articles WHERE art_id = " . $id; 
        return $this->bd->query($sql)->getone(); 
    }



  /**
     *  Cette méthode permet d'insérer un nuvel article dans la table migr_articles
     *
     * @param  object $v
     * 
     * @return object
     **/
    public function insertArticle($v, $count){
        
         return $this->bd
         ->insert('art_datecrea','art_nb_images','art_idsite')
         ->table('migr_articles')
         ->go($v->art_datecrea,$count,$v->art_idsite);
     }


  /**
     *  Cette méthode permet d'insérer un nuvel article dans la table migr_articles
     *
     * @param  array $imageInfos, 
    
     * 
     * @return object
     **/
    public function insertPublicImages($imageInfos){
       
        var_dump($imageInfos);
        // die();

        $text = isset($imageInfos['imageText']) ? $imageInfos['imageText'] : null;
        $check = isset($imageInfos['check']) && $imageInfos['check'] ? 1 : 0;


        $iptc = isset($imageInfos['iptc']) ? $imageInfos['iptc'] : null;

        return $this->bd
        ->insert('art_id','img_src','img_verif','img_weight', 'img_width', 'img_height', 'img_iptc', 'img_text')
        ->table('migr_images')
        ->go($imageInfos['art_id'],$imageInfos['src'],$check,$imageInfos['poids'], $imageInfos['width'], $imageInfos['height'], $iptc, $text );
        

    }


}
?>