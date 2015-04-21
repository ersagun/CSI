<?php

/**
 * Class Commande
 */

require_once('Base.php');
require_once('BaseException.php');
require_once('HeureRecuperation.php');
require_once('Panier.php');

class Commande
{

    // Fields


    /**
     * @var Date
     */

    private $date;

    /**
     * @var HeureRecupération
     */

    private $heurerecuperation;

    /**
     * @var int
     */

    private $heurerecuperation_id;

    /**
     * @var int
     */

    private $id;

    /**
     * @var int
     */

    private $panier_id;

    /**
     * @var boolean
     */

    private $recuperee;


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
     * Modifies the date attribute.
     * @param $_date The new value of the date of this Commande.
     */

    public function setDate($_date) { $this->date = $_date; }

    /**
     * Modifies the heurerecuperation_id attribute.
     * @param $_heurerecuperation_id The new value of the heurerecuperation_id of this Commande.
     */

    public function setHeureRecuperation_id($_heurerecuperation_id) { $this->heurerecuperation_id = $_heurerecuperation_id; }

    /**
     * Modifies the id attribute.
     * @param $_id The new value of the id of this Commande.
     */

    public function setId($_id) { $this->id = $_id; }

    /**
     * Modifies the panier_id attribute.
     * @param $_panier_id The new value of the panier_id of this Commande.
     */

    public function setPanier_id($_panier_id) { $this->panier_id = $_panier_id; }

    /**
     * Modifies the recuperee attribute.
     * @param $_recuperee The new value of the recuperee of this Commande.
     */

    public function setRecuperee($_recuperee) { $this->recuperee = $_recuperee; }


    // Constructor


    /**
     * Crée une nouvelle instance de la classe Commande.
     */

    public function __construct()
    {

    }


    // Methods


    /**
     * Insere la Commande dans la base de données.
     * @throws Exception Si tous les champs obligatoire de cette
     * classe n'ont pas étés remplis.
     * @return L'identifiant de la Commande insérée.
     */

    public function insert()
    {
        try
        {
            // Connection a la base.

            $bdd = Base::getConnection();

            if (!isset($this->date))
            {
                throw new Exception("La Commande n'a pas pu être inserée
                 dans la base de données car le champ date n'a pas été specifié
                  et il s'agit d'un champ obligatoire.");
            }
            else if (!isset($this->recuperee))
            {
                throw new Exception("La Commande n'a pas pu être inserée
                 dans la base de données car le champ recuperee n'a pas été specifié
                  et il s'agit d'un champ obligatoire.");
            }
            else if (!isset($this->heurerecuperation_id))
            {
                throw new Exception("La Commande n'a pas pu être inserée
                 dans la base de données car le champ heurerecuperation_id n'a pas été specifié
                  et il s'agit d'un champ obligatoire.");
            }
            else if (!isset($this->panier_id))
            {
                throw new Exception("La Commande n'a pas pu être inserée
                 dans la base de données car le champ panier_id n'a pas été specifié
                  et il s'agit d'un champ obligatoire.");
            }

            $rec = 1;

            if ($this->recuperee)
                $rec = 0;

            // On prépare la requête

            $requete = $bdd -> prepare("INSERT INTO commande(Commande_date, Comande_recuperee,
              HeureRecuperation_id, Panier_Id) VALUES (:dat, :rec, :hr_id, :p_id);");

            $requete -> execute(array
            (
                'dat' => $this->date,
                'rec' => $rec,
                'hr_id' => $this->heurerecuperation_id,
                'p_id' => $this->panier_id
            ));

            // On récupere l'identifiant de la Commande insérée.

            $this->id = $bdd->LastInsertID('commande');
            $requete->closeCursor();
            return $this->id;
        }
        catch(BaseException $e)
        {
            print $e -> getMessage();
        }
    }

    /**
     * On met a jour la base en indiquant que la commande
     * a été récupérée.
     * @throws Exception
     */

    public function estRecuperee()
    {
        try
        {
            // Connection a la base.

            $bdd = Base::getConnection();

            if (!isset($this->id))
            {
                throw new Exception("La Commande n'a pas pu être mise a jour
                 dans la base de données car le champ id n'a pas été specifié
                  et il s'agit d'un champ obligatoire.");
            }

            // On prépare la requête

            $requete = $bdd -> prepare("UPDATE Commande SET Comande_recuperee = 0 WHERE Commande_Id = :id;");

            $requete -> execute(array
            (
                'id' => $this->id
            ));
        }
        catch(BaseException $e)
        {
            print $e -> getMessage();
        }
    }

    /**
     * Permet de retrouver une Commande dans la base de données
     * a l'aide de l'identifiant du Panier.
     * @param $id Le Compose avec l'identifiant du Panier recherché
     */

    public static function findByPanierID($id)
    {
        try
        {
            // Connection a la base.

            $bdd = Base::getConnection();

            // On prépare la récupération de la Commande avec le Panier_Id spécifié.

            $requete = $bdd -> prepare("SELECT Commande_Id, Commande_date, Comande_recuperee,
            Commande.HeureRecuperation_Id AS hr_id, HeureRecuperation_Deb, HeureRecuperation_Fin, Panier_Id
            FROM Commande INNER JOIN HeureRecuperation ON HeureRecuperation.HeureRecuperation_id =
             Commande.HeureRecuperation_Id WHERE Panier_Id = ?;");
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
                $hr = new HeureRecuperation();

                $hr->setId(intval($reponse['hr_id']));
                $hr->setDeb(new DateTime($reponse['HeureRecuperation_Deb']));
                $hr->setFin(new DateTime($reponse['HeureRecuperation_Fin']));

                $c = new Commande();

                $c->id = intval($reponse['Commande_Id']);
                $c->date = new DateTime($reponse['Commande_date']);
                $c->recuperee = (intval($reponse['Comande_recuperee']) == 0);
                $c->panier_id = intval($reponse['Panier_Id']);
                $c->heurerecuperation_id = intval($reponse['hr_id']);
                $c->heurerecuperation = $hr;

                $tab[$i] = $c;
                $i++;
            }

            $requete->closeCursor();
            return $tab;
        }
        catch(BaseException $e) { print $e -> getMessage(); }
    }
}