<!DOCTYPE html>

<?php
   session_start();

   include_once 'includeFiles/functionsForManagingLoginStatus.php';
   include_once 'includeFiles/functionsForCreatingMarkups.php';
   include_once 'includeFiles/functionsForRetrievingDataFromDatabase.php';
   include_once 'includeFiles/functionsForInsertingDataIntoDatabase.php';
   include_once 'includeFiles/functionsForUpdatingDataInDatabase.php';
   include_once 'includeFiles/functionsForDeletingDataFromDatabase.php';
   include_once 'includeFiles/miscellaneousFunctions.php';

   if ( userIsNotLoggedIn() ) {
      $markup = getMarkupToTellTheUserToLogIn( 'editLanguagesSpokenDetails.php' );
   }
   else if ( logOutButtonHaveBeenClicked() ) {
      logTheUserOut();
   }
   else {
      $idOfAllLanguagesSpoken = 
         retrieveFromDatabaseAndReturnInArrayIdOfAllLanguagesSpoken( $_SESSION['idOfLoggedInUser'] );

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

      if ( userHaveNotClickedOnAnyButton() ) {

         if ( sizeof( $idOfAllLanguagesSpoken ) == 0 ) {
            $markup .= getMarkupForFormForAddingNewLanguage( 0 );
         }
         else {
            $markup .= getMarkupToListNamesOfLanguagesWithEditAndDeleteButtons();
         }

      }
      else if ( editLanguageButtonHaveBeenClicked() ) {
         $markup .= getMarkupToSetOneLanguageToBeEdited( $_POST['idOfLanguageToBeEdited'], 
            $_POST['idOfLanguageToBeEdited'] );
      }
      else if ( deleteLanguageButtonHaveBeenClicked() ) {
         deleteFromDatabaseLanguageEntry( $_POST['idOfLanguageToBeEdited'] );
         header( 'Location: ' . $_SERVER['PHP_SELF'] );
      }
      else if ( saveButtonHaveBeenClicked() ) {
         $markup .= validateAndPossiblyUpdateLanguageDetails();
      }
      else if ( cancelButtonHaveBeenClicked() ) {
         header( 'Location: ' . $_SERVER['PHP_SELF'] );
      }
      else if ( addNewLanguageButtonHaveBeenClicked() ) { 
         $markup .= 
            getMarkupToListNamesOfLanguagesWithEditAndDeleteButtons() .
            getMarkupForFormForAddingNewLanguage( sizeof( $idOfAllLanguagesSpoken ) );
      }
      else if ( doneButtonHaveBeenClicked() ) {
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


   function getMarkupForFormForAddingNewLanguage( $serialNumber )
   {
      return '
         <section class="languageEntry">
            <p class="languageNumber">LANGUAGE ' . ( $serialNumber + 1 ) . ': </p>
            ' . getMarkupForFormForEditingLanguageDetails( NULL, NEW_LANGUAGE ) . '
         </section>
      ';
   }


   function getMarkupToListNamesOfLanguagesWithEditAndDeleteButtons()
   {
      global $idOfAllLanguagesSpoken;

      $list = '';

      for ( $index = 0; $index < sizeof( $idOfAllLanguagesSpoken ); $index++ ) {
         $list .= '
         <section class="languageEntry">
            <p class="languageNumber">LANGUAGE ' . ( $index + 1 ) . ': </p>
            ' . getMarkupToShowNameOfLanguageWithEditAndDeleteButton( $idOfAllLanguagesSpoken[$index] ) . '
         </section>
         ';
      }

      return $list;
   }


   function getMarkupToSetOneLanguageToBeEdited( $idOfLanguageToBeEdited, 
      $idOfLanguageToBePreSelected, $defaultValueOfTextBox = NULL )
   {
      global $idOfAllLanguagesSpoken;

      $list = '';

      for ( $index = 0; $index < sizeof( $idOfAllLanguagesSpoken ); $index++ ) {

         if ( $idOfAllLanguagesSpoken[$index] ==  $idOfLanguageToBeEdited ) {
            $list .= '
         <section class="languageEntry">
            <p class="languageNumber">LANGUAGE ' . ( $index + 1 ) . ': </p>
            ' . getMarkupForFormForEditingLanguageDetails( $idOfLanguageToBePreSelected, 
                   $idOfLanguageToBeEdited, $defaultValueOfTextBox ) . '
         </section>
            ';
         }
         else {
            $list .= '
         <section class="languageEntry">
            <p class="languageNumber">LANGUAGE ' . ( $index + 1 ) . ': </p>
            ' . getMarkupToShowNameOfLanguageWithEditAndDeleteButton( $idOfAllLanguagesSpoken[$index] ) . '
         </section>
            ';
         }

      }

      if ( $idOfLanguageToBeEdited == NEW_LANGUAGE ) {
         $list .= '
         <section class="languageEntry">
            <p class="languageNumber">LANGUAGE ' . ( $index + 1 ) . ': </p>
            ' . getMarkupForFormForEditingLanguageDetails( $idOfLanguageToBePreSelected, 
                   $idOfLanguageToBeEdited, $defaultValueOfTextBox ) . '
         </section>
         ';
      }

      return $list;
   }


   function validateAndPossiblyUpdateLanguageDetails()
   {

      if ( userSelectedAnInvalidLanguage() ) {
         return getMarkupToSetOneLanguageToBeEdited( $_POST['idOfLanguageToBeEdited'], INVALID );
      }
      else if ( userSelectedTheNoneOfTheAboveOption() && 
         userHaveNotBeenShownTextBoxForSpecifyingNameOfHisLanguage() ) 
      {
         return getMarkupToSetOneLanguageToBeEdited( $_POST['idOfLanguageToBeEdited'], NONE_OF_THE_ABOVE );
      }
      else if ( userSelectedTheNoneOfTheAboveOption() && userDidNotSpecifyTheNameOfHisLanguage() ) {
         return getMarkupToSetOneLanguageToBeEdited( $_POST['idOfLanguageToBeEdited'], NAME_NOT_SPECIFIED );
      } 
      else {
         return checkIfSelectedLanguageIsAlreadySpokenByTheUserOrUpdateLanguageDetails();
      }
      
   }


   function userSelectedAnInvalidLanguage()
   {
      return $_POST['idOfSelectedLanguage'] == INVALID;
   }


   function userSelectedTheNoneOfTheAboveOption()
   {
      return $_POST['idOfSelectedLanguage'] == NONE_OF_THE_ABOVE;
   }


   function userHaveNotBeenShownTextBoxForSpecifyingNameOfHisLanguage()
   {
      return !isset( $_POST['nameOfNewLanguage'] );
   }


   function userDidNotSpecifyTheNameOfHisLanguage()
   {
      return $_POST['nameOfNewLanguage'] == '';
   }


   function checkIfSelectedLanguageIsAlreadySpokenByTheUserOrUpdateLanguageDetails()
   {
      if ( userHaveNotBeenShownTextBoxForSpecifyingNameOfHisLanguage() ) {
         $nameOfLanguage = NULL;
         $idOfLanguage = $_POST['idOfSelectedLanguage'];
      }
      else {
         $nameOfLanguage = $_POST['nameOfNewLanguage'];
         $idOfLanguage = insertIntoDatabaseLanguageEntryAndGetIdOfLanguageEntry( $_POST['nameOfNewLanguage'] );

         if ( languageEntryCouldNotBeInsertedIntoDatabase( $idOfLanguage ) ) {
            return 
               getMarkupToSetOneLanguageToBeEdited( $_POST['idOfLanguageToBeEdited'], 
                  $_POST['idOfSelectedLanguage'], $nameOfLanguage ) .
               getMarkupToIndicateThatNameOfNewLanguageIsInvalid();
         }

      }

      if ( isAlreadySpokenByTheUser( $idOfLanguage ) ) {
         return 
            getMarkupToSetOneLanguageToBeEdited( $_POST['idOfLanguageToBeEdited'], 
               $_POST['idOfSelectedLanguage'], $nameOfLanguage ) .
            getMarkupToIndicateThatLanguageWasRepeated( $idOfLanguage );
      }
      else {
         updateInDatabaseLanguageDetails( $idOfLanguage, $_POST['idOfLanguageToBeEdited'] );
         header( 'Location: ' . $_SERVER['PHP_SELF'] );
      }

   }


   function languageEntryCouldNotBeInsertedIntoDatabase( $idOfLanguage )
   {
      return $idOfLanguage == NULL;
   }


   function isAlreadySpokenByTheUser( $idOfLanguage )
   {
      global $idOfAllLanguagesSpoken;

      for ( $index = 0; $index < sizeof( $idOfAllLanguagesSpoken ) && 
         $idOfLanguage != $idOfAllLanguagesSpoken[$index]; $index++ )
         ;

      if ( $index < sizeof( $idOfAllLanguagesSpoken ) ) {
         return true;
      }
      else {
         return false;
      }

   }


   function getIndexOfLanguage( $idOfLanguage )
   {
      global $idOfAllLanguagesSpoken;

      for ( $index = 0; $index < sizeof( $idOfAllLanguagesSpoken ) && 
         $idOfLanguage != $idOfAllLanguagesSpoken[$index]; $index++ )
         ;

      return $index + 1;
   }
?>

<html>
   <head>
      <title>Edit Languages Spoken</title>
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