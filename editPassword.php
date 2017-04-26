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
      $title = 'Change Password | ife_facebook';
      $markup =
         getMarkupForHeader() . '
      <div class="mainBody whiteContainerWithBorder">
         <h1 class="bigSizedText blueText smallBottomMargin">Edit Password</h1>
         <p class="darkGreyText">Please, fill out all fields. Your new password must not be more than 50 characters long</p>
      ';
      
      if ( userHasNotClickedOnAnyButton() ) {
         $markup .= getMarkupForFormForEditingPassword() . '
      </div>';
      }
      else if ( userHasClickedOnSaveButton() && userDidNotInputValidPasswordDetails() ) {
         $markup .= getMarkupForEditPasswordFormAndAppropriateErrorMessages() . '
      </div>';
      }
      else if ( userHasClickedOnSaveButton() && userInputtedValidPasswordDetails() ) {
         updateInDatabasePasswordOfLoggedInUser( $_POST['newPassword'] );
         session_destroy();
         $title = 'Successfully Changed Password | ife_facebook';
         $markup = getMarkupToTellUserThatHisPasswordHasBeenChangedSuccessfully();
      }
      else if ( userHasClickedOnCancelButton() ) {
         header( 'Location: manageAccount.php' );
      }
   }
?>

<html>
   <head>
      <title><?php echo $title ?></title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
      <link href="stylesheets/ife_facebookStylesheet.css" type="text/css" rel="stylesheet" />
   </head>

   <body>
      <?php
         echo $markup;
      ?>

   </body>
</html>