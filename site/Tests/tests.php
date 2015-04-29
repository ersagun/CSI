<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 18-4-2015
 * Time: 10:25
 */

include_once '../model/Compose.php';
include_once '../model/Commande.php';
include_once '../model/Historique.php';
include_once '../model/ObtenirPromotion.php';

echo "<h1>Test de la classe Categorie ....</h1>";

$cat1 = new Categorie();

try
{
    $cat1->insert();
}
catch (Exception $e) { print $e -> getMessage(); }

$cat1->setCategorie_nom('Biere blonde');

print $cat1->insert() . '  ';

$cat2 = new Categorie();
$cat2->setCategorie_nom('Biere brune');

print $cat2->insert() . '  ';

var_dump(Categorie::findAll());




echo "<h1>Test de la classe Compte ....</h1>";

$cmp1 = new Compte();

try
{
    $cmp1->insert();
}
catch (Exception $e) { print $e -> getMessage(); }


$cmp1->setMdp('mdp');

print $cmp1->insert() . '  ';

$cmp2 = new Compte();

$cmp2->setMdp('motdepasse');

print $cmp2->insert() . '  ';


echo "<h1>Test de la classe HeureRecuperation ....</h1>";

$hr1 = new HeureRecuperation();

try
{
    $hr1->insert();
}
catch (Exception $e) { print $e -> getMessage(); }

$hr1->setDeb(date('Y-m-d'));
$hr1->setFin(date('Y-m-d'));

print $hr1->insert() . '  ';

$hr2 = new HeureRecuperation();

$hr2->setDeb(date('2012-06-03'));
$hr2->setFin(date('2015-06-03'));

print $hr2->insert() . '  ';


echo "<h1>Test de la classe Historique ....</h1>";

// Insérer manuellement une ligne Historique dans la base de données avec pour ID 1.

var_dump(Historique::findByID(1));
var_dump(Historique::findByID(2));



echo "<h1>Test de la classe Promotion ....</h1>";

$prm1 = new Promotion();

try
{
    $prm1->insert();
}
catch (Exception $e) { print $e -> getMessage(); }

$prm1->setMontant(0.25);

print $prm1->insert() . '  ';

$prm2 = new Promotion();

$prm2->setMontant(0.10);

print $prm2->insert() . '  ';





echo "<h1>Test de la classe Reduction ....</h1>";

$red1 = new Reduction();

try
{
    $red1->insert();
}
catch (Exception $e) { print $e -> getMessage(); }

$red1->setMontant(0.25);
$red1->setQteReduction(2);

print $red1->insert() . '  ';

$red2 = new Reduction();

$red2->setMontant(0.05);
$red2->setQteReduction(5);

print $red2->insert() . '  ';





echo "<h1>Test de la classe Produit ....</h1>";

$prd1 = new Produit();
$prd2 = new Produit();
$prd3 = new Produit();

try
{
    $prd1->insert();
}
catch (Exception $e) { print $e -> getMessage(); }

$prd1->setCategorie_id($cat1->categorie_id);
$prd1->setImg_URL('url1');
$prd1->setNom('trolls');
$prd1->setPrix(2.0);

print $prd1->insert() . '  ';

$prd2->setCategorie_id($cat1->categorie_id);
$prd2->setImg_URL('url2');
$prd2->setNom('chouffe');
$prd2->setPrix(2.5);

print $prd2->insert() . '  ';

$prd3->setCategorie_id($cat2->categorie_id);
$prd3->setImg_URL('url3');
$prd3->setNom('leffe');
$prd3->setPrix(3.0);

print $prd3->insert() . '  ';

var_dump(Produit::checkNomUnique('troll')) . '  ';
var_dump(Produit::checkNomUnique('trolls')) . '  ';

print $prd1->id;
var_dump(Produit::findByID($prd1->id)) . '  ';

$rech = array();

var_dump(Produit::rechercherProduit($rech));

$rech['nomExact'] = 'chouffe';
var_dump(Produit::rechercherProduit($rech));

$rech = array();
$rech['nom'] = 'ffe';
var_dump(Produit::rechercherProduit($rech));

$rech['prixMax'] = 2.7;
var_dump(Produit::rechercherProduit($rech));

$rech['prixMin'] = 2.6;
var_dump(Produit::rechercherProduit($rech));

$rech = array();

$rech['idCategorie'] = $cat1->categorie_id;
var_dump(Produit::rechercherProduit($rech));














echo "<h1>Test de la classe Client ....</h1>";

$cli1 = new Client();
$cli2 = new Client();

try
{
    $cli1->insert();
}
catch (Exception $e) { print $e -> getMessage(); }

$cli1->setNom('Min');
$cli1->setPrenom('Ad');
$cli1->setCompte_id($cmp1->id);
$cli1->setCodename("codename");
$cli1->setMdp($cmp1->mdp);
$cli1->setAdmin(true);
$cli1->setCp('54000');
$cli1->setDernierPanier(0);
$cli1->setNumvoie(13);
$cli1->setRue('Rue Michel Ney');
$cli1->setVille('Nancy');
$cli1->setEmail("a@a");

try {
    print $cli1->insert() . '  ';
}
catch (Exception $e) { print $e->getMessage(); }

$cli2->setNom('Vigneron');
$cli2->setPrenom('Laurent');
$cli2->setCompte_id($cmp2->id);
$cli2->setCodename("cnm");
$cli2->setMdp($cmp2->mdp);
$cli2->setAdmin(false);
$cli2->setCp('54000');
$cli2->setDernierPanier(0);
$cli2->setNumvoie(13);
$cli2->setRue('Rue Michel Ney');
$cli2->setVille('Nancy');
$cli2->setEmail("a@a");

try {
    print $cli2->insert() . '  ';
}
catch (Exception $e) { print $e->getMessage(); }

var_dump(Client::findByID($cli1->id));
var_dump(Client::findByNom('Vigneron'));
var_dump(Client::VerifierMdp('cdn', 'motdepasse'));
var_dump(Client::VerifierMdp('cdn', 'mdp'));







echo "<h1>Test de la classe ObtenirPromotion ....</h1>";

$op1 = new ObtenirPromotion();
$op2 = new ObtenirPromotion();
$op3 = new ObtenirPromotion();
$op4 = new ObtenirPromotion();

try
{
    $op1->insert();
}
catch (Exception $e) { print $e -> getMessage(); }

$op1->setDebut(date('2015-04-01'));
$op1->setFin(date('2015-04-30'));
$op1->setPromotion_id($prm1->id);
$op1->setProduit_id($prd1->id);

try {
    print $op1->insert() . '  ';
}
catch (Exception $e) { print $e->getMessage(); }

$op2->setDebut(date('2015-04-01'));
$op2->setFin(date('2015-06-30'));
$op2->setPromotion_id($prm2->id);
$op2->setProduit_id($prd2->id);

try {
    print $op2->insert() . '  ';
}
catch (Exception $e) { print $e->getMessage(); }

var_dump(ObtenirPromotion::findByID($prd1->id, $prm1->id));
var_dump(ObtenirPromotion::findByIDProduit($prd2->id));
var_dump(ObtenirPromotion::findByIDPromotion($prm1->id));








echo "<h1>Test de la classe Panier ....</h1>";

$pan1 = new Panier();
$pan2 = new Panier();
$pan3 = new Panier();

try
{
    $pan1->insert();
}
catch (Exception $e) { print $e -> getMessage(); }

$pan1->setDebutRed(date('2015-04-01'));
$pan1->setFinRed(date('2015-04-30'));
$pan1->setClient_id(Client::findByNom('Min')->id);
$pan1->setReduction_id($red1->id);

try {
    print $pan1->insert() . '  ';
}
catch (Exception $e) { print $e->getMessage(); }

$pan2->setDebutRed(date('2015-04-01'));
$pan2->setFinRed(date('2015-06-30'));
$pan2->setClient_id(Client::findByNom('Vigneron')->id);
$pan2->setReduction_id($red1->id);

$pan3->setDebutRed(date('2015-02-01'));
$pan3->setFinRed(date('2015-02-28'));
$pan3->setClient_id(Client::findByNom('Vigneron')->id);
$pan3->setReduction_id($red2->id);

try {
    print $pan2->insert() . '  ';
    print $pan3->insert() . '  ';
}
catch (Exception $e) { print $e->getMessage(); }

var_dump(Panier::findByID($pan1->id));
var_dump(Panier::findByClientID($cli2->id));






echo "<h1>Test de la classe Compose ....</h1>";

$cp3 = new Compose();
$cp4 = new Compose();
$cp5 = new Compose();

try
{
    $cp3->insert();
}
catch (Exception $e) { print $e -> getMessage(); }

$cp3->setPanier_id($pan2->id);
$cp3->setProduit_id($prd2->id);
$cp3->setQuantite(1);

$cp4->setPanier_id($pan2->id);
$cp4->setProduit_id($prd3->id);
$cp4->setQuantite(2);

$cp5->setPanier_id($pan3->id);
$cp5->setProduit_id($prd1->id);
$cp5->setQuantite(25);

try {
    $cp3->insert();
    $cp4->insert();
    $cp5->insert();
}
catch (Exception $e) { print $e->getMessage(); }

var_dump(Compose::findByPanierID($pan2->id));
var_dump(Compose::findByPanierID($pan3->id));

Compose::supprimerContenuPanier($pan3->id);
var_dump(Compose::findByPanierID($pan3->id));




echo "<h1>Test de la classe Commande ....</h1>";

$cmd1 = new Commande();
$cmd2 = new Commande();
$cmd3 = new Commande();

try
{
    $cmd3->insert();
}
catch (Exception $e) { print $e -> getMessage(); }

$cmd1->setRecuperee(false);
$cmd1->setPanier_id($pan2->id);
$cmd1->setDate(date('2015-05-01'));
$cmd1->setHeureRecuperation_id($hr1->id);

$cmd2->setRecuperee(false);
$cmd2->setPanier_id($pan2->id);
$cmd2->setDate(date('2015-06-01'));
$cmd2->setHeureRecuperation_id($hr2->id);

$cmd3->setRecuperee(false);
$cmd3->setPanier_id($pan3->id);
$cmd3->setDate(date('2015-05-01'));
$cmd3->setHeureRecuperation_id($hr1->id);

try {
    print $cmd1->insert();
    print $cmd2->insert();
    print $cmd3->insert();
}
catch (Exception $e) { print $e->getMessage(); }

var_dump(Commande::findByPanierID($pan2->id));
$cmd1->estRecuperee();
var_dump(Commande::findByPanierID($pan2->id));

