<?php

/**
 * Class ObtenirPromotion
 */

require_once('Base.php');
require_once('BaseException.php');
require_once('Promotion.php');
require_once('Produit.php');


class ObtenirPromotion implements JsonSerializable
{

    // Fields


    /**
     * @var Date
     */

    private $debut;

    /**
     * @var Date
     */

    private $fin;

    /**
     * @var int
     */

    private $produit_id;
    
    private $produit;

    /**
     * @var Promotion
     */

    private $promotion;

    /**
     * @var int
     */

    private $promotion_id;


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
     * Modifies the debut attribute.
     * @param $_debut The new value of the debut of this ObtenirPromotion.
     */

    public function setDebut($_debut) { $this->debut = $_debut; }

    /**
     * Modifies the fin attribute.
     * @param $_fin The new value of the fin of this ObtenirPromotion.
     */

    public function setFin($_fin) { $this->fin = $_fin; }

    /**
     * Modifies the produit_id attribute.
     * @param $_produit_id The new value of the produit_id of this ObtenirPromotion.
     */

    public function setProduit_id($_produit_id) { $this->produit_id = $_produit_id; }

    /**
     * Modifies the promotion_id attribute.
     * @param $_promotion_id The new value of the promotion_id of this ObtenirPromotion.
     */

    public function setPromotion_id($_promotion_id) { $this->promotion_id = $_promotion_id; }
public function setPromotion($_promotion) { $this->promotion = $_promotion; }

    
    public function setProduit($prod){
        $this->produit=$prod;
    }

    // Constructor


    /**
     * Crée une nouvelle instance de la classe ObtenirPromotion.
     */

    public function __construct()
    {

    }


    // Methods


    /**
     * Insere l'ObtenirPromotion dans la base de données.
     * @throws Exception Si tous les champs obligatoire de cette
     * classe n'ont pas étés remplis.
     */

    public function insert()
    {
        try
        {
            // Connection a la base.

            $bdd = Base::getConnection();

            if (!isset($this->produit_id))
            {
                throw new Exception("L'ObtenirPromotion n'a pas pu être inseré
                 dans la base de données car le champ produit_id n'a pas été specifié
                  et il s'agit d'un champ obligatoire.");
            }
            else if (!isset($this->promotion_id))
            {
                throw new Exception("L'ObtenirPromotion n'a pas pu être inseré
                 dans la base de données car le champ promotion n'a pas été specifié
                  et il s'agit d'un champ obligatoire.");
            }
            else if (!isset($this->debut))
            {
                throw new Exception("L'ObtenirPromotion n'a pas pu être inseré
                 dans la base de données car le champ debut n'a pas été specifié
                  et il s'agit d'un champ obligatoire.");
            }
            else if (!isset($this->fin))
            {
                throw new Exception("L'ObtenirPromotion n'a pas pu être inseré
                 dans la base de données car le champ fin n'a pas été specifié
                  et il s'agit d'un champ obligatoire.");
            }

            // On prépare la requête

            $requete = $bdd -> prepare("INSERT INTO obtenir_promotion(Promotion_Id, Produit_Id, Date_Debut, Date_Fin)
              VALUES (:prom, :prod, :deb, :fin);");

            $requete -> execute(array
            (
                'prom' => $this->promotion_id,
                'prod' => $this->produit_id,
                'deb' => $this->debut,
                'fin' => $this->fin
            ));
        }
        catch(BaseException $e)
        {
            print $e -> getMessage();
        }
    }

    /**
     * Permet de retrouver un ObtenirPromotion dans la base de données
     * a l'aide de ses identifiants.
     */

    public static function findByID($id_produit, $id_promotion)
    {
        try
        {
            // Connection a la base.

            $bdd = Base::getConnection();

            // On prépare la récupération de l'ObtenirPromotion avec les ID spécifiés.

            $requete = $bdd -> prepare("SELECT obtenir_promotion.Promotion_Id AS prm_id, Produit_Id,
            Date_Debut, Date_Fin,
            Promotion_montant FROM obtenir_promotion INNER JOIN Promotion ON Promotion.Promotion_Id =
            obtenir_promotion.Promotion_Id WHERE Produit_Id = ? AND obtenir_promotion.Promotion_Id = ? ;");
            $requete->execute(array($id_produit, $id_promotion));

            /**
             * Décommenter ici et commenter la suite si vous voulez retourner
             * l'objet en format JSON.
             * return json_encode($requete->fetchAll(PDO::FETCH_ASSOC));
             */

            // On transforme le résultat en un objet

            $reponse = $requete->fetch(PDO::FETCH_ASSOC);

            // On transforme l'objet en un ObtenirPromotion

            if($reponse)
            {
                $p = new Promotion();

                $p->setId(intval($reponse['prm_id']));
                $p->setMontant(floatval($reponse['Promotion_montant']));

                $op = new ObtenirPromotion();

                $op->produit_id = intval($reponse['Produit_Id']);
                $op->promotion_id = intval($reponse['prm_id']);
                $op->debut = new DateTime($reponse['Date_Debut']);
                $op->fin = new DateTime($reponse['Date_Fin']);
                $op->promotion = $p;

                $requete->closeCursor();
                return $op;
            }
            else return null;
        }
        catch(BaseException $e) { print $e -> getMessage(); }
    }

    /**
     * Permet de retrouver des ObtenirPromotion dans la base de données
     * a l'aide de son identifiant id_produit.
     */

    public static function findByIDProduit($id_produit)
    {
        try
        {
            // Connection a la base.

            $bdd = Base::getConnection();

            // On prépare la récupération de l'ObtenirPromotion avec le Produit_Id.

            $requete = $bdd -> prepare("SELECT obtenir_promotion.Promotion_Id AS prm_id, Produit_Id,
            Date_Debut, Date_Fin,
            Promotion_montant FROM obtenir_promotion INNER JOIN Promotion ON Promotion.Promotion_Id =
            obtenir_promotion.Promotion_Id WHERE Produit_Id = ?;");
            $requete->execute(array($id_produit));

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
                $p = new Promotion();

                $p->setId(intval($reponse['prm_id']));
                $p->setMontant(floatval($reponse['Promotion_montant']));

                $op = new ObtenirPromotion();

                $op->produit_id = intval($reponse['Produit_Id']);
                $op->promotion_id = intval($reponse['prm_id']);
                $op->debut = new DateTime($reponse['Date_Debut']);
                $op->fin = new DateTime($reponse['Date_Fin']);
                $op->promotion = $p;

                $tab[$i] = $op;
                $i++;
            }

            $requete->closeCursor();
            return $tab;
        }
        catch(BaseException $e) { print $e -> getMessage(); }
    }
    
    
    
    
    public static function allProduitPromotion(){
        try
        {
            // Connection a la base.

            $bdd = Base::getConnection();

            $requete = $bdd -> prepare("SELECT * ,Produit_Img_Url FROM Produit INNER JOIN Categorie ON Categorie.Categorie_Id =
            Produit.Categorie_Id INNER JOIN obtenir_promotion ON Produit.Produit_Id=Obtenir_promotion.Produit_Id INNER JOIN promotion ON Obtenir_promotion.Promotion_Id=Promotion.Promotion_Id;");
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

                $c = new Categorie();
                $c->setCategorie_id(intval($reponse['Categorie_Id']));
                $c->setCategorie_nom($reponse['Categorie_Nom']);

                $p = new Produit();
                $p->setId(intval($reponse['Produit_Id']));
                $p->setNom($reponse['Produit_Nom']);
                $p->setImg_URL($reponse['Produit_Img_Url']);
                $p->setPrix(floatval($reponse['Produit_Prix']));
                $p->setCategorie_id(intval($reponse['Categorie_Id']));
                $p->setCategorie($c);
                
                $promotion=new Promotion();
                $promotion->setMontant($reponse["Promotion_montant"]);
                $promotion->setId($reponse["Promotion_Id"]);
                
                
                
                $obtProm=new ObtenirPromotion();
                $obtProm->setProduit_id($reponse["Produit_Id"]);
                $obtProm->setPromotion_id($reponse["Promotion_Id"]);
                $obtProm->setDebut($reponse["Date_Debut"]);
                $obtProm->setFin($reponse["Date_Fin"]);
                $obtProm->setProduit($p);
                $obtProm->setPromotion($promotion);
                
                array_push($tab ,$obtProm);
               //echo($tab[$i]);
                //$i++;
            }

            //$requete->closeCursor();
            return $tab;
            
        }
        catch(BaseException $e) { print $e -> getMessage(); }
    }

    /**
     * Permet de retrouver des ObtenirPromotion dans la base de données
     * a l'aide de son identifiant id_promotion.
     */

    public static function findByIDPromotion($id_promotion)
    {
        try
        {
            // Connection a la base.

            $bdd = Base::getConnection();

            // On prépare la récupération de l'ObtenirPromotion avec le Promotion_Id.

            $requete = $bdd -> prepare("SELECT obtenir_promotion.Promotion_Id AS prm_id, Produit_Id,
            Date_Debut, Date_Fin,
            Promotion_montant FROM obtenir_promotion INNER JOIN Promotion ON Promotion.Promotion_Id =
            obtenir_promotion.Promotion_Id WHERE obtenir_promotion.Promotion_Id = ?;");
            $requete->execute(array($id_promotion));

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
                $p = new Promotion();

                $p->setId(intval($reponse['prm_id']));
                $p->setMontant(floatval($reponse['Promotion_montant']));

                $op = new ObtenirPromotion();

                $op->produit_id = intval($reponse['Produit_Id']);
                $op->promotion_id = intval($reponse['prm_id']);
                $op->debut = new DateTime($reponse['Date_Debut']);
                $op->fin = new DateTime($reponse['Date_Fin']);
                $op->promotion = $p;

                $tab[$i] = $op;
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