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
      $profileDetails =
         getMarkupToDisplayBirthdayDetailsOfRequiredUser( $_SESSION['idOfRequiredUser'] ) .
         getMarkupToDisplayCurrentCityDetailsOfRequiredUser( $_SESSION['idOfRequiredUser'] ) .
         getMarkupToDisplayHometownDetailsOfRequiredUser( $_SESSION['idOfRequiredUser'] ) .
         getMarkupToDisplayGenderDetailsOfRequiredUser( $_SESSION['idOfRequiredUser'] ) .
         getMarkupToDisplayLanguageDetailsOfRequiredUser( $_SESSION['idOfRequiredUser'] ) .
         getMarkupToDisplayFavouriteQuoteDetailsOfRequiredUser( $_SESSION['idOfRequiredUser'] ) .
         getMarkupToDisplayAboutMeDetailsOfRequiredUser( $_SESSION['idOfRequiredUser'] );

      $markup = 
      getMarkupForHeader() .
      getMarkupForTheOpeningTagOfMainBodyDiv() .
         getMarkupForTopOfProfilePageOfRequiredUser( 'aboutUser.php' ) .
         ( $profileDetails == '' ? '   <p>No profile details to view.</p>' : $profileDetails ) .
      getMarkupForClosingDivTag();

      $nameOfRequiredUser = getMarkupToDisplayFirstNameAndLastNameOfRequiredUser( $_SESSION['idOfRequiredUser'] );
   }
?>

<html>
   <head>
      <title>About <?php echo $nameOfRequiredUser ?> | ife_facebook</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
      <link href="stylesheets/ife_facebookStylesheet.css" type="text/css" rel="stylesheet"/>
   </head>

   <body>
      <?php 
         echo $markup;
      ?>

   </body>
</html>