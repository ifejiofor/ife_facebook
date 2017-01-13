<?php
   include_once 'includeFiles/miscellaneousFunctions.php';
   include_once 'includeFiles/usefulConstants.php';
   include_once 'includeFiles/functionsForRetrievingDataFromDatabase.php';


   function userHasNotClickedOnAnyButton()
   {
      return !$_POST;
   }


   function userHasNotClickedOnAnyLink()
   {
      return !$_GET;
   }


   function userHasClickedOnLogOutButton()
   {
      return isset( $_POST['logOutButton'] );
   }


   function userHasClickedOnSaveButton()
   {
      return isset( $_POST['saveButton'] );
   }


   function userHasClickedOnCancelButton()
   {
      return isset( $_POST['cancelButton'] );
   }


   function userHasClickedOnEditLanguageButton()
   {
      return isset( $_POST['editLanguageButton'] );
   }


   function userHasClickedOnDeleteLanguageButton()
   {
      return isset( $_POST['deleteLanguageButton'] );
   }


   function userHasClickedOnAddNewLanguageButton()
   {
      return isset( $_POST['addNewLanguageButton'] );
   }


   function userHasClickedOnDoneButton()
   {
      return isset( $_POST['doneButton'] );
   }


   function userHasClickedOnYesButton()
   {
      return isset( $_POST['yesButton'] );
   }


   function userHasClickedOnTheLinkForViewingComments()
   {
      return isset( $_GET['requiredAction'] ) && $_GET['requiredAction'] == 'viewComments';
   }


   function userHasClickedOnTheLinkForHidingComments()
   {
      return isset( $_GET['requiredAction'] ) && $_GET['requiredAction'] == 'hideComments';
   }


   function userHasClickedOnTheLinkForViewingMoreStatusUpdates()
   {
      return isset( $_GET['requiredAction'] ) && $_GET['requiredAction'] == 'viewMoreStatusUpdates';
   }


   function userHasClickedOnTheLinkForViewingNamesOfLikers()
   {
      return isset( $_GET['requiredAction'] ) && $_GET['requiredAction'] == 'viewNamesOfLikers';
   }


   function userHasClickedOnTheLinkForHidingNamesOfLikers()
   {
      return isset( $_GET['requiredAction'] ) && $_GET['requiredAction'] == 'hideNamesOfLikers';
   }


   function userHaveClickedOnTheLikeButton()
   {
      return isset( $_POST['likeButton'] );
   }


   function userHaveClickedOnTheUnlikeButton()
   {
      return isset( $_POST['unlikeButton'] );
   }


   function userIsLoggedIn()
   {
      return isset( $_SESSION['idOfLoggedInUser'] );
   }


   function userIsNotLoggedIn()
   {
      return !userIsLoggedIn();
   }


   function doesNotExistInDatabase( $valueRetrievedFromDatabase )
   {
      return !existsInDatabase( $valueRetrievedFromDatabase );
   }


   function existsInDatabase( $valueRetrievedFromDatabase )
   {
      return $valueRetrievedFromDatabase != NULL && $valueRetrievedFromDatabase != false;
   }


   function isValidEmailAddress( $email )
   {
      return !isNotValidEmailAddress( $email );
   }


   function isNotValidEmailAddress( $email )
   {
      if ( emailUserNameIsNotValid( $email ) ) {
         return true;
      }

      $startingIndexOfEmailProviderName = getStartingIndexOfEmailProviderName( $email );

      if ( emailProviderNameIsNotValid( $email, $startingIndexOfEmailProviderName ) ) {
         return true;
      }

      $startingIndexOfEmailProviderExtension = 
         getStartingIndexOfEmailProviderExtension( $email, $startingIndexOfEmailProviderName );

      if ( emailProviderExtensionIsNotValid( $email, $startingIndexOfEmailProviderExtension ) ) {
         return true;
      }

      return false;
   }


   function emailUserNameIsNotValid( $email )
   {

      for ( $index = 0; $index < strlen( $email ) && $email[$index] != '@' && 
         isValidEmailUserNameCharacter( $email[$index] ); $index++ )
         ;

      if ( $index == strlen( $email ) ) {
         return true;
      }

      if ( $email[$index] == '@' ) {
         return $index == 0;
      }

      if ( !isValidEmailUserNameCharacter( $email[$index] ) ) {
         return true;
      }

   }


   function isValidEmailUserNameCharacter( $char )
   {
      return  isAlpha( $char ) || isDigit( $char ) || 
         isSpecialCharacterAllowedInEmailUserName( $char );
   }


   function emailProviderNameIsNotValid( $email, $startingIndexOfEmailProviderName )
   {

      for ( $index = $startingIndexOfEmailProviderName; $index < strlen( $email ) && 
         $email[$index] != '.' && isAlpha( $email[$index] ); $index++ )
         ;

      if ( $index == strlen( $email ) ) {
         return true;
      }

      if ( $email[$index] == '.' ) {
         return $index == $startingIndexOfEmailProviderName;
      }

      if ( !isAlpha( $email[$index] ) ) {
         return true;
      }

   }


   function emailProviderExtensionIsNotValid( $email, $startingIndexOfEmailProviderExtension )
   {
      for ( $index = $startingIndexOfEmailProviderExtension; $index < strlen( $email ) && 
         isAlpha( $email[$index] ) ; $index++ )
         ;

      if ( $index == strlen( $email ) ) {
         return $index == $startingIndexOfEmailProviderExtension;
      }

      if ( !isAlpha( $email[$index] ) ) {
         return true;
      }

   }


   function isNotValidPhoneNumber( $phoneNumber )
   {
      return !isValidPhoneNumber( $phoneNumber );
   }


   function isValidPhoneNumber( $phoneNumber )
   {
      if ( $phoneNumber[0] != '+' && $phoneNumber[0] != '0' ) {
         return false;
      }

      if ( $phoneNumber[0] == '+' && strlen( $phoneNumber ) != 14 ) {
         return false;
      }

      if ( $phoneNumber[0] == '0' && strlen( $phoneNumber ) != 11 ) {
         return false;
      }

      for ( $index = 1; $index < strlen( $phoneNumber ) && isDigit( $phoneNumber[$index] ); $index++ )
         ;

      if ( $index == strlen( $phoneNumber ) ) {
         return true;
      }

      if ( !isDigit( $phoneNumber[$index] ) ) {
         return false;
      }

   }


   function isNotValidUserName( $string )
   {
      return !isValidUserName( $string );
   }


   function isValidUserName( $string )
   {
      for ( $index = 0; $index < strlen( $string ); $index++ ) {

         if ( !isAlpha( $string[$index] ) &&  !isSpecialCharacterAllowedInOrdinaryUserName( $string[$index] ) ) {
            break;
         }

      }

      if ( $index == strlen( $string ) ) {
         return true;
      }

      if ( !isAlpha( $string[$index] ) &&  !isSpecialCharacterAllowedInOrdinaryUserName( $string[$index] ) ) {
         return false;
      }

   }


   function doesNotConsistOfAlphabetsAndSpacesOnly( $string )
   {
      return !consistsOfAlphabetsAndSpacesOnly( $string );
   }


   function consistsOfAlphabetsAndSpacesOnly( $string )
   {
      $atLeastOneAlphabetExists = false;

      for ( $index = 0; $index < strlen( $string ); $index++ ) {

         if ( !isAlpha( $string[$index] ) && $string[$index] != ' ' ) {
            break;
         }

         if ( isAlpha( $string[$index] ) ) {
            $atLeastOneAlphabetExists = true;
         }

      }

      if ( $index == strlen( $string ) ) {
         return $atLeastOneAlphabetExists;
      }

      if ( !isAlpha( $string[$index] ) && $string[$index] != ' ' ) {
         return false;
      }

   }


   function doesNotConsistOfAlphabetsOnly( $string )
   {
      return !consistsOfAlphabetsOnly( $string );
   }


   function consistsOfAlphabetsOnly( $string )
   {
      for ( $index = 0; $index < strlen( $string ); $index++ ) {

         if ( !isAlpha( $string[$index] ) ) {
            break;
         }

      }

      if ( $index == strlen( $string ) ) {
         return true;
      }

      if ( !isAlpha( $string[$index] ) ) {
         return false;
      }

   }


   function isAlpha( $char )
   {
      $char = strtolower( $char );

      return $char == 'a' || $char == 'b'|| $char == 'c' || $char == 'd' || $char == 'e' || $char == 'f'
         || $char == 'g' || $char == 'h'|| $char == 'i'|| $char == 'j'|| $char == 'k'|| $char == 'l'
         || $char == 'm'|| $char == 'n'|| $char == 'o'|| $char == 'p'|| $char == 'q'|| $char == 'r'
         || $char == 's'|| $char == 't'|| $char == 'u'|| $char == 'v'|| $char == 'w'|| $char == 'x'
         || $char == 'y'|| $char == 'z';
   }


   function isDigit( $char )
   {
      return $char == '0' || $char == '1' || $char == '2' || $char == '3' || $char == '4' || 
         $char == '5' || $char == '6' || $char == '7' || $char == '8' || $char == '9';
   }


   function isSpecialCharacterAllowedInEmailUserName( $char )
   {
      return $char == '.' || $char == '_';
   }


   function isSpecialCharacterAllowedInOrdinaryUserName( $char )
   {
      return $char == '\'' || $char == '-';
   }


   function userInputtedCorrectLoginDetails()
   {
      return !userDidNotInputCorrectLoginDetails();
   }


   function userDidNotInputCorrectLoginDetails()
   {
      return userInputtedIncorrectUserName() || userInputtedIncorrectPassword();
   }


   function userInputtedIncorrectUserName()
   {
      $row = retrieveFromDatabaseLoginPasswordAssociatedWithUserName( $_POST['userName'] );
      return doesNotExistInDatabase( $row );
   }


   function userInputtedIncorrectPassword()
   {
      $row = retrieveFromDatabaseLoginPasswordAssociatedWithUserName( $_POST['userName'] );
      return $row['login_password'] != $_POST['userPassword'];
   }


   function signUpFormHaveNotBeenShownToTheUser()
   {
      return !signUpFormHaveBeenShownToTheUser();
   }


   function signUpFormHaveBeenShownToTheUser()
   {
      return isset( $_POST['signUpButton'] );
   }


   function userPasswordOrConfirmationOfUserPasswordHaveNotBeenProvided()
   {
      return $_POST['userPassword'] == '' || $_POST['confirmationOfUserPassword'] == '';
   }


   function userInputtedValidSignUpDetails()
   {
      return !userDidNotInputValidSignUpDetails();
   }


   function userDidNotInputValidSignUpDetails()
   {
      return
         userDidNotFillAllFieldsInTheSignUpForm() || 
         userInputtedDifferentValuesForUserNameAndConfirmationOfUserName() ||
         userInputtedDifferentValuesForUserPasswordAndConfirmationOfUserPassword() ||
         userInputtedEmailAddressOrPhoneNumberOfAnotherIfeFacebookUser() ||
         userInputtedAnInvalidFirstName() ||
         userInputtedAnInvalidSurname() ||
         userInputtedAnInvalidUserName();
   }


   function userDidNotFillAllFieldsInTheSignUpForm()
   {
      return
         $_POST['firstName'] == '' || $_POST['surname'] == '' || $_POST['userName'] == '' || 
         $_POST['confirmationOfUserName'] == '' || $_POST['userPassword'] == '' || 
         $_POST['confirmationOfUserPassword'] == '';
   }


   function userInputtedDifferentValuesForUserNameAndConfirmationOfUserName()
   {
      return $_POST['userName'] != $_POST['confirmationOfUserName'];
   }


   function userInputtedDifferentValuesForUserPasswordAndConfirmationOfUserPassword()
   {
      return $_POST['userPassword'] != $_POST['confirmationOfUserPassword'];
   }


   function userInputtedEmailAddressOrPhoneNumberOfAnotherIfeFacebookUser()
   {
      $anotherUserWithTheSameUserName = 
         retrieveFromDatabaseUserIdAssociatedWithEmailAddressOrPhoneNumber( $_POST['userName'] );

      return existsInDatabase( $anotherUserWithTheSameUserName );
   }


   function userInputtedAnInvalidFirstName()
   {
      return isNotValidUserName( $_POST['firstName'] );
   }


   function userInputtedAnInvalidSurname()
   {
      return isNotValidUserName( $_POST['surname'] );
   }


   function userInputtedAnInvalidUserName()
   {
      return isNotValidEmailAddress( $_POST['userName'] ) && isNotValidPhoneNumber( $_POST['userName'] );
   }


   function userInputtedValidAboutMeDetails()
   {
      return !userDidNotInputValidAboutMeDetails();
   }


   function userDidNotInputValidAboutMeDetails()
   {
      return $_POST['aboutMe'] == '';
   }


   function userSelectedValidBirthdayDetails()
   {
      return !userDidNotSelectValidBirthdayDetails();
   }


   function userDidNotSelectValidBirthdayDetails()
   {
      return userSelectedInvalidDayOfBirth() || userSelectedInvalidMonthOfBirth() || 
         userSelectedInvalidYearOfBirth() || theDateSelectedByTheUserIsNotACalenderDate();
   }


   function userSelectedInvalidDayOfBirth()
   {
      return $_POST['dayOfBirth'] == INVALID;
   }


   function userSelectedInvalidMonthOfBirth()
   {
      return $_POST['monthOfBirth'] == INVALID;
   }


   function userSelectedInvalidYearOfBirth()
   {
      return $_POST['yearOfBirth'] == INVALID;
   }


   function theDateSelectedByTheUserIsNotACalenderDate()
   {
      return !isValidCalenderDate( $_POST['dayOfBirth'], $_POST['monthOfBirth'], $_POST['yearOfBirth'] );
   }


   /*
      TODO: I'm yet to write the proper definition of this function. I hope to write it later whenever I'm chanced.
   */
   function isValidCalenderDate( $day, $month, $year ) {
      return true;
   }


   function userInputtedValidCityDetails()
   {
      return !userDidNotInputValidCityDetails();
   }


   function userDidNotInputValidCityDetails()
   {
      return userDidNotInputNameOfCity() || userDidNotInputNameOfCountry();
   }


   function userDidNotInputNameOfCity()
   {
      return $_POST['nameOfCity'] == '';
   }


   function userDidNotInputNameOfCountry()
   {
      return $_POST['nameOfCountry'] == '';
   }


   function userInputtedValidEmailAddress()
   {
      return !userDidNotInputValidEmailAddress();
   }


   function userDidNotInputValidEmailAddress()
   {

      if ( userDidNotInputEmailAddress() ) {
         return true;
      }

      if ( isNotValidEmailAddress( $_POST['emailAddress'] ) ) {
         return true;
      }

      $anotherUserWithTheSameEmailAddress = 
         retrieveFromDatabaseUserIdOfAnotherUserAssociatedWithEmailAddress( $_POST['emailAddress'] );

      if ( existsInDatabase( $anotherUserWithTheSameEmailAddress ) ) {
         return true;
      }

      return false;
   }


   function userDidNotInputEmailAddress()
   {
      return $_POST['emailAddress'] == '';
   }


   function userDidNotInputHisFavouriteQuotes()
   {
      return !userInputtedHisFavouriteQuotes();
   }


   function userInputtedHisFavouriteQuotes()
   {
      return $_POST['favouriteQuotes'] != '';
   }


   function userDidNotSelectValidGenderDetail()
   {
      return !userSelectedValidGenderDetail();
   }


   function userSelectedValidGenderDetail()
   {
      return isset( $_POST['genderDetails'] );
   }


   function userInputtedValidLanguageDetails()
   {
      return !userDidNotInputValidLanguageDetails();
   }


   function userDidNotInputValidLanguageDetails()
   {
      if ( userSelectedTheInvalidOption() ) {
         return true;
      }

      if ( userSelectedTheNoneOfTheAboveOption() && userDidNotSpecifyTheNameOfHisLanguage() ) {
         return true;
      }

      if ( userSelectedTheNoneOfTheAboveOption() && userSpecifiedInvalidNameOfLanguage() ) {
         return true;
      }

      if ( theSelectedLanguageAlreadyExistsInDatabaseAsLanguageSpokenByTheUser() ) {
         return true;
      }

      return false;
   }


   function userSelectedTheInvalidOption()
   {
      return $_POST['idOfSelectedLanguage'] == INVALID;
   }


   function userSelectedTheNoneOfTheAboveOption()
   {
      return $_POST['idOfSelectedLanguage'] == NONE_OF_THE_ABOVE;
   }


   function userDidNotSpecifyTheNameOfHisLanguage()
   {
      return $_POST['nameOfNewLanguage'] == '';
   }


   function userSpecifiedInvalidNameOfLanguage()
   {
      return !userSpecifiedValidNameOfLanguage();
   }


   function userSpecifiedValidNameOfLanguage()
   {
      return consistsOfAlphabetsAndSpacesOnly( $_POST['nameOfNewLanguage'] );
   }


   function theSelectedLanguageAlreadyExistsInDatabaseAsLanguageSpokenByTheUser()
   {
      if ( userSelectedTheNoneOfTheAboveOption() && userSpecifiedValidNameOfLanguage() ) {
         $row = retrieveFromDatabaseIdOfLanguageAssociatedWithNameOfLanguage( $_POST['nameOfNewLanguage'] );
         $idOfSelectedLanguage = $row['language_id'];
      }
      else {
         $idOfSelectedLanguage = $_POST['idOfSelectedLanguage'];
      }

      $idOfLanguagesSpokenByUser = 
         retrieveFromDatabaseAndReturnInArrayIdOfAllLanguagesSpoken( $_SESSION['idOfLoggedInUser'] );

      for ( $index = 0; $index < sizeof( $idOfLanguagesSpokenByUser ); $index++ ) {

         if ( $idOfLanguagesSpokenByUser[$index] == $idOfSelectedLanguage ) {
            break;
         }

      }

      return $index < sizeof( $idOfLanguagesSpokenByUser );
   }


   function userInputtedValidPasswordDetails()
   {
      return !userDidNotInputValidPasswordDetails();
   }


   function userDidNotInputValidPasswordDetails()
   {
      return userDidNotFillAllFieldsInTheEditPasswordForm() || userInputtedIncorrectCurrentPassword() || 
         userInputtedDifferentValuesForNewPasswordAndConfirmationOfNewPassword();
   }


   function userDidNotFillAllFieldsInTheEditPasswordForm()
   {
      return $_POST['currentPassword'] == '' || $_POST['newPassword'] == '' || 
         $_POST['confirmationOfNewPassword'] == '';
   }


   function userInputtedIncorrectCurrentPassword()
   {
      $row = retrieveFromDatabasePasswordOfLoggedInUser();
      return $row['login_password'] != $_POST['currentPassword'];
   }


   function userInputtedDifferentValuesForNewPasswordAndConfirmationOfNewPassword()
   {
      return $_POST['newPassword'] != $_POST['confirmationOfNewPassword'];
   }


   function userInputtedValidPhoneNumberDetails()
   {
      return !userDidNotInputValidPhoneNumberDetails();
   }


   function userDidNotInputValidPhoneNumberDetails()
   {
      return userDidNotInputHisPhoneNumber() || thePhoneNumberInputtedByUserIsInvalid() || 
         userInputtedThePhoneNumberOfAnotherIfeFacebookUser();
   }


   function userDidNotInputHisPhoneNumber()
   {
      return $_POST['phoneNumber'] == '';
   }


   function thePhoneNumberInputtedByUserIsInvalid()
   {
      return isNotValidPhoneNumber( $_POST['phoneNumber'] );
   }


   function userInputtedThePhoneNumberOfAnotherIfeFacebookUser()
   {
      $anotherUserWithTheSamePhoneNumber = 
         retrieveFromDatabaseUserIdOfAnotherUserAssociatedWithPhoneNumber( $_POST['phoneNumber'] );

      return existsInDatabase( $anotherUserWithTheSamePhoneNumber );
   }


   function userInputtedValidUserNames()
   {
      return !userDidNotInputValidUserNames();
   }


   function userDidNotInputValidUserNames()
   {
      return userDidNotInputFirstName() || userDidNotInputLastName() || oneOfTheUserNamesInputtedByUserIsInvalid();
   }


   function userDidNotInputFirstName()
   {
      return $_POST['firstName'] == '';
   }


   function userDidNotInputLastName()
   {
      return $_POST['lastName'] == '';
   }


   function oneOfTheUserNamesInputtedByUserIsInvalid()
   {
      return isNotValidUserName( $_POST['firstName'] ) || isNotValidUserName( $_POST['lastName'] ) || isNotValidUserName( $_POST['nickName'] );
   }


   function detailsAboutLanguagesSpokenByUserExistsInDatabase()
   {
      $idOfAllLanguagesSpokenByUser = 
         retrieveFromDatabaseAndReturnInArrayIdOfAllLanguagesSpoken( $_SESSION['idOfLoggedInUser'] );

      return existsInDatabase( $idOfAllLanguagesSpokenByUser );
   }


   function noDetailAboutLanguagesSpokenByUserExistsInDatabase()
   {
      return !detailsAboutLanguagesSpokenByUserExistsInDatabase();
   }


   function userNeedsToBeShownTextFieldForSpecifyingNameOfLanguage()
   {
      return userSelectedTheNoneOfTheAboveOption() && userHaveNotBeenShownTextFieldForSpecifyingNameOfHisLanguage();
   }


   function userDidNotSpecifyNameOfLanguageInATextBox()
   {
      return !userSpecifiedNameOfLanguageInATextBox();
   }


   function userSpecifiedNameOfLanguageInATextBox()
   {
      return userSelectedTheNoneOfTheAboveOption() && userSpecifiedValidNameOfLanguage();
   }


   function userHaveNotBeenShownTextFieldForSpecifyingNameOfHisLanguage()
   {
      return !isset( $_POST['nameOfNewLanguage'] );
   }


   function userLikesStatusUpdate( $idOfUser, $idOfStatusUpdate )
   {
      $entryIndicatingLike = retrieveFromDatabaseEntryThatIndicatesThatUserLikesStatusUpdate( 
         $idOfUser, $idOfStatusUpdate );

      return existsInDatabase( $entryIndicatingLike );
   }


   function loggedInUserHasFriendThatLikesThisStatusUpdate( $idOfStatusUpdate )
   {
      $idOfFriend = getIdOfAnyFriendOfLoggedInUserThatLikesThisStatusUpdate( $idOfStatusUpdate );
      return $idOfFriend != NULL;
   }


   function atLeastOneCommentOnThisStatusUpdateExistsInDatabase( $idOfStatusUpdate )
   {
      $comment = retrieveFromDatabaseAndReturnInArrayIdOfComments( $idOfStatusUpdate, 0, 1 );
      return existsInDatabase( $comment );
   }


   function atLeastOneOlderCommentOnThisStatusUpdateExistsInDatabase( $idOfStatusUpdate )
   {
      $olderComment = retrieveFromDatabaseAndReturnInArrayIdOfComments( 
         $idOfStatusUpdate, $_SESSION['totalNumberOfCommentsDisplayedSoFar'], 1 );
      return existsInDatabase( $olderComment );
   }


   function atLeastOneMoreLikerOfThisStatusUpdateExistsInDatabase( $idOfStatusUpdate )
   {
      $idOfNextLiker = retrieveFromDatabaseAndReturnInArrayIdOfLikers( 
        $idOfStatusUpdate, $_SESSION['totalNumberOfLikersDisplayedSoFar'], 1 );

      return existsInDatabase( $idOfNextLiker );
   }


   function atLeastOneMoreStatusUpdateExistsInDatabase()
   {
      $nextRelevantStatusUpdate = retrieveFromDatabaseAndReturnInArrayIdOfStatusUpdates(
         $_SESSION['totalNumberOfStatusUpdatesDisplayedSoFar'], 1 );
      return existsInDatabase( $nextRelevantStatusUpdate );
   }


   function detailsOfLanguageIsNotStoredInSESSION( $idOfRequiredLanguage )
   {
      return !detailsOfLanguageIsStoredInSESSION( $idOfRequiredLanguage );
   }


   function detailsOfLanguageIsStoredInSESSION( $idOfRequiredLanguage )
   {
      for ( $index = 0; $index < $_SESSION['totalNumberOfLanguages']; $index++ ) {

         if ( $_SESSION['idOfLanguage' . $index] == $idOfRequiredLanguage ) {
            break;
         }
      }

      return $index < $_SESSION['totalNumberOfLanguages'];
   }
?>