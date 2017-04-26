<!DOCTYPE html>

<?php
   session_start();

   include_once 'includeFiles/booleanFunctions.php';
   include_once 'includeFiles/functionsForCreatingMarkups.php';

   if ( userIsNotLoggedIn() ) {
      $markup = getMarkupToTellUserToLogin();
      $nameOfRequiredUser = '';
   }
   else if ( !isset( $_SESSION['idOfRequiredUser'] ) ) {
      header( 'Location: index.php' );
   }
   else {
      $markup = 
      getMarkupForHeader() .
      getMarkupForTheOpeningTagOfMainBodyDiv() .
         getMarkupForTopOfProfilePageOfRequiredUser( 'friendsOfUser.php' ) .
         getMarkupToDisplayFriendsOfRequiredUser( $_SESSION['idOfRequiredUser'] ) .
      getMarkupForClosingDivTag();

      $nameOfRequiredUser = getMarkupToDisplayFirstNameAndLastNameOfRequiredUser( $_SESSION['idOfRequiredUser'] );
   }
?>


<html>
   <head>
      <title><?php echo $nameOfRequiredUser ?>'s Friends | ife_facebook</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
      <link href="stylesheets/ife_facebookStylesheet.css" type="text/css" rel="stylesheet"/>
   </head>

   <body>
      <?php 
         echo $markup;
      ?>

   </body>
</html>