<?php

/**
 * Class Compose
 */

require_once('Base.php');
require_once('BaseException.php');
require_once('Produit.php');
require_once('Panier.php');

class Compose implements JsonSerializable
{

    // Fields


    /**
     * @var int
     */

    private $panier_id;

    /**
     * @var Produit
     */

    private $produit;

    /**
     * @var int
     */

    private $produit_id;

    /**
     * @var int
     */

    private $quantite;


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
     * Modifies the panier_id attribute.
     * @param $_panier_id The new value of the panier_id of this Compose.
     */

    public function setPanier_id($_panier_id) { $this->panier_id = $_panier_id; }

    /**
     * Modifies the produit_id attribute.
     * @param $_produit_id The new value of the produit_id of this Compose.
     */

    public function setProduit_id($_produit_id) { $this->produit_id = $_produit_id; }

    /**
     * Modifies the quantite attribute.
     * @param $_quantite The new value of the quantite of this Compose.
     */

    public function setQuantite($_quantite) { $this->quantite = $_quantite; }


    // Constructor


    /**
     * Crée une nouvelle instance de la classe Compose.
     */

    public function __construct()
    {

    }


    // Methods


    /**
     * Insere le Compose dans la base de données.
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
                throw new Exception("Le Compose n'a pas pu être inseré
                 dans la base de données car le champ produit_id n'a pas été specifié
                  et il s'agit d'un champ obligatoire.");
            }
            else if (!isset($this->panier_id))
            {
                throw new Exception("Le Compose n'a pas pu être inseré
                 dans la base de données car le champ panier_id n'a pas été specifié
                  et il s'agit d'un champ obligatoire.");
            }
            else if (!isset($this->quantite))
            {
                throw new Exception("Le Compose n'a pas pu être inseré
                 dans la base de données car le champ quantite n'a pas été specifié
                  et il s'agit d'un champ obligatoire.");
            }

            // On prépare la requête

            $requete = $bdd -> prepare("INSERT INTO compose(Produit_Id, Panier_Id, Quantite)
              VALUES (:pr_id, :pa_id, :qt);");

            $requete -> execute(array
            (
                'pr_id' => $this->produit_id,
                'pa_id' => $this->panier_id,
                'qt' => $this->quantite
            ));
        }
        catch(BaseException $e)
        {
            print $e -> getMessage();
        }
    }

    /**
     * Supprime tout le contenu d'un panier.
     * @param $id_panier L'identifiant du panier dont
     * le contenu est a supprimer.
     */

    public static function supprimerContenuPanier($id_panier)
    {
        try
        {
            // Connection a la base.

            $bdd = Base::getConnection();

            // On prépare la requête

            $requete = $bdd -> prepare("DELETE FROM Compose WHERE Panier_Id = :id;");

            $requete -> execute(array
            (
                'id' => $id_panier
            ));
        }
        catch(BaseException $e)
        {
            print $e -> getMessage();
        }
    }
    
     public static function supprimerContenuPanierId($id_panier,$b)
    {
        try
        {
            // Connection a la base.

            $bdd = Base::getConnection();

            // On prépare la requête

            $requete = $bdd -> prepare("DELETE FROM Compose WHERE Panier_Id = :id AND Produit_Id= :p_id;");

            $requete -> execute(array
            (
                'id' => $id_panier,
                    'p_id'=>$b
            ));
        }
        catch(BaseException $e)
        {
            print $e -> getMessage();
        }
    }


    /**
     * Permet de retrouver le contenu d'un Panier dans la base de données
     * a l'aide de l'identifiant du Panier.
     * @param $id Le Compose avec l'identifiant du Panier recherché
     */

    public static function findByPanierID($id)
    {
        try
        {
            // Connection a la base.

            $bdd = Base::getConnection();

            // On prépare la récupération du Compose avec le Panier_Id spécifié.

            $requete = $bdd -> prepare("SELECT Compose.Produit_Id AS pr_id, Panier_Id, Quantite, Produit_Nom,
            Produit_Img_URL, Produit_Prix, Produit.Categorie_Id AS c_id, Categorie_Nom FROM Compose
            INNER JOIN Produit ON Produit.Produit_Id = Compose.Produit_Id INNER JOIN Categorie ON
            Categorie.Categorie_ID = Produit.Categorie_Id WHERE Panier_Id = ?;");
            $requete->execute(array($id));

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

                $p->setId(intval($reponse['pr_id']));
                $p->setNom($reponse['Produit_Nom']);
                $p->setImg_URL($reponse['Produit_Img_URL']);
                $p->setPrix(floatval($reponse['Produit_Prix']));
                $p->setCategorie_id(intval($reponse['c_id']));
                $p->setCategorie($c);

                $cp = new Compose();

                $cp->panier_id = intval($reponse['Panier_Id']);
                $cp->produit_id = intval($reponse['pr_id']);
                $cp->quantite = intval($reponse['Quantite']);
                $cp->produit = $p;

                $tab[$i] = $cp;
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