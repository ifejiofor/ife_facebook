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
         <h3>Edit Hometown Details</h3>
         
         <p class="instructionForEditForm">
            Enter the name of your hometown, and the name of the country
            where your hometown is located. Then click the "Save" button.
         </p>
      ';

      if ( userHasNotClickedOnAnyButton() ) {
         $markup .= getMarkupForEditCityDetailsFormAndSetHometownValuesRetrievedFromDatabaseAsDefaultValues();
      }
      else if ( userHasClickedOnSaveButton() && userDidNotInputValidCityDetails() ) {
         $markup .= getMarkupForEditCityDetailsFormAndAppropriateErrorMessages();
      }
      else if ( userHasClickedOnSaveButton() && userInputtedValidCityDetails() ) {
         updateInDatabaseHometownDetails();
         header( 'Location: aboutMe.php#Hometown' );
      }
      else if ( userHasClickedOnCancelButton() ) {
         header( 'Location: aboutMe.php#Hometown' );
      }

      $markup .= '
      </div> <!-- end div.containerForEditForm -->
      ';
   }
?>


<html>
   <head>
      <title>Edit Hometown | ife_facebook</title>
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