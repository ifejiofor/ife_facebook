<!DOCTYPE html>
<?php
   session_start();

   include_once 'includeFiles/booleanFunctions.php';
   include_once 'includeFiles/functionsForCreatingMarkups.php';
   include_once 'includeFiles/functionsForDeletingDataFromDatabase.php';
   include_once 'includeFiles/functionsForStoringDataIntoSESSION.php';
   include_once 'includeFiles/miscellaneousFunctions.php';

   if ( userIsNotLoggedIn() || !isset( $_POST['idOfRequiredUser'] ) || !isset( $_POST['urlOfSourcePage'] ) ) {
      header( 'Location: index.php' );
   }
   else {

      if ( userHasNotClickedOnCancelButton() && userHasNotClickedOnYesButton() ) {
         $markup = getMarkupToConfirmThatLoggedInUserReallyWantsToUnfriendRequiredUser( $_POST['idOfRequiredUser'] );
      }
      else if ( userHasClickedOnCancelButton() ) {
         redirectToTheSourcePage();
      }
      else if ( userHasClickedOnYesButton() ) {
         deleteFromDatabaseEntryThatIndicatesThatRequiredUserAndLoggedInUserAreFriends( $_POST['idOfRequiredUser'] );
         storeIntoSESSIONIdOfAllFriendsAndTotalNumberOfFriendsOfLoggedInUser();
         createNotificationToIndicateThatLoggedInUserHasUnFriendedRequiredUser( $_POST['idOfRequiredUser'] );
         redirectToTheSourcePage();
      }
   }
?>

<html>
   <head>
      <title>Confirm Unfriend Request | ife_facebook</title>
      <meta name="viewport" content="width=initial-width, initial-scale=1.0"/>
      <link href="stylesheets/ife_facebookStylesheet.css" type="text/css" rel="stylesheet"/>
   </head>

   <body>
      <?php 
         echo $markup;
      ?>

   </body>
</html>