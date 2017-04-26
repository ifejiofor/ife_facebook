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


   function userHasNotClickedOnCancelButton()
   {
      return !userHasClickedOnCancelButton();
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


   function userHasNotClickedOnYesButton()
   {
      return !userHasClickedOnYesButton();
   }


   function userHasClickedOnYesButton()
   {
      return isset( $_POST['yesButton'] );
   }



   function userHasClickedOnSearchButton()
   {
      return isset( $_POST['searchButton'] ) || isset( $_GET['searchButton'] );
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


   function userHasClickedOnTheLinkForViewingMoreSearchResults()
   {
      return isset( $_GET['requiredAction'] ) && $_GET['requiredAction'] == 'viewMoreSearchResults';
   }


   function userHasClickedOnTheLinkForViewingPreviousSearchResults()
   {
      return isset( $_GET['requiredAction'] ) && $_GET['requiredAction'] == 'viewPreviousSearchResults';
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


   function userNeedsToViewSearchResults()
   {
      return
         userHasClickedOnSearchButton() || 
         userHasClickedOnTheLinkForViewingPreviousSearchResults() || 
         userHasClickedOnTheLinkForViewingMoreSearchResults();
   }


   function userInputtedValidSearchQuery()
   {
      return !userDidNotInputValidSearchQuery();
   }


   function userDidNotInputValidSearchQuery()
   {
      $token = strtok( $_GET['searchQuery'], ' ' );

      if ( $token == false ) {
         return true;
      }

      while ( $token != false && isValidUserName( $token ) ) {
         $token = strtok( ' ' );
      }

      return $token != false;
   }


   function isValidEmailAddress( $email )
   {
      return !isNotValidEmailAddress( $email );
   }


   /*
      This function considers only strings of the format "someone@example.com" as valid emails.
      Any other string format is considered invalid (including the format "someone@example.com.ng").

      TODO: I hope to improve this function to also start considering the format "someone@example.com.ng" as valid.
   */
   function isNotValidEmailAddress( $email )
   {
      if ( emailIdentifierIsNotValid( $email ) ) {
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


   function emailIdentifierIsNotValid( $email )
   {

      for ( $index = 0; $index < strlen( $email ) && $email[$index] != '@' && 
         isValidEmailIdentifierCharacter( $email[$index] ); $index++ )
         ;

      if ( $index == strlen( $email ) ) {
         return true;
      }

      if ( $email[$index] == '@' ) {
         return $index == 0;
      }

      if ( !isValidEmailIdentifierCharacter( $email[$index] ) ) {
         return true;
      }

   }


   function isValidEmailIdentifierCharacter( $char )
   {
      return  isAlpha( $char ) || isDigit( $char ) || 
         isSpecialCharacterAllowedInEmailIdentifier( $char );
   }


   function emailProviderNameIsNotValid( $email, $startingIndexOfEmailProviderName )
   {

      for ( $index = $startingIndexOfEmailProviderName;
         $index < strlen( $email ) && $email[$index] != '.' && isAlpha( $email[$index] ); $index++ )
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
      for ( $index = $startingIndexOfEmailProviderExtension;
         $index < strlen( $email ) && isAlpha( $email[$index] ); $index++ )
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


   function doesNotConsistOfSpacesOnly( $string )
   {
      return !consistsOfSpacesOnly( $string );
   }


   function consistsOfSpacesOnly( $string )
   {
      if ( $string === NULL ) {
         return false;
      }

      for ( $index = 0; $index < strlen( $string ); $index++ ) {

         if ( $string[$index] != ' ' ) {
            break;
         }
      }

      return $index == strlen( $string );
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


   function isSpecialCharacterAllowedInEmailIdentifier( $char )
   {
      return $char == '.' || $char == '_';
   }


   function isSpecialCharacterAllowedInOrdinaryUserName( $char )
   {
      return $char == '\'' || $char == '-';
   }


   function areFriendsOfEachOther( $idOfFirstUser, $idOfSecondUser )
   {
      $entryThatIndicatesFriendship = 
         retrieveFromDatabaseEntryThatIndicatesThatUsersAreFriendsOfEachOther( $idOfFirstUser, $idOfSecondUser );

      return existsInDatabase( $entryThatIndicatesFriendship );
   }


   function userHasNoPendingFriendRequest()
   {
      return !userHasAtLeastOnePendingFriendRequest();
   }


   function userHasAtLeastOnePendingFriendRequest()
   {
      $friendRequests = 
         retrieveFromDatabaseAndReturnInArrayIdOfAllUsersWhoseFriendRequestsHaveNotBeenAcceptedByLoggedInUser();

      return existsInDatabase( $friendRequests );
   }


   function friendRequestSentByLoggedInUserHasNotYetBeenAcceptedByRequiredUser( $idOfUser )
   {
      $friendRequest = 
         retrieveFromDatabaseEntryThatIndicatesThatFriendRequestSentByLoggedInUserHasNotYetBeenAcceptedByRequiredUser( $idOfUser );

      return existsInDatabase( $friendRequest );
   }


   function loggedInUserHasNotYetAcceptedFriendRequestByRequiredUser( $idOfUser )
   {
      $friendRequest = 
         retrieveFromDatabaseEntryThatIndicatesThatLoggedInUserHasNotYetAcceptedFriendRequestByRequiredUser( $idOfUser );

      return existsInDatabase( $friendRequest );
   }


   function userDidNotFillTheLoginForm()
   {
      return !isset( $_POST['userName'] ) || $_POST['userName'] == '' || 
         !isset( $_POST['userPassword'] ) || $_POST['userPassword'] == '' ||
         !isset( $_POST['loginButton'] );
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
      return $_POST['aboutMe'] == '' || consistsOfSpacesOnly( $_POST['aboutMe'] );
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


   function isValidCalenderDate( $day, $month, $year )
   {
      if ( $year < EARLIEST_YEAR || $year > CURRENT_YEAR ) {
         return false;
      }

      if ( $month < JANUARY || $month > DECEMBER ) {
         return false;
      }

      if ( $day < 1 ) {
         return false;
      }

      if ( consistsOfThirtyDays( $month ) && $day > 30 ) {
         return false;
      }

      if ( consistsOfThirtyOneDays( $month ) && $day > 31 ) {
         return false;
      }

      if ( $month == FEBRUARY && isLeapYear( $year ) && $day > 29 ) {
         return false;
      }

      if ( $month == FEBRUARY && isNotLeapYear( $year ) && $day > 28 ) {
         return false;
      }

      return true;
   }


   function consistsOfThirtyDays( $month )
   {
      return $month == SEPTEMBER || $month == APRIL || $month == JUNE || $month == NOVEMBER;
   }


   function consistsOfThirtyOneDays( $month )
   {
      return !consistsOfThirtyDays( $month ) && $month != FEBRUARY;
   }


   function isNotLeapYear( $year )
   {
      return !isLeapYear( $year );
   }


   function isLeapYear( $year )
   {
      if ( $year % 4 != 0 ) {
         return false;
      }

      if ( $year % 100 != 0 ) {
         return true;
      }
      else if ( $year % 100 == 0 && $year % 400 == 0 ) {
         return true;
      }
      else {
         return false;
      }

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
      return $_POST['nameOfCity'] == '' || consistsOfSpacesOnly( $_POST['nameOfCity'] );
   }


   function userDidNotInputNameOfCountry()
   {
      return $_POST['nameOfCountry'] == '' || consistsOfSpacesOnly( $_POST['nameOfCountry'] );
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
      return $_POST['favouriteQuotes'] != '' || consistsOfSpacesOnly( $_POST['favouriteQuotes'] );
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

      if ( $idOfSelectedLanguage == $_POST['idOfLanguageToBeEdited'] ) {
         return false;
      }


      return alreadyExistsInDatabaseAsLanguageSpokenByLoggedInUser( $idOfSelectedLanguage );
   }


   function alreadyExistsInDatabaseAsLanguageSpokenByLoggedInUser( $idOfLanguage )
   {
      $idOfLanguagesSpokenByUser = 
         retrieveFromDatabaseAndReturnInArrayIdOfAllLanguagesSpoken( $_SESSION['idOfLoggedInUser'] );

      for ( $index = 0; $index < sizeof( $idOfLanguagesSpokenByUser ); $index++ ) {

         if ( $idOfLanguagesSpokenByUser[$index] == $idOfLanguage ) {
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


   function atLeastOneMoreStatusUpdateThatWasPostedByLoggedInUserOrHisFriendsExistsInDatabase()
   {
      $nextRelevantStatusUpdate = retrieveFromDatabaseAndReturnInArrayIdOfSomeStatusUpdatesThatWerePostedByLoggedInUserOrHisFriends(
         $_SESSION['totalNumberOfStatusUpdatesDisplayedSoFar'], 1 );
      return existsInDatabase( $nextRelevantStatusUpdate );
   }


   function atLeastOneMoreStatusUpdateThatWasPostedByUserExistsInDatabase( $idOfUser )
   {
      $nextRelevantStatusUpdate = retrieveFromDatabaseAndReturnInArrayIdOfSomeStatusUpdatesThatWerePostedByUser(
         $idOfUser, $_SESSION['totalNumberOfStatusUpdatesDisplayedSoFar'], 1 );
      return existsInDatabase( $nextRelevantStatusUpdate );
   }


   function atLeastOneMoreSearchResultExistsInDatabase()
   {
      $nextSearchResult = rerieveFromDatabaseAndReturnInArrayIdOfUsersWhoseNamesMatchSearchQuery( 
         $_GET['searchQuery'], $_SESSION['totalNumberOfSearchResultsDisplayedSoFar'], 1 );

      return existsInDatabase( $nextSearchResult );
   }


   function moreUsersAreToBeRecommendedForFriendship()
   {
      $row = retrieveFromDatabaseIdOfHometown( $_SESSION['idOfLoggedInUser'] );

      if ( doesNotExistInDatabase( $row['id_of_hometown'] ) ) {
         return true;
      }

      $idOfUsersFromTheSameHometown = 
         retrieveFromDatabaseAndReturnInArrayIdOfUsersAssociatedWithHometown( $row['id_of_hometown'] );

      return sizeof( $idOfUsersFromTheSameHometown ) < MAX_NUMBER_OF_USERS_TO_RECOMMEND;
   }


   function userIsNotFromTheSameHometownAsLoggedInUser( $idOfUser )
   {
      $hometownOfUser = retrieveFromDatabaseIdOfHometown( $idOfUser );
      $hometownOfLoggedInUser = retrieveFromDatabaseIdOfHometown( $_SESSION['idOfLoggedInUser'] );

      return $hometownOfUser['id_of_hometown'] != $hometownOfLoggedInUser['id_of_hometown'];
   }


   function userShouldBeRecommendedForFriendship( $idOfRequiredUser )
   {
      return !userShouldNotBeRecommendedForFriendship( $idOfRequiredUser );
   }


   function userShouldNotBeRecommendedForFriendship( $idOfRequiredUser )
   {
      return 
         $_SESSION['idOfLoggedInUser'] == $idOfRequiredUser ||
         areFriendsOfEachOther( $_SESSION['idOfLoggedInUser'], $idOfRequiredUser ) ||
         friendRequestSentByLoggedInUserHasNotYetBeenAcceptedByRequiredUser( $idOfRequiredUser ) ||
         loggedInUserHasNotYetAcceptedFriendRequestByRequiredUser( $idOfRequiredUser );
   }
?>