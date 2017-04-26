<!DOCTYPE html>

<?php
   session_start();

   include_once 'includeFiles/functionsForCreatingMarkups.php';
   include_once 'includeFiles/booleanFunctions.php';
   include_once 'includeFiles/functionsForUpdatingDataInDatabase.php';
   include_once 'includeFiles/functionsForDeletingDataFromDatabase.php';
   include_once 'includeFiles/miscellaneousFunctions.php';


   if ( userIsNotLoggedIn() ) {
      $markup = getMarkupToTellUserToLogIn( 'editLanguagesSpokenDetails.php' );
   }
   else {
      $markup = 
         getMarkupForHeader() . '
      <div class="mainBody whiteContainerWithBorder">
         <h1 class="bigSizedText blueText smallBottomMargin">Edit Languages Spoken</h1>

         <p class="darkGreyText">
            Select the languages you speak. To add a new language, click on "Add New Language" button.
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
         deleteFromDatabaseEntryThatAssociatesLoggedInUserWithLanguage( $_POST['idOfLanguageToBeEdited'] );
         deleteFromDatabaseLanguageEntryIfNoUserIsAssociatedWithTheLanguage( $_POST['idOfLanguageToBeEdited'] );
         header( 'Location: ' . $_SERVER['PHP_SELF'] );
      }
      else if ( userHasClickedOnSaveButton() && userNeedsToBeShownTextFieldForSpecifyingNameOfLanguage() ) {
         $markup .= getMarkupThatDisplaysTextFieldForSpecifyingNameOfLanguage();
      }
      else if ( userHasClickedOnSaveButton() && userDidNotInputValidLanguageDetails() ) {
         $markup .= getMarkupThatShowsAppropriateErrorMessagesInEditLanguageForm();
      }
      else if ( userHasClickedOnSaveButton() && userInputtedValidLanguageDetails() ) {
         updateInDatabaseLanguageDetailsOfLoggedInUser( $_POST['idOfSelectedLanguage'], $_POST['idOfLanguageToBeEdited'] );
         deleteFromDatabaseLanguageEntryIfNoUserIsAssociatedWithTheLanguage( $_POST['idOfLanguageToBeEdited'] );
         header( 'Location: ' . $_SERVER['PHP_SELF'] . '#' . $_POST['languageNumber'] );
      }
      else if ( userHasClickedOnCancelButton() ) {
         header( 'Location: ' . $_SERVER['PHP_SELF'] . '#' . $_POST['languageNumber'] );
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
         <form method="POST" action="' . $_SERVER['PHP_SELF'] . '#' . getLanguageNumberToBeAssociatedWithNewLanguage() . '" class="notFloating">
            <input type="submit" name="addNewLanguageButton" value="Add New Language" class="bigGreenButton"/>
            <input type="submit" name="doneButton" value="Done" class="bigGreenButton"/>
         </form>
      </div>';
   }
?>

<html>
   <head>
      <title>Edit Languages Spoken | ife_facebook</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
      <link href="stylesheets/ife_facebookStylesheet.css" type="text/css" rel="stylesheet"/>
   </head>

   <body>
      <?php 
         echo $markup;
      ?>

   </body>
</html>