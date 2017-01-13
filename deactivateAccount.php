<!DOCTYPE html>

<?php
   session_start();

   include_once 'includeFiles/functionsToBeUsedAsTestConditions.php';
   include_once 'includeFiles/functionsForCreatingMarkups.php';

   // NB: I'm not yet done with the code in this script

   if ( userIsNotLoggedIn() ) {
      $markup = getMarkupToTellUserToLogIn();
   }
   else {

      if ( userHasNotClickedOnAnyButton() ) {
         $markup = getMarkupToConfirmThatUserReallyWantsToDeactivateAccount();
      }
      else if ( userHasClickedOnCancelButton() ) {
         header( 'Location: manageAccount.php' );
      }
      else if ( userHasClickedOnYesButton() ) {
         deactivateAccountOfLoggedInUser();
         $markup = getMarkupToTellUserThatHisAccountHasBeenDeactivated();
      }

   }


   function deactivateAccountOfLoggedInUser()
   {
      deleteFromDatabaseEntryThatContainsInformationAboutLoggedInUser();
      deleteFromDatabaseEntriesThatAssociateLoggedInUserWithAnyLanguage();
      deleteFromDatabaseEntriesThatAssociateLoggedInUserWithHisFriends();
      deleteFromDatabaseStatusUpdatesByLoggedInUser();
      deleteFromDatabaseCommentsByLoggedInUserToStatusUpdates();
      deleteFromDatabaseEntriesThatIndicateThatLoggedInUserLikesAnyStatusUpdate();
      deleteFromDatabaseMessagesSentByLoggedInUser();
      deleteFromDatabaseFriendRequestsByLoggedInUser();
      session_destroy();
   }
?>

<html>
   <head>

   </head>

   <body>
      <?php
         echo $markup;
      ?>

   </body>
</html>