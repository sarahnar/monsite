<?php
// Démarage d'une session nécéssaire pour récupérer la valeur générée d'une page a l'autre :
session_start();

// on définie la liste qui va servir a récupérer les lettres qui formeront la valeur a saisir :  :
// Les caractère suivant ont été enlevés pour éviter toutes confision : ilo01IO
$liste = "abcdefghjkmnpqrstuvwxyz23456789ABCDEFGHJKLMNPQRSTUVWXYZ";

// On créer une valeur qui sera notre code secret a saisir :
$code = '';

// On crée une boucle pour créer une chaine de 5 caractères pris au hasard au sein de la variable $liste :
while(strlen($code) != 5)
{
$code .= $liste[rand(0,63)];
}

// on définit une variable de session nomée $_SESSION['code'] que l'on réutilisera plus tard :
$_SESSION['code']=$code;

// on crée une image de 50 pixels par 20 pixels :
$larg = 50;
$haut =20;
$img = imageCreate($larg, $haut);
$rouge = imageColorAllocate($img,200,200,200);
$noir = imageColorAllocate($img,0,0,0);
$code_police=5;
header('Expires: Mon, 26 Jul 2009 05:00:00 GMT'); 
header('Cache-Control: no-store, no-cache, must-revalidate'); 
header('Cache-Control: post-check=0, pre-check=0', false); 
header("Content-type: image/jpeg");

// incorporation de la variable variable $code dans l'image :
imageString($img, $code_police,($larg-imageFontWidth($code_police)*strlen("".$code.""))/2,0, $code,$noir);

// on crée une image de relative mauvaise qualité (ici 25% d'une image normale pour eviter la reconnaissance visuelle de certains robots :
imagejpeg($img,'',25);
imageDestroy($img);
?>
