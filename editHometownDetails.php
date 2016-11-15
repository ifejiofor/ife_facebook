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
   if ( userIsLoggedIn() ) {
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

      if ( userHaveNotClickedOnAnyButton() ) {
         $markup .= getMarkupForFormForEditingCityDetailsAndSetValuesRetrievedFromDatabaseAsDefault();
      }
      else if ( saveButtonHaveBeenClicked() ) {
         $markup .= validateAndPossiblyUpdateHometownDetails();
      }
      else if ( cancelButtonHaveBeenClicked() ) {
         header( 'Location: aboutMe.php#Hometown' );
      }

      $markup .= '
      </div> <!-- end div.containerForEditForm -->
      ';
   }


   function getMarkupForFormForEditingCityDetailsAndSetValuesRetrievedFromDatabaseAsDefault()
   {
      $rowContainingIdOfHometown = retrieveFromDatabaseIdOfHometown( $_SESSION['idOfLoggedInUser'] );
      $idOfHometown = $rowContainingIdOfHometown['id_of_hometown'];

      if ( existsInDatabase( $idOfHometown ) ) {
         $rowContainingHometownDetails = retrieveFromDatabaseCityDetails( $idOfHometown );

         $defaultNameOfCity = 
            capitalizeWordsThatShouldBeCapitalized( $rowContainingHometownDetails['name_of_city'] );
         $defaultNameOfCountry = 
            capitalizeWordsThatShouldBeCapitalized( $rowContainingHometownDetails['name_of_country'] );

         return getMarkupForFormForEditingCityDetails( $defaultNameOfCity, $defaultNameOfCountry );
      }
      else {
         return getMarkupForFormForEditingCityDetails( '', '' );
      }

   }


   function validateAndPossiblyUpdateHometownDetails()
   {

      if ( userDidNotEnterNameOfCity() || userDidNotEnterNameOfCountry() ) {
         $defaultNameOfCity = ( userDidNotEnterNameOfCity() ? INVALID : $_POST['nameOfCity'] );
         $defaultNameOfCountry = ( userDidNotEnterNameOfCountry() ? INVALID : $_POST['nameOfCountry'] );

         return getMarkupForFormForEditingCityDetails( $defaultNameOfCity, $defaultNameOfCountry );
      }
      else {
         updateInDatabaseHometownDetails();
         header( 'Location: aboutMe.php#Hometown' );
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
      <title>Edit Hometown</title>
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