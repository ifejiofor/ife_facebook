<?php
   session_start();

   include_once 'includeFiles/booleanFunctions.php';
   include_once 'includeFiles/functionsForDeletingDataFromDatabase.php';
   include_once 'includeFiles/miscellaneousFunctions.php';

   if ( userIsNotLoggedIn() || !isset( $_POST['idOfRequiredUser'] ) ) {
      header( 'Location: index.php' );
   }

   deleteFromDatabaseEntryThatIndicatesThatRequiredUserSentFriendRequestToLoggedInUser( $_POST['idOfRequiredUser'] );
   createNotificationToIndicateThatLoggedInUserHasRejectedFriendRequestByRequiredUser( $_POST['idOfRequiredUser'] );
   header( 'Location: ' . $_POST['urlOfSourcePage'] );

?>