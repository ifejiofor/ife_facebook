<!DOCTYPE html>

<?php
   session_start();

   include_once 'includeFiles/booleanFunctions.php';
   include_once 'includeFiles/functionsForCreatingMarkups.php';
   include_once 'includeFiles/miscellaneousFunctions.php';
   include_once 'includeFiles/functionsForStoringDataIntoSESSION.php';


   if ( userDidNotFillTheLoginForm() ) {
      header( 'Location: index.php' );
   }
   else if ( userDidNotInputCorrectLoginDetails() ) {
      $markup = getMarkupToTellUserToReEnterLoginDetails();
   }
   else if ( userInputtedCorrectLoginDetails() ) {
      logTheUserIn( $_POST['userName'] );
      storeIntoSESSIONIdOfAllFriendsAndTotalNumberOfFriendsOfLoggedInUser();
      storeIntoSESSIONFirstNameOfLoggedInUser();
      redirectToTheSourcePage();
   }
?>


<html>
   <head>
      <title>Unable To Log In | ife_facebook</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
      <link href="stylesheets/ife_facebookStylesheet.css" type="text/css" rel="stylesheet"/>
   </head>

   <body>
      <?php 
         echo $markup;
      ?>

   </body>
</html>