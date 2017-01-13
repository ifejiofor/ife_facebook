<!DOCTYPE html>

<?php
   session_start();

   include_once 'includeFiles/functionsToBeUsedAsTestConditions.php';
   include_once 'includeFiles/functionsForCreatingMarkups.php';

   if ( userIsNotLoggedIn() ) {
      $markup = getMarkupToTellUserToLogin();
   }
   else {
      $markup = 
         getMarkupForHeader() .
      '
      <section class="mainSectionOfProfilePage"> ' .
         getMarkupForTopOfProfilePage( 'myProfile.php' ) .
      '
         <p>abcd</p>
      </section> <!-- end section.mainSectionOfProfilePage -->';
   }
?>

<html>
   <head>
      <title>My Timeline | ife_facebook</title>

      <link href="stylesheets/genericStylesheet.css" type="text/css" rel="stylesheet"/>
      <link href="stylesheets/stylesheetForLoggedInHeader.css" type="text/css" rel="stylesheet"/>
      <link href="stylesheets/stylesheetForTopOfProfilePage.css" type="text/css" rel="stylesheet"/>
      <link href="stylesheets/stylesheetForStatusUpdates.css" type="text/css" rel="stylesheet"/>
   </head>

   <body>
      <?php 
         echo $markup;
      ?>

   </body>
</html>