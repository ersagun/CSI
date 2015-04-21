<?php

/**
 * Class Panier
 */

require_once('Base.php');
require_once('BaseException.php');
require_once('Reduction.php');
require_once('Client.php');

class Panier implements JsonSerializable
{

    // Fields


    /**
     * @var int
     */

    private $client_id;

    /**
     * @var Date
     */

    private $debutred;

    /**
     * @var Date
     */

    private $finred;

    /**
     * @var int
     */

    private $id;

    /**
     * @var
     */

    private $reduction;

    /**
     * @var int
     */

    private $reduction_id;


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
     * Modifies the client_id attribute.
     * @param $_client_id The new value of the client_id of this Panier.
     */

    public function setClient_id($_client_id) { $this->client_id = $_client_id; }

    /**
     * Modifies the debutred attribute.
     * @param $_debutred The new value of the debutred of this Panier.
     */

    public function setDebutRed($_debutred) { $this->debutred = $_debutred; }

    /**
     * Modifies the finred attribute.
     * @param $_finred The new value of the finred of this Panier.
     */

    public function setFinRed($_finred) { $this->finred = $_finred; }

    /**
     * Modifies the id attribute.
     * @param $_id The new value of the id of this Panier.
     */

    public function setID($_id) { $this->id = $_id; }

    /**
     * Modifies the reduction_id attribute.
     * @param $_reduction_id The new value of the reduction_id of this Panier.
     */

    public function setReduction_id($_reduction_id) { $this->reduction_id = $_reduction_id; }


    // Constructor


    /**
     * Crée une nouvelle instance de la classe Panier.
     */

    public function __construct()
    {

    }


    // Methods


    /**
     * Insere le Panier dans la base de données.
     * @throws Exception Si tous les champs obligatoire de cette
     * classe n'ont pas étés remplis.
     * @return L'identifiant du Panier inséré
     */

    public function insert()
    {
        try
        {
            // Connection a la base.

            $bdd = Base::getConnection();

            if (!isset($this->client_id))
            {
                throw new Exception("Le Panier n'a pas pu être inseré
                 dans la base de données car le champ client_id n'a pas été specifié
                  et il s'agit d'un champ obligatoire.");
            }
            else if (!isset($this->debutred))
            {
                throw new Exception("Le Panier n'a pas pu être inseré
                 dans la base de données car le champ debutred n'a pas été specifié
                  et il s'agit d'un champ obligatoire.");
            }
            else if (!isset($this->finred))
            {
                throw new Exception("Le Panier n'a pas pu être inseré
                 dans la base de données car le champ finred n'a pas été specifié
                  et il s'agit d'un champ obligatoire.");
            }
            else if (!isset($this->reduction_id))
            {
                throw new Exception("Le Panier n'a pas pu être inseré
                 dans la base de données car le champ reduction_id n'a pas été specifié
                  et il s'agit d'un champ obligatoire.");
            }

            // On prépare la requête

            $requete = $bdd -> prepare("INSERT INTO panier(client_Id, DateDebutRed, DateFinRed, Reduction_Id)
              VALUES (:c_id, :deb, :fin, :r_id);");

            $requete -> execute(array
            (
                'c_id' => $this->client_id,
                'deb' => $this->debutred,
                'fin' => $this->finred,
                'r_id' => $this->reduction_id
            ));

            // On récupere l'identifiant du Panier inséré.

            $this->id = $bdd->LastInsertID('panier');
            $requete->closeCursor();
            return $this->id;
        }
        catch(BaseException $e)
        {
            print $e -> getMessage();
        }
    }

    /**
     * Permet de retrouver un Panier dans la base de données
     * a l'aide de son identifiant.
     * @param $id Le Panier avec l'identifiant recherché, null sinon.
     */

    public static function findByID($id)
    {
        try
        {
            // Connection a la base.

            $bdd = Base::getConnection();

            // On prépare la récupération du Panier avec l'ID spécifié.

            $requete = $bdd -> prepare("SELECT Panier_Id, Client_Id, DateDebutRed, DateFinRed, Panier.Reduction_Id
            AS r_id, Reduction_montant, Reduction_qtereduction FROM Panier INNER JOIN Reduction ON
            Reduction.Reduction_Id = Panier.Reduction_Id WHERE Panier_Id = ?");
            $requete->execute(array($id));

            /**
             * Décommenter ici et commenter la suite si vous voulez retourner
             * l'objet en format JSON.
             * return json_encode($requete->fetchAll(PDO::FETCH_ASSOC));
             */

            // On transforme le résultat en un objet

            $reponse = $requete->fetch(PDO::FETCH_ASSOC);

            // On transforme l'objet en un Panier

            if($reponse)
            {
                $r = new Reduction();

                $r->setId(intval($reponse['r_id']));
                $r->setMontant(floatval($reponse['Reduction_montant']));
                $r->setQteReduction(intval($reponse['Reduction_qtereduction']));

                $p = new Panier();

                $p->id = intval($reponse['Panier_Id']);
                $p->client_id = intval($reponse['Client_Id']);
                $p->debutred = new DateTime($reponse['DateDebutRed']);
                $p->finred = new DateTime($reponse['DateFinRed']);
                $p->reduction_id = intval($reponse['r_id']);
                $p->reduction = $r;

                $requete->closeCursor();
                return $p;
            }
            else return null;
        }
        catch(BaseException $e) { print $e -> getMessage(); }
    }

    /**
     * Permet de retrouver un ou des Paniers dans la base de données
     * a l'aide de son identifiant.
     * @param $id Le Panier avec l'identifiant du Client recherché, null sinon.
     */

    public static function findByClientID($id)
    {
        try
        {
            // Connection a la base.

            $bdd = Base::getConnection();

            // On prépare la récupération du Panier avec le Client_Id spécifié.

            $requete = $bdd -> prepare("SELECT Panier_Id, Client_Id, DateDebutRed, DateFinRed, Panier.Reduction_Id
            AS r_id, Reduction_montant, Reduction_qtereduction FROM Panier INNER JOIN Reduction ON
            Reduction.Reduction_Id = Panier.Reduction_Id WHERE Client_Id = ?");
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
                $r = new Reduction();

                $r->setId(intval($reponse['r_id']));
                $r->setMontant(floatval($reponse['Reduction_montant']));
                $r->setQteReduction(intval($reponse['Reduction_qtereduction']));

                $p = new Panier();

                $p->id = intval($reponse['Panier_Id']);
                $p->client_id = intval($reponse['Client_Id']);
                $p->debutred = new DateTime($reponse['DateDebutRed']);
                $p->finred = new DateTime($reponse['DateFinRed']);
                $p->reduction_id = intval($reponse['r_id']);
                $p->reduction = $r;

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