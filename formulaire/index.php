<?php
  session_start();
?>
<?php
	include("securimage.php");
	$img = new Securimage();

	$pseudo = "";
	$courriel = "";
	$objet = "";
	$sujet = "";
	
	$msgErreurCaptcha = "";
	$msgErreurCourriel = "";

	if(!empty($_POST)){
		$valid = $img->check($_POST['code']);
		
		$pseudo = $_POST['pseudo'];
		$courriel = $_POST['courriel'];
		$objet = $_POST['objet'];
		$sujet = $_POST['sujet'];
		
		if($courriel != ""){
			if($valid) {
						
				$host = "localhost";
				$user = "root";
				$pass = "";
				$bdd = "form_submit";
			
				mysql_connect($host, $user, $pass);
				mysql_select_db($bdd);
				mysql_query("SET NAMES UTF8");
	
				$SQL = "INSERT INTO form_submit (pseudo, courriel, objet, sujet) VALUES ('$pseudo', '$courriel', '$objet', '$sujet')"; 
				$req = mysql_query($SQL) or die("Erreur : " . $SQL);
			
				header("location:index.html");
			 
				exit;
					
			} else {
				$msgErreurCaptcha = "Code invalide, essayez de nouveau";
			}
		}else{
			$msgErreurCourriel = "Votre adresse courriel svp";
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">

<head>
<title>Formulaire</title>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" media="screen" type="text/css" href="global.css" />

</head>
<body>

<div class="corps">

<div id="formulaire">

	<h1>Écrivez moi!</h1>
	
<form action="" method="post" enctype="multipart/form-data" >
	<table class="tableau" >
		<tr>
			<td class="titre">Nom</td>
			<td><input name="pseudo" type="text" style="left" size="26" value="<?php echo $pseudo ?>" />
			</td>
		</tr>
		<tr>
			<td class="titre">Courriel <span class="rouge">*</span> </td>
			<td>
            	<input name="courriel" type="text" style="left" size="26" value="<?php echo $courriel ?>" />&nbsp;<span class="rouge"><?php echo $msgErreurCourriel ?></span>
            </td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><textarea name="sujet" id="sujet" rows="7" cols="50" ><?php echo $sujet ?></textarea></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		<td>
		<div id="secureimage" ><img id="siimage" alt="securimage" src="securimage_show.php?sid=<?php echo md5(time()) ?>" /></div>
		
		<div id="bouton">
			<a id="refresh" tabindex="-1" href="#" title="Nouveau code" onclick="document.getElementById('siimage').src = 'securimage_show.php?sid=' + Math.random(); return false"><img src="images/refresh.gif" alt="Reload Image" onclick="this.blur()" /></a>
			<object id="SecurImage_as3" type="application/x-shockwave-flash" data="flash/securimage_play.swf?audio=securimage_play.php" width="20" height="20" >
				<param name="allowScriptAccess" value="sameDomain" />
				<param name="allowFullScreen" value="false" />
				<param name="wmode" value="transparent" />
				<param name="movie" value="flash/securimage_play.swf?audio=securimage_play.php" />
			</object>
		</div>
			<input type="text" name="code" id="code" size="12" ></input>&nbsp;<span class="rouge"><?php echo $msgErreurCaptcha ?></span><br />

		<div id="submit">
			<input type="submit" value="Envoyez le message" />
			<input type="reset" value="Anuler" />
		</div>
		</td>
		</tr>
	</table>
</form>

	<p>Note :&nbsp;<span class="rouge">* Votre adresse courriel est obligatoire</span></p>

</div>

</div>

</body>
</html>