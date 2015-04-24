<?php

/**
 * Class Categorie
 */

require_once('Base.php');
require_once('BaseException.php');

class Categorie implements JsonSerializable
{

    // Fields


    /**
     * @var int
     */

    private $categorie_id;

    /**
     * @var String
     */

    private $categorie_nom;


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
     * Modifies the categorie_id attribute.
     * @param $_categorie_id The new value of the categorie_id of this Categorie.
     */

    public function setCategorie_id($_categorie_id) { $this->categorie_id = $_categorie_id; }

    /**
     * Modifies the categorie_nom attribute.
     * @param $_categorie_nom The new value of the categorie_nom of this Categorie.
     */

    public function setCategorie_nom($_categorie_nom) { $this->categorie_nom = $_categorie_nom; }


    // Constructor


    /**
     * Crée une nouvelle instance de la classe Catégorie.
     */

    public function __construct()
    {

    }


    // Methods


    /**
     * Insere la Catégorie dans la base de donnees.
     * @throws Exception Si tous les champs obligatoire de cette
     * classe n'ont pas étés remplis.
     * @return l'ID recupéré par la Catégorie insérée.
     */

    public function insert()
    {
        try
        {
            // Connection a la base.

            $bdd = Base::getConnection();

            if (!isset($this->categorie_nom))
            {
                throw new Exception("La catégorie n'a pas pu etre inserée
                 dans la base de donnees car le champ categorie_nom n'a pas ete specifié
                  et il s'agit d'un champ obligatoire.");
            }

            // On prépare la requete

            $requete = $bdd -> prepare("INSERT INTO categorie(Categorie_Nom) VALUES (:nom);");
            $requete -> execute(array
            (
                'nom' => $this->categorie_nom
            ));

            // On récupere l'identifiant de la Catégorie insérée.

            $this->categorie_id = $bdd->LastInsertID('categorie');
            $requete->closeCursor();
            return $this->categorie_id;
        }
        catch(BaseException $e)
        {
            print $e -> getMessage();
        }
    }

    /**
     * Permet de retrouver toutes les Catégories de la base de données.
     */

    public static function findAll()
    {
        try
        {
            // Connection a la base.

            $bdd = Base::getConnection();

            $requete = $bdd -> prepare("SELECT Categorie_Id, Categorie_Nom FROM Categorie;");
            $requete->execute();

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

                $c->setCategorie_id(intval($reponse['Categorie_Id']));
                $c->setCategorie_nom($reponse['Categorie_Nom']);

                $tab[$i] = $c;
                $i++;
            }

            $requete->closeCursor();
            return $tab;
        }
        catch(BaseException $e) { print $e -> getMessage(); }
    }

    /**
     * (PHP 5 &gt;= 5.4.0)<br/>
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     */
    // function called when encoded with json_encode
    public function jsonSerialize() {
        return get_object_vars($this);
    }
}