<!DOCTYPE html>

<?php
   session_start();

   include_once 'includeFiles/functionsForCreatingMarkups.php';
   include_once 'includeFiles/functionsToBeUsedAsTestConditions.php';
   include_once 'includeFiles/functionsForUpdatingDataInDatabase.php';
   include_once 'includeFiles/functionsForDeletingDataFromDatabase.php';
   include_once 'includeFiles/miscellaneousFunctions.php';


   if ( userIsNotLoggedIn() ) {
      $markup = getMarkupToTellUserToLogIn( 'editLanguagesSpokenDetails.php' );
   }
   else {
      $markup = 
         getMarkupForHeader() . '

      <div class="containerForEditForm">
         <h2>Edit Profile</h2>
         <h3>Edit Languages Spoken</h3>

         <p class="instructionForEditForm">
            Select your languages. To add a new language, click on "Add New Language" button.
            When you are through, click on the "Done" button.
         </p>
      ';

      if ( userHasNotClickedOnAnyButton() && noDetailAboutLanguagesSpokenByUserExistsInDatabase() ) {
         $markup .= getMarkupForAddNewLanguageForm();
      }
      else if ( userHasNotClickedOnAnyButton() && detailsAboutLanguagesSpokenByUserExistsInDatabase() ) {
         $markup .= getMarkupThatDisplaysAListOfAllLanguagesSpokenByUser();
      }
      else if ( userHasClickedOnEditLanguageButton() ) {
         $markup .= getMarkupThatAllowsUserToEditTheRequiredLanguage();
      }
      else if ( userHasClickedOnDeleteLanguageButton() ) {
         deleteFromDatabaseLanguageEntry( $_POST['idOfLanguageToBeEdited'] );
         header( 'Location: ' . $_SERVER['PHP_SELF'] );
      }
      else if ( userHasClickedOnSaveButton() && userNeedsToBeShownTextFieldForSpecifyingNameOfLanguage() ) {
         $markup .= getMarkupThatDisplaysTextFieldForSpecifyingNameOfLanguage();
      }
      else if ( userHasClickedOnSaveButton() && userDidNotInputValidLanguageDetails() ) {
         $markup .= getMarkupThatShowsAppropriateErrorMessagesInEditLanguageForm();
      }
      else if ( userHasClickedOnSaveButton() && userInputtedValidLanguageDetails() ) {
         updateInDatabaseLanguageDetails( $_POST['idOfSelectedLanguage'], $_POST['idOfLanguageToBeEdited'] );
         header( 'Location: ' . $_SERVER['PHP_SELF'] );
      }
      else if ( userHasClickedOnCancelButton() ) {
         header( 'Location: ' . $_SERVER['PHP_SELF'] );
      }
      else if ( userHasClickedOnAddNewLanguageButton() ) { 
         $markup .= 
            getMarkupThatDisplaysAListOfAllLanguagesSpokenByUser() .
            getMarkupForAddNewLanguageForm();
      }
      else if ( userHasClickedOnDoneButton() ) {
         header( 'Location: aboutMe.php#Languages Spoken' );
      }

      $markup .= '
         <form method="POST" action="' . $_SERVER['PHP_SELF'] . '" class="containerForExtraButtonsInEditForm">
            <input type="submit" name="addNewLanguageButton" value="Add New Language" class="extraButtonInEditForm"/>
            <input type="submit" name="doneButton" value="Done" class="extraButtonInEditForm"/>
         </form>
      </div> <!-- end div.containerForEditForm -->
      ';
   }
?>

<html>
   <head>
      <title>Edit Languages Spoken | ife_facebook</title>
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