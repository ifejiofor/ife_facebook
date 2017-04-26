<!DOCTYPE html>

<?php
   session_start();

   include_once 'includeFiles/booleanFunctions.php';
   include_once 'includeFiles/functionsForCreatingMarkups.php';
   include_once 'includeFiles/functionsForUpdatingDataInDatabase.php';


   if ( userIsNotLoggedIn() ) {
      $markup = getMarkupToTellTheUserToLogIn();
   }
   else {
      $markup =
         getMarkupForHeader() . '
      <div class="mainBody whiteContainerWithBorder">
         <h1 class="bigSizedText blueText smallBottomMargin">Edit User Names</h1>
      ';
      
      if ( userHasNotClickedOnAnyButton() ) {
         $markup .= getMarkupForEditUserNamesFormAndSetValuesRetrievedFromDatabaseAsDefaultValues();
      }
      else if ( userHasClickedOnSaveButton() && userDidNotInputValidUserNames() ) {
         $markup .= getMarkupForEditUserNamesFormAndAppropriateErrorMessages();
      }
      else if ( userHasClickedOnSaveButton() && userInputtedValidUserNames() ) {
         updateInDatabaseFirstNameLastNameAndNickNameOfLoggedInUser( 
            $_POST['firstName'], $_POST['lastName'], $_POST['nickName'] );
         header( 'Location: manageAccount.php' );
      }
      else if ( userHasClickedOnCancelButton() ) {
         header( 'Location: manageAccount.php' );
      }

      $markup .= '
      </div>';
   }
?>

<html>
   <head>
      <title>Edit User Names | ife_facebook</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
      <link href="stylesheets/ife_facebookStylesheet.css" type="text/css" rel="stylesheet" />
   </head>

   <body>
      <?php
         echo $markup;
      ?>

   </body>
</html>