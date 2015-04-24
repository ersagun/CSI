<?php

/**
 * Class Compte
 */

require_once('Base.php');
require_once('BaseException.php');

class Compte implements JsonSerializable
{

    // Fields


    /**
     * @var String
     */

    private $codename;

    /**
     * @var int
     */

    private $id;

    /**
     * @var String
     */

    private $mdp;


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
     * Modifies the codename attribute.
     * @param $_codename The new value of the codename of this Compte.
     */

    public function setCodename($_codename) { $this->codename = $_codename; }

    /**
     * Modifies the id attribute.
     * @param $_id The new value of the id of this Compte.
     */

    public function setId($_id) { $this->id = $_id; }

    /**
     * Modifies the mdp attribute.
     * @param $_mdp The new value of the mdp of this Compte.
     */

    public function setMdp($_mdp) { $this->mdp = $_mdp; }


    // Constructor


    /**
     * Crée une nouvelle instance de la classe Compte.
     */

    public function __construct()
    {

    }


    // Methods


    /**
     * Insere la Compte dans la base de donnees.
     * @throws Exception Si tous les champs obligatoire de cette
     * classe n'ont pas étés remplis.
     * @return l'ID recupéré par le Compte inséré.
     */

    public function insert()
    {
        try
        {
            // Connection a la base.

            $bdd = Base::getConnection();

            if (!isset($this->codename))
            {
                throw new Exception("Le compte n'a pas pu etre inseré
                 dans la base de donnees car le champ codename n'a pas ete specifié
                  et il s'agit d'un champ obligatoire.");
            }
            else if (!isset($this->mdp))
            {
                throw new Exception("Le compte n'a pas pu etre inseré
                 dans la base de donnees car le champ mdp n'a pas ete specifié
                  et il s'agit d'un champ obligatoire.");
            }

            // On prépare la requete

            $requete = $bdd -> prepare("INSERT INTO compte(Compte_Codename, Compte_mdp)
              VALUES (:codename, :mdp);");
            $requete -> execute(array
            (
                'codename' => $this->codename,
                'mdp' => $this->mdp
            ));

            // On récupere l'identifiant de le Compte insérée.

            $this->id = $bdd->LastInsertID('compte');
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