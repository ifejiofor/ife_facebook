<!DOCTYPE html>

<?php
   session_start();

   include_once 'includeFiles/booleanFunctions.php';
   include_once 'includeFiles/functionsForCreatingMarkups.php';


   if ( userIsNotLoggedIn() ) {
      $markup = getMarkupToTellUserToLogIn();
   }
   else {
      $markup = 
         getMarkupForHeader() .
         getMarkupForTheOpeningTagOfMainBodyDiv() .
            getMarkupForTopOfProfilePageOfLoggedInUser( 'aboutMe.php' ) .
            getMarkupToDisplayBirthdayDetailsOfLoggedInUser() .
            getMarkupToDisplayCurrentCityDetailsOfLoggedInUser() .
            getMarkupToDisplayHometownDetailsOfLoggedInUser() .
            getMarkupToDisplayGenderDetailsOfLoggedInUser() .
            getMarkupToDisplayLanguageDetailsOfLoggedInUser() .
            getMarkupToDisplayFavouriteQuoteDetailsOfLoggedInUser() .
            getMarkupToDisplayAboutMeDetailsOfLoggedInUser() .
            getMarkupToDisplayPhoneNumberDetailsOfLoggedInUser() .
            getMarkupToDisplayEmailAddressDetailsOfLoggedInUser() .
         getMarkupForClosingDivTag();
   }
?>

<html>
   <head>
      <title>About Me | ife_facebook</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <link href="stylesheets/ife_facebookStylesheet.css" type="text/css" rel="stylesheet"/>
   </head>

   <body>
      <?php 
         echo $markup;
      ?>

   </body>
</html>