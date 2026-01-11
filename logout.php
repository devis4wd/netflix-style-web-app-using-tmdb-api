<?php
//Riabilitare queste due righe per vedere errori se serve fare debugging
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

// session_start() va sempre all'inizio del codice PHP
session_start();

//Resetta i valori di TUTTE le variabili superglobali salvate nella sessione corrente
session_unset(); 
//Termina completamente la sessione corrente, incluso il suo ID e i file di sessione sul server
session_destroy(); 

// Rimuovere anche cookie come pratica di sicurezza (se li hai creati)

//Una volta sloggato l'utente, riportami in Homepage:
header('location: index.php');

//Stoppiamo esecuzione del codice PH P dopo aver terminato sessione e reindirizzato l'utente.
//In questo modo si evita che il codcie possa in qualche modo continuare ad essere eseguito casusando
//possibili problemi o inconvenienti:
exit();

