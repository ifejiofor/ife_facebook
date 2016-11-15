<!DOCTYPE html>

<?php
   session_start();

   include_once 'includeFiles/functionsForManagingLoginStatus.php';
   include_once 'includeFiles/functionsForCreatingMarkups.php';
   include_once 'includeFiles/functionsForRetrievingDataFromDatabase.php';
   include_once 'includeFiles/functionsForUpdatingDataInDatabase.php';
   include_once 'includeFiles/miscellaneousFunctions.php';

   if ( userIsNotLoggedIn() ) {
      $markup = getMarkupToTellTheUserToLogIn( $_SERVER['PHP_SELF'] );
   }
   else if ( logOutButtonHaveBeenClicked() ) {
      logTheUserOut();
   }
   else {
      $markup = 
         getMarkupForHeader() . '
      <div class="containerForEditForm">
         <h2>Edit Profile</h2>
         <h3>Edit Current City Details</h3>
         
         <p class="instructionForEditForm">
            Enter the name of your current city, and the name of the country
            where your current city is located. Then click the "Save" button.
         </p>
      ';

      if ( userHaveNotClickedOnAnyButton() ) {
         $markup .= getMarkupForFormForEditingCityDetailsAndSetValuesRetrievedFromDatabaseAsDefault();
      }
      else if ( saveButtonHaveBeenClicked() ) {
         $markup .= validateAndPossiblyUpdateCurrentCityDetails();
      }
      else if ( cancelButtonHaveBeenClicked() ) {
         header( 'Location: aboutMe.php#Current City' );
      }

      $markup .= '
      </div> <!-- end div.containerForEditForm -->
      ';
   }


   function getMarkupForFormForEditingCityDetailsAndSetValuesRetrievedFromDatabaseAsDefault()
   {
      $rowContainingIdOfCurrentCity = retrieveFromDatabaseIdOfCurrentCity( $_SESSION['idOfLoggedInUser'] );
      $idOfCurrentCity = $rowContainingIdOfCurrentCity['id_of_current_city'];

      if ( existsInDatabase( $idOfCurrentCity ) ) {
         $rowContainingCurrentCityDetails = retrieveFromDatabaseCityDetails( $idOfCurrentCity );

         $defaultNameOfCity = 
            capitalizeWordsThatShouldBeCapitalized( $rowContainingCurrentCityDetails['name_of_city'] );
         $defaultNameOfCountry = 
            capitalizeWordsThatShouldBeCapitalized( $rowContainingCurrentCityDetails['name_of_country'] );

         return getMarkupForFormForEditingCityDetails( $defaultNameOfCity, $defaultNameOfCountry );
      }
      else {
         return getMarkupForFormForEditingCityDetails( '', '' );
      }

   }


   function validateAndPossiblyUpdateCurrentCityDetails()
   {

      if ( userDidNotEnterNameOfCity() || userDidNotEnterNameOfCountry() ) {
         $defaultNameOfCity = ( userDidNotEnterNameOfCity() ? INVALID : $_POST['nameOfCity'] );
         $defaultNameOfCountry = ( userDidNotEnterNameOfCountry() ? INVALID : $_POST['nameOfCountry'] );

         return getMarkupForFormForEditingCityDetails( $defaultNameOfCity, $defaultNameOfCountry );
      }
      else {
         updateInDatabaseCurrentCityDetails();
         header( 'Location: aboutMe.php#Current City' );
      }

   }


   function userDidNotEnterNameOfCity()
   {
      return $_POST['nameOfCity'] == '';
   }


   function userDidNotEnterNameOfCountry()
   {
      return $_POST['nameOfCountry'] == '';
   }
?>


<html>
   <head>
      <title>Edit Current City</title>
      <link href="stylesheets/genericStylesheet.css" type="text/css" rel="stylesheet"/>
      <link href="stylesheets/stylesheetForLoggedInHeaderAndLoggedInBody.css" type="text/css" rel="stylesheet"/>
      <link href="stylesheets/stylesheetForFormForEditingProfileDetails.css" type="text/css" rel="stylesheet"/>
   </head>

   <body>
      <?php 
         echo $markup;
      ?>

   </body>
</html>