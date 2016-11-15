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
         <h3>Edit About Me Details</h3>
      ';

      if ( userHaveNotClickedOnAnyButton() ) {
         $markup .= getMarkupForFormForEditingAboutMeDetailsWithValuesRetrievedFromDatabaseAsDefault();
      }
      else if ( saveButtonHaveBeenClicked() ) {
         $markup .= validateAndPossiblyUpdateAboutMeDetails();
      }
      else if ( cancelButtonHaveBeenClicked() ) {
         header( 'Location: aboutMe.php#About Me' );
      }

      $markup .= '
      </div> <!-- end div.containerForEditForm -->
      ';
   }


   function getMarkupForFormForEditingAboutMeDetailsWithValuesRetrievedFromDatabaseAsDefault()
   {
      $rowContainingAboutMeDetails = retrieveFromDatabaseAboutMeDetails( $_SESSION['idOfLoggedInUser'] );

      return getMarkupForFormForEditingAboutMeDetails( $rowContainingAboutMeDetails['about_me'] );
   }


   function validateAndPossiblyUpdateAboutMeDetails()
   {

      if ( userDidNotInputHisAboutMeDetails() ) {
         return getMarkupForFormForEditingAboutMeDetails( INVALID );
      }
      else {
         updateInDatabaseAboutMeDetails();
         header( 'Location: aboutMe.php#About Me' );
      }

   }


   function userDidNotInputHisAboutMeDetails() {
      return $_POST['aboutMe'] == '';
   }
?>

<html>
   <head>
      <title>Edit About Me</title>
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