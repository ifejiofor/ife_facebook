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
         <h1 class="bigSizedText blueText smallBottomMargin">Edit Email Address</h1>
      ';

      if ( userHasNotClickedOnAnyButton() ) {
         $markup .= getMarkupForEditEmailAddressFormAndSetValueRetrievedFromDatabaseAsDefaultValue();
      }
      else if ( userHasClickedOnSaveButton() && userDidNotInputValidEmailAddress() ) {
         $markup .= getMarkupForEditEmailAddressFormAndAppropriateErrorMessage();
      }
      else if ( userHasClickedOnSaveButton() && userInputtedValidEmailAddress() ) {
         updateInDatabaseEmailAddressDetails( $_POST['emailAddress'] );
         header( 'Location: aboutMe.php#Email Address' );
      }
      else if ( userHasClickedOnCancelButton() ) {
         header( 'Location: aboutMe.php#Email Address' );
      }

      $markup .= '
      </div>';
   }
?>

<html>
   <head>
      <title>Edit Email Address | ife_facebook</title>
      <meta name="viewport" content="width=initial-width, initial-scale=1.0"/>
      <link href="stylesheets/ife_facebookStylesheet.css" type="text/css" rel="stylesheet" />
   </head>

   <body>
      <?php
         echo $markup;
      ?>

   </body>
</html>