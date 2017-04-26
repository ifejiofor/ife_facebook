<!DOCTYPE html>

<?php
   session_start();

   include_once 'includeFiles/functionsForCreatingMarkups.php';
   include_once 'includeFiles/booleanFunctions.php';
   include_once 'includeFiles/functionsForUpdatingDataInDatabase.php';

   if ( userIsNotLoggedIn() ) {
      $markup = getMarkupToTellUserToLogIn();
   }
   else {
      $markup = 
         getMarkupForHeader() . '

      <div class="mainBody whiteContainerWithBorder">
         <h1 class="bigSizedText blueText smallBottomMargin">Edit Gender Details</h1>
      ';

      if ( userHasNotClickedOnAnyButton() ) {
         $markup .= getMarkupForEditGenderDetailsFormAndSetValueRetrievedFromDatabaseAsDefaultValue();
      }
      else if ( userHasClickedOnSaveButton() && userDidNotSelectValidGenderDetail() ) {
         $markup .= getMarkupForEditGenderDetailsFormAndAppropriateErrorMessage();
      }
      else if ( userHasClickedOnSaveButton() && userSelectedValidGenderDetail() ) {
         updateInDatabaseGenderDetails();
         header( 'Location: aboutMe.php#Gender' );
      }
      else if ( userHasClickedOnCancelButton() ) {
         header( 'Location: aboutMe.php#Gender' );
      }

      $markup .= '
      </div>';
   }
?>


<html>
   <head>
      <title>Edit Gender | ife_facebook</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
      <link href="stylesheets/ife_facebookStylesheet.css" type="text/css" rel="stylesheet"/>
   </head>

   <body>
      <?php 
         echo $markup;
      ?>

   </body>
</html>