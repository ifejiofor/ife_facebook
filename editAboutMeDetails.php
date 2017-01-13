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
         <h3>Edit About Me Details</h3>
      ';

      if ( userHasNotClickedOnAnyButton() ) {
         $markup .= getMarkupForEditAboutMeDetailsFormAndSetValueRetrievedFromDatabaseAsDefaultValue();
      }
      else if ( userHasClickedOnSaveButton() && userDidNotInputValidAboutMeDetails() ) {
         $markup .= getMarkupForEditAboutMeDetailsFormAndAppropriateErrorMessage();
      }
      else if ( userHasClickedOnSaveButton() && userInputtedValidAboutMeDetails() ) {
         updateInDatabaseAboutMeDetails();
         header( 'Location: aboutMe.php#About Me' );
      }
      else if ( userHasClickedOnCancelButton() ) {
         header( 'Location: aboutMe.php#About Me' );
      }

      $markup .= '
      </div> <!-- end div.containerForEditForm -->
      ';
   }
?>

<html>
   <head>
      <title>Edit About Me | ife_facebook</title>
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