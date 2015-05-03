<?php

/**
 * Class HeureRecuperation
 */

require_once('Base.php');
require_once('BaseException.php');

class HeureRecuperation implements JsonSerializable
{

    // Fields


    /**
     * @var Date
     */

    private $deb;

    /**
     * @var Date
     */

    private $fin;

    /**
     * @var int
     */

    private $id;


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
     * Modifies the deb attribute.
     * @param $_deb The new value of the deb of this HeureRecuperation.
     */

    public function setDeb($_deb) { $this->deb = $_deb; }

    /**
     * Modifies the fin attribute.
     * @param $_fin The new value of the fin of this HeureRecuperation.
     */

    public function setFin($v) { 
        /**
        list($year, $month, $day, $hour, $min) = preg_split('/[: -]/', $v);
        $hint=intval($hour);
        $val=$hint+1;
        $heuremod=$val;
        
        $_fin=$year+"-"+$month+"-"+$day+"- "+$heuremod+":"+$min;
         * **/
        $this->fin=$v;
    }

    /**
     * Modifies the id attribute.
     * @param $_id The new value of the id of this HeureRecuperation.
     */

    public function setId($_id) { $this->id = $_id; }


    // Constructor


    /**
     * Crée une nouvelle instance de la classe HeureRecuperation.
     */

    public function __construct()
    {

    }


    // Methods


    /**
     * Insere l'HeureRécupération dans la base de donnees.
     * @throws Exception Si tous les champs obligatoire de cette
     * classe n'ont pas étés remplis.
     * @return l'ID recupéré par l'HeureRécupération insérée.
     */

    public function insert()
    {
        try
        {
            // Connection a la base.

            $bdd = Base::getConnection();

            if (!isset($this->deb))
            {
                throw new Exception("L'HeureRécupération n'a pas pu être inserée
                 dans la base de donnees car le champ deb n'a pas été specifié
                  et il s'agit d'un champ obligatoire.");
            }
           /** else if (!isset($this->fin))
            {
                throw new Exception("L'HeureRécupération n'a pas pu être inseré
                 dans la base de donnees car le champ fin n'a pas été specifié
                  et il s'agit d'un champ obligatoire.");
            }**/

            // On prépare la requete

            $requete = $bdd -> prepare("INSERT INTO heurerecuperation(HeureRecuperation_Deb, HeureRecuperation_Fin)
              VALUES (STR_TO_DATE(:deb,'%Y-%m-%d %H:%i:%s'),STR_TO_DATE(:fin,'%Y-%m-%d %H:%i:%s')+ INTERVAL 2 HOUR);");
            $requete -> execute(array
            (
                'deb' => $this->deb,
                'fin' => $this->fin
            ));

            // On récupere l'identifiant de l'HeureRécupération insérée.

            $this->id = $bdd->LastInsertID('heurerecuperation');
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