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
         <h3>Change Password</h3>

         <p class="instructionForEditForm">
            Please, fill out all fields. Your new password must not be more than 50 characters long
         </p>';
      
      if ( userHasNotClickedOnAnyButton() ) {
         $markup .= getMarkupForFormForEditingPassword();
      }
      else if ( userHasClickedOnSaveButton() && userDidNotInputValidPasswordDetails() ) {
         $markup .= getMarkupForEditPasswordFormAndAppropriateErrorMessages();
      }
      else if ( userHasClickedOnSaveButton() && userInputtedValidPasswordDetails() ) {
         updateInDatabasePasswordOfLoggedInUser( $_POST['newPassword'] );
         session_destroy();
         header( 'Location: successfullyChangedPassword.php' );
      }
      else if ( userHasClickedOnCancelButton() ) {
         header( 'Location: manageAccount.php' );
      }

      $markup .= '
      </div>  <!-- end div.containerForEditForm -->
      ';
   }
?>

<html>
   <head>
      <title>Change Password | ife_facebook</title>
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