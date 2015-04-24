<?php

/**
 * Class Promotion
 */

require_once('Base.php');
require_once('BaseException.php');

class Promotion implements JsonSerializable
{

    // Fields


    /**
     * @var int
     */

    private $id;

    /**
     * @var Double
     */

    private $montant;


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
     * Modifies the id attribute.
     * @param $_id The new value of the id of this Promotion.
     */

    public function setId($_id) { $this->id = $_id; }

    /**
     * Modifies the montant attribute.
     * @param $_montant The new value of the montant of this Promotion.
     */

    public function setMontant($_montant) { $this->montant = $_montant; }


    // Constructor


    /**
     * Crée une nouvelle instance de la classe Promotion.
     */

    public function __construct()
    {

    }


    // Methods


    /**
     * Insere la Promotion dans la base de données.
     * @throws Exception Si tous les champs obligatoire de cette
     * classe n'ont pas étés remplis.
     * @return l'ID recupéré par la Promotion insérée.
     */

    public function insert()
    {
        try
        {
            // Connection a la base.

            $bdd = Base::getConnection();

            if (!isset($this->montant))
            {
                throw new Exception("La Promotion n'a pas pu être inserée
                 dans la base de donnees car le champ montant n'a pas été specifié
                  et il s'agit d'un champ obligatoire.");
            }

            // On prépare la requete

            $requete = $bdd -> prepare("INSERT INTO promotion(Promotion_montant)
              VALUES (:montant);");
            $requete -> execute(array
            (
                'montant' => $this->montant
            ));

            // On récupere l'identifiant de la Promotion insérée.

            $this->id = $bdd->LastInsertID('promotion');
            $requete->closeCursor();
            return $this->id;
        }
        catch(BaseException $e)
        {
            print $e -> getMessage();
        }
    }

    // function called when encoded with json_encode
    public function jsonSerialize() {
        return get_object_vars($this);
    }
}