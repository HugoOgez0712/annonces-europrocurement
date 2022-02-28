<?php 

// Cette classe fera appel aux  informations nécessaires aux annonces en BDD. On retrouve des méthodes qui font appel aux tables 'annonces', 'categories', 'item_types'
// items et images_annonces. La plupart de ces méthodes reprennent les opérations du CRUD. On retrouve généralement deux types de méthode pour ce qui concerne la 
// lecture des informations: Une méthode pour lister tous les éléments et un autre pour en afficher un unique
namespace App\classes;

use App\helpers\Util;

class ClassAds {
    private $bd;
	private $container;
    private $total;
    private $site_id;


    public function __construct($container){
        $this->container = $container;
        $this->bd = $this->container->bdd;
        $this->site_id = $container['globals']['idsite'];
    }


    public function getTotal(){
        return $this->total;
    }



    
    /**
     *  fonction test pour récupérer toutes les annonces. Elle est utilisée par le front office et prend en paramètre la page et le nombre maximum affiché par page
    afin d'afficher sur la view 10 annonces par page maximum
     *
     * @param  int $page
     * @param  int $nbparpages
     * @param  string $where
     * 
     * @return object
     **/

    
    public function getAds(int $page, int $nbparpages,$where = ' 1 ' ){
        $where = !is_null($where) ? $where : ' 1 ';
        if($page>1) $page = ($page-1)*$nbparpages;

                 $sql = "SELECT COUNT(ann_id)
                 FROM annonces
                 WHERE  ann_date_publication <= NOW() AND ".$where;
                 $this->total = $this->bd->query($sql)->getcount();

            //$this->total = 30;

            return $this->bd
            ->select('ann_id,ann_titre,ann_date_publication,ann_geoloc,ann_active,cat_id,cat_nom,cat_slug, ann_date_creation')
            ->table('annonces')
            ->joinleft(
                'categories ON (ann_cat_id = cat_id)'
             )
            ->order('ann_date_publication DESC')
            ->where('ann_site_id = ?',$where,'ann_date_publication <= NOW()')
            ->limit("$page,$nbparpages")
            ->fetchall($this->site_id); 


    }

    //

      /**
     *   cette méthode, similaire à la précédente, sert à afficher toutes les annonces dans le back office. Cette fois ci, on peut voir toutes les annonces simultanément
     *
     * @param  string $query
     * 
     * @return object
     **/
    public function getAdsAdmin($query = null){
        $sqlcount = "SELECT COUNT(ann_id) FROM annonces";
        $this->total = $this->bd->query($sqlcount)->getcount();
        $sql = "SELECT * FROM annonces LEFT JOIN categories ON (ann_cat_id = cat_id) " . $query;
        return $this->bd->query($sql)->get();
    }
    
    // 
    /**
     *   Cette méthode compte le nombre d'annonces afin d'afficher le total dans le backoffice
     *
     * @param  string $filtre
     * 
     * @return object
     **/
    public function getcountAds($filtre = null){
        $sql = "SELECT COUNT(ann_id) FROM annonces";
		return $this->bd->query($sql)->getcount();
    }
    
      /**
     *  Cette méthode permet d'afficher une annonce unique grâce à son id, elle est utilisée lorsqu'on fait appel à une seule annonce
     *
     * @param  int $id
     * 
     * @return object
     **/
    // 
    public function getAd(int $id){
        return $this->bd
        ->select()
        ->table('annonces')
        ->join('categories ON (ann_cat_id = cat_id)')
        ->where('ann_id = ?')
        ->fetch($id);
    }
   

      /**
     *  Cette méthode permet d'insérer une nouvelle entrée 'annonce'
     *
     * @param  array $v
     * 
     * @return object
     **/
    public function insertAd($v){
        // J'ai repris la structure de la méthode insertAuteur de la class Auteur en la réadaptant aux besoins d'un ajout d'annonces. 
         return $this->bd
         ->insert('ann_titre','ann_date_publication','ann_desc','ann_geoloc','ann_active', 'ann_cat_id', 'ann_site_id', 'ann_aut_id', 'ann_date_creation')
         ->table('annonces')
         ->go($v['ann_titre'],$v['ann_date_publication'],$v['ann_desc'],$v['ann_geoloc'],$v['ann_active'],$v['ann_cat_id'],$v['ann_site_id'],$v['ann_aut_id'],date('Y-m-d H:i:s'));
     }

      /**
     *  Cette méthode permet d'insérer une nouvelle entrée 'annonce' à partir du front office. On ne peut pas choisir d'auteur dans celle ci
     *
     * @param  array $v
     * 
     * @return object
     **/
     public function insertAdPublic($v){
        // J'ai repris la structure de la méthode insertAuteur de la class Auteur en la réadaptant aux besoins d'un ajout d'annonces. 
         return $this->bd
         ->insert('ann_titre','ann_date_publication','ann_desc','ann_geoloc', 'ann_active', 'ann_cat_id', 'ann_site_id', 'ann_date_creation')
         ->table('annonces')
         ->go($v['ann_titre'],$v['ann_date_publication'],$v['ann_desc'],$v['ann_geoloc'],0,$v['ann_cat_id'],$v['ann_site_id'],date('Y-m-d H:i:s'));
     }

      /**
     *  Cette méthode permet d'insérer une nouvelle entrée 'annonce' à partir du front office. On ne peut pas choisir d'auteur dans celle ci
     *
     * @param  array $v
     * 
     * @return object
     **/
    public function insertClient($v){
        return $this->bd

        ->insert('c_civ','c_prenom','c_nom', 'c_email')
        ->table('gesab_clients')
        ->go($v['c_civ'], $v['c_prenom'],$v['c_nom'],$v['c_email']);
    }
  // 
  /**
     *  Cette méthode permet de modifier une annonce lors de la soumission du formulaire à la consultation d'une annonce unique grâce aux données passées à la validation

     *
     * @param  array $v
     * 
     * @return object
     **/
 public function modifAd($v){
     return $this->bd
     ->update('ann_titre','ann_desc','ann_date_creation')
     ->table('annonces')
     ->where('ann_id = ?')
     ->go($v['ann_titre'], $v['ann_desc'],$v['ann_date_creation'],$v['ann_id']);
 }
 // 

 /**
     *  Cette méthode permet de supprimer une entrée d'annonce en fonction de l'id donné à la validation du formulaire

     *
     * @param  array $v
     * 
     * @return object
     **/
 public function deleteAd($v){
     return $this->bd
     ->delete('annonces')
     ->where('ann_id = ?')
     ->go($v['ann_id']);
 }
   // 

   /**
     *  Cette méthode sert à afficher toutes les annonces dans le front office en fonction de la ville selectionnée

     *
     * @param  string $city
     * 
     * @return object
     **/
   public function getAdsByCity($city){
    $sql = "SELECT * FROM annonces JOIN categories ON ann_cat_id = cat_id JOIN auteurs ON ann_aut_id = aut_id WHERE ann_geoloc =" . "'" . $city . "'";
    return $this->bd->query($sql)->get(); 
}

// 

 /**
     *  Cette méthode sert à afficher toutes les annonces dans le front office en fonction de l'auteur sélectionné

     *
     * @param  int $autid
     * 
     * @return object
     **/
public function getAdsByAut(int $autid){
    $sql = "SELECT * FROM annonces JOIN categories ON ann_cat_id = cat_id WHERE ann_aut_id =" . $autid ;
    return $this->bd->query($sql)->get();
}
// 

/**
     * Cette méthode sert à afficher toutes les annonces dans le front office en fonction de la catégorie selectionnée

     *
     * @param  int $catid
     * 
     * @return object
     **/
public function getAdsByCat(int $catid){
    $sql = "SELECT * FROM annonces JOIN categories ON ann_cat_id = cat_id WHERE ann_cat_id =" . $catid ;
    return $this->bd->query($sql)->get();
}






// Liste des méthodes qui concernent la gestion des catégories    
//

/**
     * cette méthode sert à afficher toutes les catégories dans le back office et le front office.

     *
     * @param  string $query
     * 
     * @return object
     **/
 public function getCats($query = null){
    $sqlcount = "SELECT COUNT(cat_id) FROM categories";
    $this->total = $this->bd->query($sqlcount)->getcount();
    // $exception = 'NOT IN (' . implode(',',$exception) . ')' ?? '1';
    $sql = "SELECT * FROM categories " . $query;     
    return $this->bd->query($sql)->get();

    
}
 // 

 /**
     *Cette méthode compte le nombre de catégories afin d'afficher le total dans le backoffice

     *
     * @param  string $query
     * 
     * @return object
     **/
public function getcountCats($filtre = null){
    $sql = "SELECT COUNT(cat_id) FROM categories";
    return $this->bd->query($sql)->getcount();
}

    // Cette méthode permet d'afficher une catégorie unique grâce à son id

    /**
     *Cette méthode compte le nombre de catégories afin d'afficher le total dans le backoffice

     *
     * @param  int $id
     * 
     * @return object
     **/
public function getCat(int $id){
    return $this->bd
    ->select('cat_id,cat_nom,cat_slug, site_id')
    ->table('categories')
    ->where('cat_id = ?')
    ->fetch($id);
}
 //

 /**
     * Cette méthode permet d'afficher une catégorie grâce à son slug

     *
     * @param  string $s
     * 
     * @return object
     **/
public function getCatBySlug(string $s){
    return $this->bd
    ->select('cat_id,cat_nom,site_id')
    ->table('categories')
    ->where('cat_slug = ?')
    ->fetch($s);
}
 // 

 /**
     * Cette méthode permet d'insérer une nouvelle entrée 'catégorie' grâce aux informations envoyées via le formulaire d'ajout de catégorie

     *
     * @param  array $v
     * 
     * @return object
     **/
public function insertCat($v){
    // J'ai repris la structure de la méthode insertAuteur de la class Auteur en la réadaptant aux besoins d'un ajout d'annonces. 
     return $this->bd
     ->insert('cat_nom', 'cat_slug', 'site_id')
     ->table('categories')
     ->go($v['cat_nom'],$v['cat_slug'], $v['site_id']);
 }
  // 

  /**
     * Cette méthode permet de modifier une catégorie lors de la soumission du formulaire à la consultation d'une catégorie unique grâce aux données passées à la validation
     *
     * @param  array $v
     * 
     * @return object
     **/
 public function modifCat($v){
    return $this->bd
    ->update('cat_nom', 'cat_slug')
    ->table('categories')
    ->where('cat_id = ?')
    ->go($v['cat_nom'],$v['cat_slug'], $v['cat_id']);
}

 //
 /**
     *  Cette méthode permet de supprimer une entrée de catégories en fonction de l'id donné à la validation du formulaire
     *
     * @param  array $v
     * 
     * @return object
     **/
public function deleteCat($v){
    return $this->bd
    ->delete('categories')
    ->where('cat_id = ?')
    ->go($v['cat_id']);
}

// 
 /**
     * Cette méthode permet de sélectionner, lors de la suppression éventuelle d'une catégorie, toutes les autres catégories lorsqu'on est sur la page individuelle d'une catégorie
     * C'est parmis ces catégories que la fonction updateAnnCat trouvera le $newCatId
     *
     * @param  int $id
     * 
     * @return object
     **/
public function getCatsException($id){
    // $exception = 'NOT IN (' . implode(',',$exception) . ')' ?? '1';
    return $this->bd
    ->select()
    ->table('categories')
    ->where('cat_id NOT IN (' . $id . ')')
    ->fetchall($this->site_id);  
}

//
 /**
     *  Cette méthode sert à ce que, lors de la suppression d'une catégorie, les annonces concernées par la suppression de l'article aient malgré cela une catégorie choisie au préalable avant la suppression
     *
     * @param  int $id
     * @param  int $newCatId
     * 
     * @return object
     **/
public function updateAnnCat($id, $newCatId){
    return $this->bd
    ->update('ann_cat_id')
    ->table('annonces')
    ->where('ann_cat_id = ?')
    ->go($newCatId, $id);



}






    // Méthodes qui concernent les images_annonces
    
    //
     /**
     *   Cette méthode sert à afficher toutes les images_annonces dans le back office en fonction de l'id de l'annonce des images 
     *
     * @param  int $annid
   
     * 
     * @return object
     **/
    public function getImagesAdmin(int $annid){
        return $this->bd
        ->select()
        ->table('images_annonces')
        ->where('ann_id = ' . $annid)
        ->order('img_order ASC')
        ->fetchall($this->site_id);

    }
  // Cette méthode permet d'insérer une nouvelle entrée 'images_annonces' 
      /**
     *   Cette méthode permet d'insérer une nouvelle entrée 'images_annonces' 
     *
     * @param  array $v
   
     * 
     * @return object
     **/
    public function insertImage($v){
        return $this->bd
        ->insert( 'img_nom', 'img_order', 'site_id', 'ann_id' )
        ->table('images_annonces')
        ->go($v['img_nom'], $v['img_order'], $this->site_id,  $v['ann_id']);
    }
     // 
        /**
     *  Cette méthode permet de supprimer une entrée d'images_annonces en fonction de l'id de l'annonce donné à la validation du formulaire
     * Elle est exécutée lorsqu'une annonce est supprimée
     *
     * @param  array $v
   
     * 
     * @return object
     **/
    public function deleteImage($v){
        return $this->bd
        ->delete('images_annonces')
        ->where('ann_id = ?')
        ->go($v['ann_id']);
    }
   // 


        /**
     *  Cette méthode permet de supprimer une entrée d'images_annonces en fonction de l'id de l'annonce donné à la validation du formulaire
     * Elle est exécutée lorsqu'une annonce est supprimée
     *
     * @param  array $v
   
     * 
     * @return object
     **/
    public function deleteImageById($v){
        return $this->bd
        ->delete('images_annonces')
        ->where('img_id = ?')
        ->go($v['img_id']);
    }
    // 


    
        /**
     * Cette méthode permet de modifier le nom d'une image si l'utilisateur transmet un nouveau nom
     *
     * @param  array $v
   
     * 
     * @return object
     **/
    public function modifImageName($v){
        return $this->bd
        ->update('img_nom')
        ->table('images_annonce')
        ->where('img_id =' . $v['img_id'])
        ->go($v['img_nom'], $v['img_id']);
    }
   // 
     /**
     * Cette méthode permet de modifier l'ordre des images lorsque l'utilisateur utilise le drag and drop des images
     *
     * @param  array $v
   
     * 
     * @return object
     **/
    public function ordreImages($v){
        $i = 1;
        $tab = $v['tabs'];
        foreach($tab as $id):
            $up =  $this->bd
            ->update('img_order')
            ->table('images_annonces')
            ->where('img_id = ?')
            ->go($i,$id);
            $i++;
        endforeach;
    }

    //
       /**
     *  Cette méthode permet d'obtenir un auteur grâce à son id sur la page detail d'une annonce dans le BO et FO 
     *
     * @param  int $autid
   
     * 
     * @return object
     **/
    public function getAut(int $autid){
        return $this->bd
        ->select()
        ->table('auteurs')
        ->where('aut_id = ' . $autid)
        ->fetchall($this->site_id);  
    }


  

  



     // Gestion des item_types : opération du CRUD
       
         /**
     * // Cette méthode sert à afficher tous les types d'items dans le back office.
     *
     * 
     * @return object
     **/
     public function getItemTypes(){
        return $this->bd
        ->select()
        ->table('item_type')
        ->fetchall($this->site_id);
    }
  
     //
      /**
     *  Cette méthode permet d'afficher un item-type unique grâce à son id
     * @param  int $id
     *
     * 
     * @return object
     **/
    public function getItemType(int $id){
        return $this->bd
        ->select('item_type_id, item_type_nom, item_type_input, item_type_desc')
        ->table('item_type')
        ->where('item_type_id = ?')
        ->fetch($id);
    }
    //
     /**
     *   Cette méthode permet d'insérer une nouvelle entrée 'item type' grâce aux informations envoyées via le formulaire d'ajout d'item type
     * @param  array $v
     *
     * 
     * @return object
     **/
    public function insertItemType($v){
        // J'ai repris la structure de la méthode insertAuteur de la class Auteur en la réadaptant aux besoins d'un ajout d'annonces. 
         return $this->bd
         ->insert( 'item_type_nom', 'item_type_input', 'item_type_desc')
         ->table('item_type')
         ->go($v['item_type_nom'],$v['item_type_input'], $v['item_type_desc']);
     }
 // 
  /**
     *  Cette méthode permet de modifier un itemp-type lors de la soumission du formulaire à la consultation d'un item type unique grâce aux données passées à la validation
     * @param  array $v
     *
     * 
     * @return object
     **/
     public function modifItemType($v){
        return $this->bd
        ->update('item_type_nom', 'item_type_input', 'item_type_desc')
        ->table('item_type')
        ->where('item_type_id = ?')
        ->go($v['item_type_nom'], $v['item_type_input'],$v['item_type_desc'], $v['item_type_id']);
    }
  // 
    /**
     *  Cette méthode permet de supprimer une entrée d'item-type en fonction de l'id donné à la validation du formulaire
     * @param  array $v
     *
     * 
     * @return object
     **/
    public function deleteItemType($v){
        return $this->bd
        ->delete('item_type')
        ->where('item_type_id = ?')
        ->go($v['item_type_id']);
    }




    // Liste des méthodes qui concernent la gestion des items
    // 
       /**
     *  Cette méthode sert à afficher les items ayant l'ann_id transmis en paramètre dans le back office et le front office des annonces
     * @param  int $id
     *
     * 
     * @return object
     **/
    public function getItems(int $id){
        return $this->bd
        ->select()
        ->table('items')
        ->joinleft(
            'item_type ON (item_type_id_fk = item_type_id)'
        )
        ->where('ann_id = ' . $id)
        ->order('item_order ASC')
        ->fetchall($this->site_id); 
    }

    // 
      /**
     *  Cette méthode permet d'insérer un nouvel item grâce aux informations envoyées lorsqu'une annonce est ajoutée ou modifiée avec des items en plus
     * @param  array $v
     *
     * 
     * @return object
     **/
    public function insertItem($v){
        return $this->bd
        ->insert( 'item_value', 'item_order', 'ann_id', 'item_type_id_fk')
        ->table('items')
        ->go($v['item_value'],$v['item_order'], $v['ann_id'], $v['item_type_id_fk']);
    }

    // 
     /**
     *  Cette méthode permet de modifier des items lorsque l'utilisateur change leur valeurs ou leur ordre à la modification d'une annonce
     * @param  array $v
     *
     * 
     * @return object
     **/
    public function modifItem($v){
        return $this->bd
        ->update('item_value', 'item_order')
        ->table('items')
        ->go($v['item_value'],$v['item_order']);
    }

    // 
     /**
     * Cette méthode permet de supprimer un item grâce à son id
     * @param  array $v
     *
     * 
     * @return object
     **/
    public function deleteItem($v){
        return $this->bd
        ->delete('items')
        ->where('ann_id = ?')
        ->go($v['ann_id']);
    }
    // 
       /**
     *Cette méthode permet de joindre les items types à la table annonces_form grâce à l'id de la catégorie pour déterminer les items par défaut d'une catégorie
     * @param  int $catid
     *
     * 
     * @return object
     **/
    public function getCatsAndItems($catid){
        $sql = "SELECT * FROM annonces_form JOIN item_type ON form_item_id = item_type_id WHERE form_cat_id =" . $catid . " ORDER BY form_item_order ASC" ;
        return $this->bd->query($sql)->get();
    }
     //
        /**
     * Cette méthode permet d'ajotuer des items par défaut d'une catégorie grâce aux informations envoyées lors de la création d'une catégorie
     * @param  array $v
     *
     * 
     * @return object
     **/
    public function insertDefaultCatItems($v){
        return $this->bd
        ->insert( 'form_cat_id', 'form_item_id', 'form_item_order')
        ->table('annonces_form')
        ->go($v['form_cat_id'],$v['form_item_id'], $v['form_item_order']);
    }

    // 
     /**
     * Cette méthode permet de supprimer des items par défaut grâce à l'id de la catégorie 
     * @param  array $v
     *
     * 
     * @return object
     **/
    public function deleteDefaultCatItems($v){
        return $this->bd
        ->delete('annonces_form')
        ->where('form_cat_id = ?')
        ->go($v['form_cat_id']);
    }

  

  








    // méthode update ann_cat_id (param $ancein, $nouveau)





    // Retournes string $in
   
     /**
     * Cette méthode permet de récupérer les annonces en fonction de la catégorie  
     * @param  int $id
     *
     * 
     * @return object
     **/
    public function getAdsByCategory(int $id){
        return $this->bd
        ->select()
        ->table('annonces')
        ->join(
            'categories ON (ann_cat_id = cat_id)'
         )
        ->where('ann_cat_id = ' . $id)
        ->fetchall($id);
    }

    /**
     * Cette méthode permet de récupérer l'id d'une catégorie grâce à la phrase donné en paramètre
     * @param  string $slug
     *
     * 
     * @return object
     **/
    public function getIdWithSlug(string $slug){
        return $this->bd
        ->select('cat_id')
        ->table('categories')
        ->where('cat_slug = '. "'$slug'")
        ->fetch($slug);      
    }

     /**
     * Cette méthode permet de récupérer tous les lieux des annonces
     *
     * 
     * @return object
     **/
    public function getAdsPlaces(){
        return $this->bd
        ->select('ann_geoloc')
        ->table('annonces')
        ->group('ann_geoloc')
        ->fetchall($this->site_id); 
    }

 



}