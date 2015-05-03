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

    public static function updateClientId($client_id,$compte_id){
        try {
           
            $bdd = Base::getConnection();
            // On prépare la requête

             $requete = $bdd->prepare("Update compte SET Compte.Client_Id=:dp WHERE Compte_Id=:coi");

            $bol=$requete->execute(array
            (
                'coi'=>$compte_id,
                'dp'=>$client_id
            ));
            // On récupere l'identifiant du Client inséré.

            $requete->closeCursor();
        } catch (BaseException $e) {
            print $e->getMessage();
        }
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

            
           if (!isset($this->mdp))
            {
                throw new Exception("Le compte n'a pas pu etre inseré
                 dans la base de donnees car le champ mdp n'a pas ete specifié
                  et il s'agit d'un champ obligatoire.");
            }

            // On prépare la requete

            $requete = $bdd -> prepare("INSERT INTO compte(Compte_mdp)
              VALUES (:mdp);");
            $requete -> execute(array
            (
                'mdp'=>$this->mdp
            ));

            // On récupere l'identifiant de le Compte insérée.

            $requete->closeCursor();
            return $this->id;
        }
        catch(BaseException $e)
        {
            print $e -> getMessage();
        }
    }

    public static function getClientPanierId($username,$mdp){
        {
        try {
            // Connection a la base.

            $bdd = Base::getConnection();

            // On prépare la récupération du Client avec l'ID spécifié.

            $requete = $bdd->prepare("SELECT Client_DernierPanier FROM Client INNER JOIN Compte ON Compte.Compte_Id =
            Client.Compte_Id WHERE Compte.Compte_mdp = ?,Client.Client_codename=?");
            $requete->execute(array($mdp,$username));

            /**
             * Décommenter ici et commenter la suite si vous voulez retourner
             * l'objet en format JSON.
             * return json_encode($requete->fetchAll(PDO::FETCH_ASSOC));
             */

            // On transforme le résultat en un objet

            $reponse = $requete->fetch(PDO::FETCH_ASSOC);

            // On transforme l'objet en un Produit

            if ($reponse) {
               $rep=$reponse["Client_Id"];

                $requete->closeCursor();
                return $cl;
            } else $rep=null;
            
            return $rep;
        } catch (BaseException $e) {
            print $e->getMessage();
        }
    }
    }
    
    // function called when encoded with json_encode
    public function jsonSerialize() {
        return get_object_vars($this);
    }
}