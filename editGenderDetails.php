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
         <h3>Edit Gender Details</h3>
      ';

      if ( userHaveNotClickedOnAnyButton() ) {
         $markup .= getMarkupForFormForEditingGenderDetailsAndSetValuesRetrivedFromDatabaseAsDefault();
      }
      else if ( saveButtonHaveBeenClicked() ) {
         $markup .= validateAndPossiblyUpdateGenderDetails();
      }
      else if ( cancelButtonHaveBeenClicked() ) {
         header( 'Location: aboutMe.php#Gender' );
      }

      $markup .= '
      </div> <!-- end div.containerForEditForm -->
      ';
   }


   function getMarkupForFormForEditingGenderDetailsAndSetValuesRetrivedFromDatabaseAsDefault()
   {
      $rowContainingIdOfGender = retrieveFromDatabaseIdOfGender( $_SESSION['idOfLoggedInUser'] );
      $idOfGender = $rowContainingIdOfGender['id_of_gender'];

      if ( existsInDatabase( $idOfGender ) ) {
         $rowContainingGenderDetails = retrieveFromDatabaseGenderDetails( $idOfGender );
         $defaultGenderDetails = $rowContainingGenderDetails['name_of_gender'];

         return getMarkupForFormForEditingGenderDetails( $defaultGenderDetails );
      }
      else {
         return getMarkupForFormForEditingGenderDetails( NULL );
      }

   }


   function validateAndPossiblyUpdateGenderDetails()
   {

      if ( userDidNotSelectGenderAnyDetail() ) {
         return getMarkupForFormForEditingGenderDetails( INVALID );
      }
      else {
         updateInDatabaseGenderDetails();
         header( 'Location: aboutMe.php#Gender' );
      }

   }


   function userDidNotSelectGenderAnyDetail()
   {
      return !isset( $_POST['genderDetails'] );
   }
?>


<html>
   <head>
      <title>Edit Gender</title>
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