<!DOCTYPE html>

<?php
   session_start();

   include_once 'includeFiles/functionsForCreatingMarkups.php';
   include_once 'includeFiles/booleanFunctions.php';
   include_once 'includeFiles/functionsForRetrievingDataFromDatabase.php';
   include_once 'includeFiles/functionsForUpdatingDataInDatabase.php';
   include_once 'includeFiles/functionsForDeletingDataFromDatabase.php';


   if ( userIsNotLoggedIn() ) {
      $markup = getMarkupToTellUserToLogIn();
   }
   else {
      $markup = 
         getMarkupForHeader() . '
      <div class="mainBody whiteContainerWithBorder">
         <h1 class="bigSizedText blueText smallBottomMargin" >Edit Hometown Details</h1>
         
         <p class="darkGreyText">
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
         $formerHometown = retrieveFromDatabaseIdOfHometown( $_SESSION['idOfLoggedInUser'] );
         updateInDatabaseHometownDetailsOfLoggedInUser( $_POST['nameOfCity'], $_POST['nameOfCountry'] );
         deleteFromDatabaseCityEntryIfNoUserIsAssociatedWithTheCity( $formerHometown['id_of_hometown'] );
         header( 'Location: aboutMe.php#Hometown' );
      }
      else if ( userHasClickedOnCancelButton() ) {
         header( 'Location: aboutMe.php#Hometown' );
      }

      $markup .= '
      </div>';
   }
?>


<html>
   <head>
      <title>Edit Hometown | ife_facebook</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
      <link href="stylesheets/ife_facebookStylesheet.css" type="text/css" rel="stylesheet"/>
   </head>

   <body>
      <?php 
         echo $markup;
      ?>

   </body>
</html>