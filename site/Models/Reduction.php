<?php

/**
 * Class Reduction
 */

require_once('Base.php');
require_once('BaseException.php');

class Reduction
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

    /**
     * @var int
     */

    private $qteReduction;


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
     * @param $_id The new value of the id of this Reduction.
     */

    public function setId($_id) { $this->id = $_id; }

    /**
     * Modifies the montant attribute.
     * @param $_montant The new value of the montant of this Reduction.
     */

    public function setMontant($_montant) { $this->montant = $_montant; }

    /**
     * Modifies the qteReduction attribute.
     * @param $_qtereduction The new value of the qteReduction of this Reduction.
     */

    public function setQteReduction($_qtereduction) { $this->qteReduction = $_qtereduction; }


    // Constructor


    /**
     * Crée une nouvelle instance de la classe Réduction.
     */

    public function __construct()
    {

    }


    // Methods


    /**
     * Insere la Réduction dans la base de données.
     * @throws Exception Si tous les champs obligatoire de cette
     * classe n'ont pas étés remplis.
     * @return l'ID recupéré par la Réduction insérée.
     */

    public function insert()
    {
        try
        {
            // Connection a la base.

            $bdd = Base::getConnection();

            if (!isset($this->montant))
            {
                throw new Exception("La Réduction n'a pas pu être inserée
                 dans la base de données car le champ montant n'a pas été specifié
                  et il s'agit d'un champ obligatoire.");
            }
            else if (!isset($this->qteReduction))
            {
                throw new Exception("La Réduction n'a pas pu être inserée
                 dans la base de données car le champ qteRéduction n'a pas été specifié
                  et il s'agit d'un champ obligatoire.");
            }

            // On prépare la requête

            $requete = $bdd -> prepare("INSERT INTO reduction(Reduction_montant, Reduction_qtereduction)
              VALUES (:montant, :qte);");
            $requete -> execute(array
            (
                'montant' => $this->montant,
                'qte' => $this->qteReduction
            ));

            // On récupere l'identifiant de la Réduction insérée.

            $this->id = $bdd->LastInsertID('reduction');
            $requete->closeCursor();
            return $this->id;
        }
        catch(BaseException $e)
        {
            print $e -> getMessage();
        }
    }
}