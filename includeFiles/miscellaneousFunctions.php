<?php
   include_once 'includeFiles/functionsForInsertingDataIntoDatabase.php';
   include_once 'includeFiles/functionsForDeletingDataFromDatabase.php';
   include_once 'includeFiles/booleanFunctions.php';


   /*
      TODO: I hope to improve this function to do more sophisticated capitalizations such as,
         capitalizing a name like 'dar es salaam' into 
         'Dar es Salaam' instead of 'Dar Es Salaam', e.t.c.
   */
   function capitalizeWordsThatShouldBeCapitalized( $requiredString )
   {
      $requiredString = strtolower( $requiredString );

      return ucwords( $requiredString );
   }


   function convertToNameOfMonth( $monthNumber )
   {
      $monthNames = array( 
         '', 
         'January', 
         'February', 
         'March', 
         'April', 
         'May', 
         'June', 
         'July', 
         'August', 
         'September', 
         'October', 
         'November', 
         'December'
      );

      if ( $monthNumber >= 1 && $monthNumber <= 12 ) {
         return $monthNames[$monthNumber];
      }
      else {
         return 'Error';
      }

   }


   function convertToPhoneNumberWithCountryCode( $phoneNumber, $countryCode = '+234' )
   {

      if ( $phoneNumber[0] == '0' ) {
         $phoneNumberWithCountryCode = $countryCode;

         for ( $index = 1; $index < strlen( $phoneNumber ); $index++ ) {
            $phoneNumberWithCountryCode .= $phoneNumber[$index];
         }

         return $phoneNumberWithCountryCode;
      }
      else {
         return $phoneNumber;
      }
   }


   function createNotificationToIndicateThatLoggedinUserHasAcceptedFriendRequestByRequiredUser( $idOfRequiredUser )
   {
      $namesOfLoggedInUser = retrieveFromDatabaseFirstNameLastNameAndNickName( $_SESSION['idOfLoggedInUser'] );
      $notificationText = 
         '<a href="profileOfUser.php?idOfRequiredUser=' . $_SESSION['idOfLoggedInUser'] . '">' . $namesOfLoggedInUser['first_name'] . ' ' . $namesOfLoggedInUser['last_name'] . '</a> accepted your friend request.';

      insertIntoDatabaseNotificationEntry( $notificationText, $idOfRequiredUser );
   }


   function createNotificationToIndicateThatLoggedInUserHasRejectedFriendRequestByRequiredUser( $idOfRequiredUser )
   {
      $namesOfLoggedInUser = retrieveFromDatabaseFirstNameLastNameAndNickName( $_SESSION['idOfLoggedInUser'] );
      $notificationText = 
         '<a href="profileOfUser.php?idOfRequiredUser=' . $_SESSION['idOfLoggedInUser'] . '">' . $namesOfLoggedInUser['first_name'] . ' ' . $namesOfLoggedInUser['last_name'] . '</a> rejected your friend request.';

      insertIntoDatabaseNotificationEntry( $notificationText, $idOfRequiredUser );
   }


   function createNotificationToIndicateThatLoggedInUserHasUnFriendedRequiredUser( $idOfRequiredUser )
   {
      $namesOfLoggedInUser = retrieveFromDatabaseFirstNameLastNameAndNickName( $_SESSION['idOfLoggedInUser'] );
      $notificationText = 
         '<a href="profileOfUser.php?idOfRequiredUser=' . $_SESSION['idOfLoggedInUser'] . '">' . $namesOfLoggedInUser['first_name'] . ' ' . $namesOfLoggedInUser['last_name'] . '</a> unfriended you.';

      insertIntoDatabaseNotificationEntry( $notificationText, $idOfRequiredUser );
   }


   function createNotificationsThatInformFriendsOfLoggedInUserThatAccountOfLoggedInUserHasBeenDeactivated()
   {
      $namesOfLoggedInUser = retrieveFromDatabaseFirstNameLastNameAndNickName( $_SESSION['idOfLoggedInUser'] );
      $notificationText = $namesOfLoggedInUser['first_name'] . ' ' . $namesOfLoggedInUser['last_name'] . ' account has been deactivated.';

      for ( $index = 0; $index < $_SESSION['totalNumberOfFriends']; $index++ ) {
         insertIntoDatabaseNotificationEntry( $notificationText, $_SESSION['idOfFriend' . $index] );
      }
   }


   function deactivateAccountOfLoggedInUser()
   {
      deleteFromDatabaseAllEntriesThatAssociateLoggedInUserWithLanguagesAsWellAsAnyRedundantLanguageEntries();
      deleteFromDatabaseAllEntriesThatAssociateLoggedInUserWithHisFriends();
      deleteFromDatabaseAllFriendRequestsSentToOrRecievedByLoggedInUser();
      deleteFromDatabaseAllStatusUpdatesPostedByLoggedInUserAsWellAsAnyRedundantCommentsAndLikes();
      deleteFromDatabaseAllCommentsByLoggedInUserToAnyStatusUpdate();
      deleteFromDatabaseAllEntriesThatIndicateThatLoggedInUserLikesAnyStatusUpdate();
      deleteFromDatabaseAllNotificationsMeantForLoggedInUser();
      deleteFromDatabaseEntryThatContainsInformationAboutUserAsWellAsAnyRedundantCityEntries();
      session_destroy();
   }


   function formatAboutMeDetails( $row )
   {
      return $row['about_me'];
   }


   function formatBirthdayDetails( $row )
   {
      $nameOfMonthOfBirth = convertToNameOfMonth( $row['month_of_birth'] );
      return $nameOfMonthOfBirth . ' ' . $row['day_of_birth'] . ', ' . $row['year_of_birth'];
   }


   function formatCityDetails( $row )
   {
      $capitalizedNameOfCity = capitalizeWordsThatShouldBeCapitalized( $row['name_of_city'] );
      $capitalizedNameOfCountry = capitalizeWordsThatShouldBeCapitalized( $row['name_of_country'] );
      return  $capitalizedNameOfCity . ', ' . $capitalizedNameOfCountry;
   }


   function formatFavouriteQuoteDetails( $row )
   {
      return '<q>' . $row['favourite_quotes'] . '</q>';
   }


   function formatGenderDetails( $row )
   {
      return capitalizeWordsThatShouldBeCapitalized( $row['name_of_gender'] );
   }


   function formatLanguageDetails( $arrayContainingNamesOfLanguages )
   {
      $INDEX_OF_FIRST_LANGUAGE = 0;

      $formattedLanguageDetails = $arrayContainingNamesOfLanguages[$INDEX_OF_FIRST_LANGUAGE];

      if ( sizeof( $arrayContainingNamesOfLanguages ) > 1 ) {
         $INDEX_OF_LAST_LANGUAGE = sizeof( $arrayContainingNamesOfLanguages ) - 1;

         for ( $index = 1; $index < $INDEX_OF_LAST_LANGUAGE; $index++ ) {
            $formattedLanguageDetails .= ', ' . $arrayContainingNamesOfLanguages[$index];
         }

         $formattedLanguageDetails .= ' and ' . $arrayContainingNamesOfLanguages[$INDEX_OF_LAST_LANGUAGE];
      }

      return capitalizeWordsThatShouldBeCapitalized( $formattedLanguageDetails );
   }


   function formatPhoneNumberDetails( $row )
   {
      return $row['phone_number'];
   }


   function formatEmailAddressDetails( $row )
   {
      return $row['email_address'];
   }


   function formatTimeShowingAmOrPm( $hour, $minute )
   {
      $minuteWithPaddingZero = addPaddingZeroToTheLeftIfNecessary( $minute );

      if ( $hour < 12 ) {
         return $hour . ':' . $minuteWithPaddingZero . 'am';
      }
      else if ( $hour == 12 ) {

         if ( $minute == 0 ) {
            return $hour . ':' . $minuteWithPaddingZero . 'noon';
         }
         else {
            return $hour . ':' . $minuteWithPaddingZero . 'pm';
         }

      }
      else {
         return ( $hour - 12 ) . ':' . $minuteWithPaddingZero . 'pm';
      }

   }


   function addPaddingZeroToTheLeftIfNecessary( $integerValue )
   {

      if ( $integerValue >= 0 && $integerValue <= 9 ) {
         return '0' . $integerValue;
      }
      else {
         return (string)$integerValue;
      }

   }


   function getArrayContainingResultOfQuery( $resultOfQuery, $column )
   {
      $rowFromResultOfQuery = mysql_fetch_assoc( $resultOfQuery );

      if ( $rowFromResultOfQuery == false ) {
         return NULL;
      }

      while ( $rowFromResultOfQuery != false ) {
         $array[] = $rowFromResultOfQuery[$column];
         $rowFromResultOfQuery = mysql_fetch_assoc( $resultOfQuery );
      }

      return $array;
   }


   function getStartingIndexOfEmailProviderName( $email )
   {
      for ( $index = 0; $email[$index] != '@'; $index++ )
         ;

      return $index + 1;
   }


   function getStartingIndexOfEmailProviderExtension( $email, $startingIndexOfEmailProviderName )
   {
      for ( $index = $startingIndexOfEmailProviderName; $email[$index] != '.'; $index++ )
         ;

      return $index + 1;
   }
   

   function getIndexOfLanguage( $idOfLanguage )
   {
      $idOfLanguagesSpokenByUser = 
         retrieveFromDatabaseAndReturnInArrayIdOfAllLanguagesSpoken( $_SESSION['idOfLoggedInUser'] );

      for ( $index = 0;
         $index < sizeof( $idOfLanguagesSpokenByUser ) && $idOfLanguage != $idOfLanguagesSpokenByUser[$index];
         $index++ )
         ;

      return $index + 1;
   }


   function getIdOfAnyFriendOfLoggedInUserThatLikesThisStatusUpdate( $idOfStatusUpdate )
   {

      for ( $index = 0; $index < $_SESSION['totalNumberOfFriends']; $index++ ) {

         if ( userLikesStatusUpdate( $_SESSION['idOfFriend' . $index], $idOfStatusUpdate ) ) {
            return $_SESSION['idOfFriend' . $index];
         }

      }

      return NULL;
   }


   function getLanguageNumberToBeAssociatedWithNewLanguage()
   {
      $allLanguagesSpokenByLoggedInUser = 
         retrieveFromDatabaseAndReturnInArrayIdOfAllLanguagesSpoken( $_SESSION['idOfLoggedInUser'] );
      $languageNumber = sizeof( $allLanguagesSpokenByLoggedInUser ) + 1;
      return $languageNumber;
   }


   function getNumberOfRecommendedUsersFromTheSameHometownAsLoggedInUser()
   {
      $row = retrieveFromDatabaseIdOfHometown( $_SESSION['idOfLoggedInUser'] );
      $hometownOfLoggedInUser = $row['id_of_hometown'];

      if ( doesNotExistInDatabase( $hometownOfLoggedInUser ) ) {
         return 0;
      }

      $idOfUsers =  retrieveFromDatabaseAndReturnInArrayIdOfUsersAssociatedWithHometown( $hometownOfLoggedInUser );

      $counter = 0;
      for ( $index = 0; $index < sizeof( $idOfUsers ); $index++ ) {
         if ( userShouldBeRecommendedForFriendship( $idOfUsers[$index] ) ) {
            $counter++;
         }
      }

      return $counter;
   }


   function logTheUserIn( $userName )
   {
      $rowContainingUserId = retrieveFromDatabaseUserIdAssociatedWithUserName( $userName );
      $_SESSION['idOfLoggedInUser'] = $rowContainingUserId['user_id'];
   }


   function redirectToTheSourcePage()
   {
      if ( isset( $_POST['urlOfSourcePage'] ) ) {
         header( 'Location: '  .  $_POST['urlOfSourcePage'] );
      }
      else {
         header( 'Location: index.php' );
      }

   }


   function redirectToThePageContainingSignUpFormAndTellThePageAboutInvalidUserInputs()
   {
      header( 'Location: ' . $_POST['urlOfSourcePage'] . '?' . getInformationAboutInvalidUserInputs() );
   }


   function getInformationAboutInvalidUserInputs()
   {
      if ( userDidNotFillAllFieldsInTheSignUpForm() ) {
         $informationAboutInvalidUserInputs = 'requiredAction=showThatSignUpFormWasNotFilledCompletely';
      }
      else if ( userInputtedDifferentValuesForUserNameAndConfirmationOfUserName() ) {
         $informationAboutInvalidUserInputs = 'requiredAction=showThatUserNameIsDifferentFromConfirmationOfUserName';
      }
      else if ( userInputtedDifferentValuesForUserPasswordAndConfirmationOfUserPassword() ) {
         $informationAboutInvalidUserInputs = 
            'requiredAction=showThatUserPasswordIsDifferentFromConfirmationOfUserPassword';
      }
      else if ( userInputtedEmailAddressOrPhoneNumberOfAnotherIfeFacebookUser() ) {
         $informationAboutInvalidUserInputs = 'requiredAction=showThatUserNameAlreadyExists';
      }
      else if ( userInputtedAnInvalidFirstName() || userInputtedAnInvalidSurname() || userInputtedAnInvalidUserName() ) {
         $informationAboutInvalidUserInputs = 'requiredAction=showThatUserInputtedInvalidSignUpDetails';
      }

      $informationAboutInvalidUserInputs .= 
         '&firstName=' . $_POST['firstName'] . '&surname=' . $_POST['surname'] . 
         '&userName=' . $_POST['userName'] . '&confirmationOfUserName=' . $_POST['confirmationOfUserName'];

      if ( userPasswordOrConfirmationOfUserPasswordHaveNotBeenProvided() ) {
         $informationAboutInvalidUserInputs .= '&userPasswordOrConfirmationOfUserPasswordHaveNotBeenProvided';
      }

      return $informationAboutInvalidUserInputs;
   }
?>