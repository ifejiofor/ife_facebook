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
         <h3>Edit Email Address</h3>
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
      </div> <!-- end div.containerForEditForm -->';
   }
?>

<html>
   <head>
      <title>Edit Email Address | ife_facebook</title>
      <link href="stylesheets/genericStylesheet.css" type="text/css" rel="stylesheet" />
      <link href="stylesheets/stylesheetForLoggedInHeader.css" type="text/css" rel="stylesheet" />
      <link href="stylesheets/stylesheetForFormForEditingProfileDetails.css" type="text/css" rel="stylesheet" />
   </head>

   <body>
      <?php
         echo $markup;
      ?>

   </body>
</html>