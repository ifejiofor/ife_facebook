<!DOCTYPE html>

<?php
   session_start();

   include_once 'includeFiles/functionsForCreatingMarkups.php';
   include_once 'includeFiles/functionsToBeUsedAsTestConditions.php';
   include_once 'includeFiles/functionsForUpdatingDataInDatabase.php';

   if ( userIsNotLoggedIn() ) {
      $markup = getMarkupToTellUserToLogIn();
   }
   else {
      $markup = 
         getMarkupForHeader() . '

      <div class="containerForEditForm">
         <h2>Edit Profile</h2>
         <h3>Edit Gender Details</h3>
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
      </div> <!-- end div.containerForEditForm -->
      ';
   }
?>


<html>
   <head>
      <title>Edit Gender | ife_facebook</title>
      <link href="stylesheets/genericStylesheet.css" type="text/css" rel="stylesheet"/>
      <link href="stylesheets/stylesheetForLoggedInHeader.css" type="text/css" rel="stylesheet"/>
      <link href="stylesheets/stylesheetForFormForEditingProfileDetails.css" type="text/css" rel="stylesheet"/>
   </head>

   <body>
      <?php 
         echo $markup;
      ?>

   </body>
</html>