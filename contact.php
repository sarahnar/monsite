<?php

 $destinataire = 'clergentsarah@gmail.com';

 $copie = 'oui';

 $form_action = 'contact.php?page=contact';

 $message_envoye = "Votre message nous est bien parvenu !";
 $message_non_envoye = "L'envoi du mail a échoué, veuillez réessayer SVP.";

 $message_formulaire_invalide = "Vérifiez que tous les champs soient bien remplis et que votre courriel soit sans erreur.";

 function Rec($text)
  {
    $text = trim($text);
    if (1 === get_magic_quotes_gpc())
    {
      $stripslashes = create_function('$txt', 'return stripslashes($txt);');
        }
        else
        {
          $stripslashes = create_function('$txt', 'return $txt;');
        }

        $text = $stripslashes($text);
        $text = htmlspecialchars($text, ENT_QUOTES);
        $text = nl2br($text);
        $text = utf8_decode($text);
        return $text;
    };

	function IsEmail($email)
    {
        $pattern = "^([a-z0-9_]|\\-|\\.)+@(([a-z0-9_]|\\-)+\\.)+[a-z]{2,7}$";
        return (eregi($pattern,$email)) ? true : false;
    };

    $err_formulaire = false;

    $nom     = (isset($_POST['nom']))     ? Rec($_POST['nom'])     : '';
    $email   = (isset($_POST['email']))   ? Rec($_POST['email'])   : '';
    $objet   = (isset($_POST['objet']))   ? Rec($_POST['objet'])   : '';
    $message = (isset($_POST['message'])) ? Rec($_POST['message']) : '';

    if (isset($_POST['envoi']))
    {
        $email = (IsEmail($email)) ? $email : '';
        $err_formulaire = (IsEmail($email)) ? false : true;

        if (($nom != '') && ($email != '') && ($objet != '') && ($message != ''))
        {
          $headers = 'From: '.$nom.' <'.$email.'>' . "\r\n";

          if ($copie == 'oui')
            {
              $cible = $destinataire.','.$email;
            }
            else
            {
              $cible = $destinataire;
            };

            $message = html_entity_decode($message);
            $message = str_replace('&#039;',"'",$message);
            $message = str_replace('&#8217;',"'",$message);
            $message = str_replace('<br>','',$message);
            $message = str_replace('<br />','',$message);

            if (mail($cible, $objet, $message, $headers))
            {
              echo '<p>'.$message_envoye.'</p>'."\n";
            }
            else
            {
              echo '<p>'.$message_non_envoye.'</p>'."\n";
            };
        }
        else
        {
            echo '<p>'.$message_formulaire_invalide.' <a href="contact.php">Retour au formulaire</a></p>'."\n";
            $err_formulaire = true;
        };
    };

    if (($err_formulaire) || (!isset($_POST['envoi'])))
    {
        echo '<form id="contact" method="post" action="'.$form_action.'">'."\n";
        echo ' <p>'."\n";
        echo '  <label for="nom">Nom</label>'."\n";
        echo '  <input type="text" id="nom" name="nom" value="'.stripslashes($nom).'" tabindex="1" />'."\n";
        echo ' </p>'."\n";
        echo ' <p>'."\n";
        echo '  <label for="email">Courriel*</label>'."\n";
        echo '  <input type="text" id="email" name="email" value="'.stripslashes($email).'" tabindex="2" />'."\n";
        echo ' </p>'."\n";
        echo ' <p>'."\n";
        echo '  <label for="objet">Objet</label>'."\n";
        echo '  <input type="text" id="objet" name="objet" size="53" value="'.stripslashes($objet).'" tabindex="3" />'."\n";
        echo ' </p>'."\n";
        echo ' <p>'."\n";
        echo '  <label for="message">Message</label>'."\n";
        echo '  <textarea id="message" name="message" tabindex="4" cols="60" rows="8">'.stripslashes($message).'</textarea>'."\n";
        echo ' </p>'."\n";

        echo ' <div><input type="submit" name="envoi" id="go" value=" Soumettre " /></div>'."\n";
        echo '</form>'."\n";
    };
?>

<p class="note">* Vous recevrez automatiquement une copie du message que vous nous avez fait parvenir dans votre boîte courriel.</p>
