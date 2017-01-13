<?php
   session_start();
   include_once 'includeFiles/functionsForStoringDataIntoSESSION.php';

   storeIntoSESSIONRelevantDetailsAboutAllLanguagesExistingInDatabase();
   header( 'Location: editLanguagesSpokenDetailsRedirected.php' );
?>