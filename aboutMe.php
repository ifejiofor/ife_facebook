<!DOCTYPE html>

<?php
   session_start();

   include_once '/includeFiles/functionsForManagingLoginStatus.php';
   include_once '/includeFiles/functionsForCreatingMarkups.php';

   if ( userIsNotLoggedIn() ) {
      $markup = getMarkupToTellTheUserToLogIn( $_SERVER['PHP_SELF'] );
   }
   else if ( logOutButtonHaveBeenClicked() ) {
      logTheUserOut();
   }
   else {
      $markup = 
         getMarkupForHeader() . '

      <section class="mainSectionOfProfilePage">' .
         getMarkupForTopOfProfilePage( 'aboutMe.php' ) .
         getMarkupToDisplayBirthdayDetailsOfLoggedInUser() .
         getMarkupToDisplayCurrentCityDetailsOfLoggedInUser() .
         getMarkupToDisplayHometownDetailsOfLoggedInUser() .
         getMarkupToDisplayGenderDetailsOfLoggedInUser() .
         getMarkupToDisplayLanguageDetailsOfLoggedInUser() .
         getMarkupToDisplayFavouriteQuoteDetailsOfLoggedInUser() .
         getMarkupToDisplayAboutMeDetailsOfLoggedInUser() . '
      </section>  <!-- end section.mainSectionOfProfilePage -->
      ';
   }
?>

<html>
   <head>
      <title>About Me</title>
      <link href="stylesheets/genericStylesheet.css" type="text/css" rel="stylesheet"/>
      <link href="stylesheets/stylesheetForLoggedInHeader.css" type="text/css" rel="stylesheet"/>
      <link href="stylesheets/stylesheetForTopOfProfilePage.css" type="text/css" rel="stylesheet"/>
      <link href="stylesheets/stylesheetForProfileDetails.css" type="text/css" rel="stylesheet"/>
   </head>

   <body>
      <?php 
         echo $markup;
      ?>

   </body>
</html>