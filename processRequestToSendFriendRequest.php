<?php
   session_start();

   include_once 'includeFiles/booleanFunctions.php';
   include_once 'includeFiles/functionsForInsertingDataIntoDatabase.php';

   if ( userIsNotLoggedIn() || !isset( $_POST['idOfRequiredUser'] ) ) {
      header( 'Location: index.php' );
   }

   insertIntoDatabaseEntryThatIndicatesThatLoggedInUserSentFriendRequestToRequiredUser( $_POST['idOfRequiredUser'] );
   header( 'Location: ' . $_POST['urlOfSourcePage'] );
?>