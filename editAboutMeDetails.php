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
         <h1 class="bigSizedText blueText smallBottomMargin">Edit About Me</h1>
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
      </div>';
   }
?>

<html>
   <head>
      <title>Edit About Me | ife_facebook</title>
      <meta name="viewport" content="width=initial-width, initial-scale=1.0"/>
      <link href="stylesheets/ife_facebookStylesheet.css" type="text/css" rel="stylesheet"/>
   </head>

   <body>
      <?php
         echo $markup;
      ?>

   </body>
</html>