<?php
   session_start();

   include_once 'includeFiles/functionsForInsertingDataIntoDatabase.php';
   include_once 'includeFiles/booleanFunctions.php';

   if ( userIsLoggedIn() && isset( $_POST['statusUpdateText'] ) && $_POST['statusUpdateText'] != '' &&
      doesNotConsistOfSpacesOnly( $_POST['statusUpdateText'] ) )
   {
      insertIntoDatabaseStatusUpdateByLoggedInUser();
   }

   header( 'Location: index.php' );
?>