<?php

/**
 * Class Historique
 */

require_once('Base.php');
require_once('BaseException.php');

class Historique
{

    // Fields


    /**
     * @var double
     */

    private $ca;

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

    /**
     * @var int
     */

    private $nbvente;


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
     * Modifies the ca attribute.
     * @param $_ca The new value of the ca of this Historique.
     */

    public function setCA($_ca) { $this->ca = $_ca; }

    /**
     * Modifies the deb attribute.
     * @param $_deb The new value of the deb of this Historique.
     */

    public function setDeb($_deb) { $this->deb = $_deb; }

    /**
     * Modifies the fin attribute.
     * @param $_fin The new value of the fin of this Historique.
     */

    public function setFin($_fin) { $this->fin = $_fin; }

    /**
     * Modifies the id attribute.
     * @param $_id The new value of the id of this Historique.
     */

    public function setId($_id) { $this->id = $_id; }

    /**
     * Modifies the nbvente attribute.
     * @param $_nbvente The new value of the nbvente of this Historique.
     */

    public function setNbVente($_nbvente) { $this->nbvente = $_nbvente; }


    // Constructor


    /**
     * Crée une nouvelle instance de la classe Historique.
     */

    public function __construct()
    {

    }


    // Methods


    /**
     * Permet de retrouver un Historique dans la base de données
     * a l'aide de son identifiant.
     * @param $id L'historique avec l'identifiant recherché, null sinon.
     */

    public static function findByID($id)
    {
        try
        {
            // Connection a la base.

            $bdd = Base::getConnection();

            // On prépare la récupération de l'Historique avec l'ID spécifié.

            $requete = $bdd -> prepare("SELECT * FROM Historique WHERE Historique_Id = ?");
            $requete->execute(array($id));

            /**
             * Décommenter ici et commenter la suite si vous voulez retourner
             * l'objet en format JSON.
             * return json_encode($requete->fetchAll(PDO::FETCH_ASSOC));
             */

            // On transforme le résultat en un objet

            $reponse = $requete->fetch(PDO::FETCH_ASSOC);

            // On transforme l'objet en un Historique

            if($reponse)
            {
                $h = new Historique();

                $h->id = intval($reponse['Historique_Id']);
                $h->deb = new DateTime($reponse['Historique_Deb']);
                $h->fin = new DateTime($reponse['Historique_Fin']);
                $h->nbvente = intval($reponse['Historique_Nbvente']);
                $h->ca = floatval($reponse['Historique_Ca']);

                $requete->closeCursor();
                return $h;
            }
            else return null;
        }
        catch(BaseException $e) { print $e -> getMessage(); }
    }
}