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
         <h1 class="bigSizedText blueText smallBottomMargin">Edit Current City Details</h1>
         
         <p class="darkGreyText">
            Enter the name of your current city, and the name of the country
            where your current city is located. Then click the "Save" button.
         </p> 
      ';

      if ( userHasNotClickedOnAnyButton() ) {
         $markup .= getMarkupForEditCityDetailsFormAndSetCurrentCityValuesRetrievedFromDatabaseAsDefaultValues();
      }
      else if ( userHasClickedOnSaveButton() && userDidNotInputValidCityDetails() ) {
         $markup .= getMarkupForEditCityDetailsFormAndAppropriateErrorMessages();
      }
      else if ( userHasClickedOnSaveButton() && userInputtedValidCityDetails() ) {
         $formerCurrentCity = retrieveFromDatabaseIdOfCurrentCity( $_SESSION['idOfLoggedInUser'] );
         updateInDatabaseCurrentCityDetailsOfLoggedInUser( $_POST['nameOfCity'], $_POST['nameOfCountry'] );
         deleteFromDatabaseCityEntryIfNoUserIsAssociatedWithTheCity( $formerCurrentCity['id_of_current_city'] );
         header( 'Location: aboutMe.php#Current City' );
      }
      else if ( userHasClickedOnCancelButton() ) {
         header( 'Location: aboutMe.php#Current City' );
      }

      $markup .= '
      </div>';
   }
?>


<html>
   <head>
      <title>Edit Current City | ife_facebook</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
      <link href="stylesheets/ife_facebookStylesheet.css" type="text/css" rel="stylesheet"/>
   </head>

   <body>
      <?php 
         echo $markup;
      ?>

   </body>
</html>