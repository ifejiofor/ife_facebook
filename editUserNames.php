<!DOCTYPE html>

<?php
   session_start();

   include_once 'includeFiles/functionsToBeUsedAsTestConditions.php';
   include_once 'includeFiles/functionsForCreatingMarkups.php';
   include_once 'includeFiles/functionsForUpdatingDataInDatabase.php';


   if ( userIsNotLoggedIn() ) {
      $markup = getMarkupToTellTheUserToLogIn();
   }
   else {
      $markup =
         getMarkupForHeader() . '
      <div class="containerForEditForm">
         <h3>Edit User Names</h3>';
      
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
      </div>  <!-- end div.containerForEditForm -->
      ';
   }
?>

<html>
   <head>
      <title>Edit User Names | ife_facebook</title>
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