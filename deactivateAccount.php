<!DOCTYPE html>

<?php
   session_start();

   include_once 'includeFiles/booleanFunctions.php';
   include_once 'includeFiles/functionsForCreatingMarkups.php';
   include_once 'includeFiles/miscellaneousFunctions.php';


   if ( userIsNotLoggedIn() ) {
      $markup = getMarkupToTellUserToLogIn();
   }
   else {

      if ( userHasNotClickedOnAnyButton() ) {
         $title = 'Confirm Account Deactivation | ife_facebook';
         $markup = getMarkupToConfirmThatUserReallyWantsToDeactivateAccount();
      }
      else if ( userHasClickedOnCancelButton() ) {
         header( 'Location: manageAccount.php' );
      }
      else if ( userHasClickedOnYesButton() ) {
         createNotificationsThatInformFriendsOfLoggedInUserThatAccountOfLoggedInUserHasBeenDeactivated();
         deactivateAccountOfLoggedInUser();
         $title = 'Account Has Been Deactivated | ife_facebook';
         $markup = getMarkupToTellUserThatHisAccountHasBeenDeactivated();
      }

   }
?>

<html>
   <head>
      <title><?php echo $title ?></title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
      <link href="styleSheets/ife_facebookStylesheet.css" type="text/css" rel="stylesheet"/>
   </head>

   <body>
      <?php
         echo $markup;
      ?>

   </body>
</html>