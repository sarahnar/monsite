<?php
// D�marage d'une session n�c�ssaire pour r�cup�rer la valeur g�n�r�e d'une page a l'autre :
session_start();

// on d�finie la liste qui va servir a r�cup�rer les lettres qui formeront la valeur a saisir :  :
// Les caract�re suivant ont �t� enlev�s pour �viter toutes confision : ilo01IO
$liste = "abcdefghjkmnpqrstuvwxyz23456789ABCDEFGHJKLMNPQRSTUVWXYZ";

// On cr�er une valeur qui sera notre code secret a saisir :
$code = '';

// On cr�e une boucle pour cr�er une chaine de 5 caract�res pris au hasard au sein de la variable $liste :
while(strlen($code) != 5)
{
$code .= $liste[rand(0,63)];
}

// on d�finit une variable de session nom�e $_SESSION['code'] que l'on r�utilisera plus tard :
$_SESSION['code']=$code;

// on cr�e une image de 50 pixels par 20 pixels :
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

// on cr�e une image de relative mauvaise qualit� (ici 25% d'une image normale pour eviter la reconnaissance visuelle de certains robots :
imagejpeg($img,'',25);
imageDestroy($img);
?>
