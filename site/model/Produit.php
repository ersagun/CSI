<?php

/**
 * Class Produit
 */

require_once('Base.php');
require_once('BaseException.php');
require_once('Categorie.php');

class Produit implements JsonSerializable
{

    // Fields


    /**
     * @var int
     */

    private $categorie_id;

    /**
     * @var Categorie
     */

    private $categorie;

    /**
     * @var int
     */

    private $id;

    /**
     * @var String
     */

    private $img_url;

    /**
     * @var String
     */

    private $nom;

    /**
     * @var Double
     */

    private $prix;


    // Properties


    /**
     * Donne acces aux attributs.
     * @param $attr_name L'attribut recherché.
     * @throws Exception si l'attribut n'existe pas
     * dans cette classe.
     */

    public function __get($attr_name)
    {
        if (property_exists( __CLASS__, $attr_name))
        {
            return $this->$attr_name;
        }

        $emess = __CLASS__ . ": unknown member $attr_name (getAttr)";
        throw new Exception($emess, 45);
    }

    /**
     * Modifies the categorie attribute.
     * @param $_cat The new value of the categorie of this Produit.
     */

    public function setCategorie($_cat) { $this->categorie = $_cat; }

    /**
     * Modifies the categorie_id attribute.
     * @param $_categorie_id The new value of the categorie_id of this Produit.
     */

    public function setCategorie_id($_categorie_id) { $this->categorie_id = $_categorie_id; }

    /**
     * Modifies the id attribute.
     * @param $_id The new value of the id of this Produit.
     */

    public function setId($_id) { $this->id = $_id; }

    /**
     * Modifies the img_url attribute.
     * @param $_img_url The new value of the img_url of this Produit.
     */

    public function setImg_URL($_img_url) { $this->img_url = $_img_url; }

    /**
     * Modifies the nom attribute.
     * @param $_nom The new value of the nom of this Produit.
     */

    public function setNom($_nom) { $this->nom = $_nom; }

    /**
     * Modifies the prix attribute.
     * @param $_prix The new value of the prix of this Produit.
     */

    public function setPrix($_prix) { $this->prix = $_prix; }


    // Constructor


    /**
     * Crée une nouvelle instance de la classe Produit.
     */

    public function __construct()
    {

    }

    // Methods

    public function __toString() {
        return "[". __CLASS__ . "] cat_id : ". $this->categorie_id . ":
                   name  ". $this->nom  .":
                   url ". $this->img_url;
    }

    /**
     * Vérifie si le nom de produit donné en parametre est bien unique.
     * @param $nom
     * Vrai si le nom est unique, faux s'il existe deja dans la base.
     */

    public static function checkNomUnique($nom)
    {
        try
        {
            // Connection a la base.

            $bdd = Base::getConnection();

            // On prépare la requete pour compter le nombre de nom équivalent
            // au parametre

            $reponse = $bdd -> prepare("SELECT Count(*) AS copies FROM produit WHERE
                LOWER(Produit_Nom) = :name;");

            $reponse -> execute(array(
                'name' => strtolower($nom)
            ));

            // On récupere le résulat

            $result = $reponse -> fetch();
            $reponse -> closeCursor();

            // Si le compte est 0, le nom est unique, on retourne vrai.

            return ($result['copies'] == 0);
        }
        catch(BaseException $e)
        {
            print $e -> getMessage();
        }
    }


    /**
     * Insere le Produit dans la base de données.
     * @throws Exception Si tous les champs obligatoire de cette
     * classe n'ont pas étés remplis.
     * @return l'ID recupéré par le Produit inséré.
     */

    public function insert()
    {
        try
        {
            // Connection a la base.

            $bdd = Base::getConnection();

            if (!isset($this->nom))
            {
                throw new Exception("Le Produit n'a pas pu être inseré
                 dans la base de données car le champ nom n'a pas été specifié
                  et il s'agit d'un champ obligatoire.");
            }
            else if (!Produit::checkNomUnique($this->nom)) {
                throw new Exception("Le nom de ce Produit existe déja dans la base de données.
                Veuillez le changer.");
            }
            else if (!isset($this->img_url))
            {
                throw new Exception("Le Produit n'a pas pu être inseré
                 dans la base de données car le champ img_url n'a pas été specifié
                  et il s'agit d'un champ obligatoire.");
            }
            else if (!isset($this->prix))
            {
                throw new Exception("Le Produit n'a pas pu être inseré
                 dans la base de données car le champ prix n'a pas été specifié
                  et il s'agit d'un champ obligatoire.");
            }
            else if (!isset($this->categorie_id))
            {
                throw new Exception("Le Produit n'a pas pu être inseré
                 dans la base de données car le catégorie_id n'a pas été specifié
                  et il s'agit d'un champ obligatoire.");
            }

            // On prépare la requête

            $requete = $bdd -> prepare("INSERT INTO produit(Produit_Nom, Produit_Img_Url, Produit_Prix,
            Categorie_ID) VALUES (:nom, :url, :prix, :c_id);");
            $requete -> execute(array
            (
                'nom' => $this->nom,
                'url' => $this->img_url,
                'prix' => $this->prix,
                'c_id' => $this->categorie_id
            ));

            // On récupere l'identifiant de la Produit insérée.

            $this->id = $bdd->LastInsertID('produit');
            $requete->closeCursor();
            return $this->id;
        }
        catch(BaseException $e)
        {
            print $e -> getMessage();
        }
    }

    /**
     * Permet de retrouver un Produit dans la base de données
     * a l'aide de son identifiant.
     * @param $id Le Produit avec l'identifiant recherché, null sinon.
     */

    public static function findByID($id)
{
    try
    {
        // Connection a la base.

        $bdd = Base::getConnection();

        // On prépare la récupération du Produit avec l'ID spécifié.

        $requete = $bdd -> prepare("SELECT Produit_Id, Produit_Nom, Produit_Img_URL, Produit_Prix,
            Produit.Categorie_Id AS c_id, Categorie_Nom FROM Produit INNER JOIN Categorie ON Categorie.Categorie_Id =
            Produit.Categorie_Id WHERE Produit_Id = ?;");
        $requete->execute(array($id));

        /**
         * Décommenter ici et commenter la suite si vous voulez retourner
         * l'objet en format JSON.
         * return json_encode($requete->fetchAll(PDO::FETCH_ASSOC));
         */

        // On transforme le résultat en un objet

        $reponse = $requete->fetch(PDO::FETCH_ASSOC);

        // On transforme l'objet en un Produit

        if($reponse)
        {
            $c = new Categorie();

            $c->setCategorie_id(intval($reponse['c_id']));
            $c->setCategorie_nom($reponse['Categorie_Nom']);

            $p = new Produit();

            $p->id = intval($reponse['Produit_Id']);
            $p->nom = $reponse['Produit_Nom'];
            $p->img_url = $reponse['Produit_Img_URL'];
            $p->prix = floatval($reponse['Produit_Prix']);
            $p->categorie_id = intval($reponse['c_id']);
            $p->categorie = $c;

            $requete->closeCursor();
            return $p;
        }
        else return null;
    }
    catch(BaseException $e) { print $e -> getMessage(); }
}


    /**
     * @return string
     */
    public static function allProducts()
    {
        try
        {
            // Connection a la base.

            $bdd = Base::getConnection();

            $requete = $bdd -> prepare("SELECT Produit_Id, Produit_Nom, Produit_Img_URL, Produit_Prix,
            Produit.Categorie_Id AS c_id, Categorie_Nom FROM Produit INNER JOIN Categorie ON Categorie.Categorie_Id =
            Produit.Categorie_Id;");
            $requete->execute();

            /**
             * Décommenter ici et commenter la suite si vous voulez retourner
             * l'objet en format JSON.
             * return json_encode($requete->fetchAll(PDO::FETCH_ASSOC));
             */

            // On transforme le résultat en un tableau d'objets



            // Que l'on va retransformer en tableau de membres
            $tab = array();
            $reponses= $requete->fetchAll(PDO::FETCH_ASSOC);
            foreach($reponses as $reponse)
            {

                $c_id=intval($reponse['c_id']);
                $categorie_nom=$reponse['Categorie_Nom'];
                $c = new Categorie();
                $c->setCategorie_id($c_id);
                $c->setCategorie_nom($categorie_nom);


                $p_id= $reponse['Produit_Id'];
                $p_nom = $reponse['Produit_Nom'];
                $p_img_url = $reponse['Produit_Img_URL'];
                $p_prix = floatval($reponse['Produit_Prix']);
                $p_categorie_id = intval($reponse['c_id']);

                $c = new Categorie();
                $c->setCategorie_id($c_id);
                $c->setCategorie_nom($categorie_nom);

                $p = new Produit();
                $p->id = $p_id;
                $p->nom = $p_nom;
                $p->img_url = $p_img_url;
                $p->prix = $p_prix;
                $p->categorie_id = $p_categorie_id;;
                $p->categorie = $c;

                array_push($tab ,$p);
               //echo($tab[$i]);
                //$i++;
            }

            //$requete->closeCursor();
            return $tab;
            
        }
        catch(BaseException $e) { print $e -> getMessage(); }
    }




    /**
     * Permet de retrouver des Produits dans la base de données
     * a l'aide de criteres de recherche.
     * @param $rech Un tableau avec :
     * - $rech['nom'] : un filtre sur le nom
     * - $rech['nomExact'] : un filtre sur le nom exact.
     * - $rech['idCategorie'] : un filtre sur la catégorie
     * - $rech[prixMin'] : un filtre qui enleve tous les produits avec un prix inférieur
     * - $rech['prixMax'] : un filtre qui enleve tous les produits avec un prix supérieur
     */

     public static function findProduitCategorieLike($val) {
        
      $c = Base::getConnection();
      $query = "select * from Produit as a left join Categorie as t on a.Produit_Id=t.Categorie_Id  where t.Categorie_Nom LIKE '".$val."%' OR a.Produit_Nom LIKE '".$val."%' UNION select * from Produit as a right join Categorie as t on a.Produit_Id=t.Categorie_Id  where t.Categorie_Nom LIKE '".$val."%' OR a.Produit_Nom LIKE '".$val."%'";
      $stmt = $c->prepare($query) ;
      $stmt->execute();
      $tab = array();
      while ($reponse = $stmt->fetch(PDO::FETCH_BOTH)) 
      {
       $c_id=intval($reponse['Categorie_Id']);
                $categorie_nom=$reponse['Categorie_Nom'];
                $c = new Categorie();
                $c->setCategorie_id($c_id);
                $c->setCategorie_nom($categorie_nom);


                $p_id= $reponse['Produit_Id'];
                $p_nom = $reponse['Produit_Nom'];
                $p_img_url = $reponse['Produit_Img_Url'];
                $p_prix = floatval($reponse['Produit_Prix']);
                $p_categorie_id = intval($reponse['Categorie_Id']);

                $c = new Categorie();
                $c->setCategorie_id($c_id);
                $c->setCategorie_nom($categorie_nom);

                $p = new Produit();
                $p->id = $p_id;
                $p->nom = $p_nom;
                $p->img_url = $p_img_url;
                $p->prix = $p_prix;
                $p->categorie_id = $p_categorie_id;;
                $p->categorie = $c;

                array_push($tab ,$p);
      }
      return $tab;
          
    }
    
    public static function rechercherProduit($rech)
    {
        try
        {
            // Connection a la base.

            $bdd = Base::getConnection();

            // On prépare la récupération du Produit avec les filtres spécifiées

            $query = "SELECT Produit_Id, Produit_Nom, Produit_Img_URL, Produit_Prix,
            Produit.Categorie_Id AS c_id, Categorie_Nom FROM Produit INNER JOIN Categorie ON Categorie.Categorie_Id =
            Produit.Categorie_Id WHERE 1=1 ";

            if (isset($rech['nom'])) {
                $query .= "AND Produit_Nom LIKE :nom ";
                $rech['nom'] = '%' . $rech['nom'] . '%';
            }

            if (isset($rech['nomExact'])) {
                $query .= "AND Produit_Nom = :nomExact ";
            }

            if (isset($rech['idCategorie'])) {
                $query .= "AND Produit.Categorie_Id = :idCategorie ";
            }

            if (isset($rech['prixMin'])) {
                $query .= "AND Produit_Prix <= :prixMin ";
            }

            if (isset($rech['prixMax'])) {
                $query .= " AND Produit_Prix >= :prixMax ";
            }
            $requete = $bdd -> prepare($query . ";");
            $requete->execute($rech);

            /**
             * Décommenter ici et commenter la suite si vous voulez retourner
             * l'objet en format JSON.
             * return json_encode($requete->fetchAll(PDO::FETCH_ASSOC));
             */

            // On transforme le résultat en un tableau d'objets

            $reponses = $requete->fetchALL(PDO::FETCH_ASSOC);

            // Que l'on va retransformer en tableau de membres.

            $tab = array();
            $i = 0;

            foreach($reponses as $reponse)
            {
                $c = new Categorie();

                $c->setCategorie_id(intval($reponse['c_id']));
                $c->setCategorie_nom($reponse['Categorie_Nom']);

                $p = new Produit();

                $p->id = intval($reponse['Produit_Id']);
                $p->nom = $reponse['Produit_Nom'];
                $p->img_url = $reponse['Produit_Img_URL'];
                $p->prix = floatval($reponse['Produit_Prix']);
                $p->categorie_id = intval($reponse['c_id']);
                $p->categorie = $c;

                $tab[$i] = $p;

                $i++;
            }

            $requete->closeCursor();
            return $tab;
        }
        catch(BaseException $e) { print $e -> getMessage(); }
    }

    // function called when encoded with json_encode
    public function jsonSerialize() {
        return get_object_vars($this);
    }
}