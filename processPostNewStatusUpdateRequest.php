<?php
   session_start();

   include_once 'includeFiles/functionsForInsertingDataIntoDatabase.php';
   include_once 'includeFiles/functionsToBeUsedAsTestConditions.php';
   include_once 'includeFiles/usefulConstants.php';

   if ( userIsLoggedIn() && isset( $_POST['statusUpdateText'] ) && $_POST['statusUpdateText'] != '' ) {
      insertIntoDatabaseStatusUpdateByLoggedInUser();
   }

   header( 'Location: index.php' );


?>