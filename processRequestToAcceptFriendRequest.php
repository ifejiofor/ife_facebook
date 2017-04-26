<?php
   session_start();

   include_once 'includeFiles/booleanFunctions.php';
   include_once 'includeFiles/functionsForInsertingDataIntoDatabase.php';
   include_once 'includeFiles/functionsForDeletingDataFromDatabase.php';
   include_once 'includeFiles/functionsForStoringDataIntoSESSION.php';
   include_once 'includeFiles/miscellaneousFunctions.php';

   if ( userIsNotLoggedIn() || !isset( $_POST['idOfRequiredUser'] ) ) {
      header( 'Location: index.php' );
   }

   insertIntoDatabaseEntryToIndicateThatRequiredUserAndLoggedInUserAreNowFriends( $_POST['idOfRequiredUser'] );
   deleteFromDatabaseEntryThatIndicatesThatRequiredUserSentFriendRequestToLoggedInUser( $_POST['idOfRequiredUser'] );
   storeIntoSESSIONIdOfAllFriendsAndTotalNumberOfFriendsOfLoggedInUser();
   createNotificationToIndicateThatLoggedinUserHasAcceptedFriendRequestByRequiredUser( $_POST['idOfRequiredUser'] );
   redirectToTheSourcePage();
?>