<?php
   include_once 'includeFiles/functionsForAccessingDatabase.php';
   include_once 'includeFiles/functionsForStoringDataIntoSESSION.php';
   include_once 'includeFiles/functionsForInsertingDataIntoDatabase.php';
   include_once 'includeFiles/miscellaneousFunctions.php';
   include_once 'includeFiles/usefulConstants.php';

   if ( !isset( $handleOfIfeFacebookDatabase ) ) {
      $handleOfIfeFacebookDatabase = connectToDatabase( 'ife_facebook_database' );
   }

   
   function updateInDatabaseBirthdayDetails()
   {
      global $handleOfIfeFacebookDatabase;

      $query = '
         UPDATE user_information
            SET date_of_birth = "' . (integer)$_POST["yearOfBirth"] . '-' . (integer)$_POST["monthOfBirth"]  . '-' . (integer)$_POST["dayOfBirth"] . '"
            WHERE user_id = ' . (integer)$_SESSION['idOfLoggedInUser'];

      sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
   }


   function updateInDatabaseCurrentCityDetails()
   {
      global $handleOfIfeFacebookDatabase;

      $idOfCity = insertIntoDatabaseCityEntryAndGetIdOfCityEntry( $_POST['nameOfCity'], $_POST['nameOfCountry'] );

      $query = '
         UPDATE user_information
            SET id_of_current_city = ' . (integer)$idOfCity . '
            WHERE user_id = ' . (integer)$_SESSION['idOfLoggedInUser'];

      sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
   }


   function updateInDatabaseHometownDetails()
   {
      global $handleOfIfeFacebookDatabase;

      $idOfCity = insertIntoDatabaseCityEntryAndGetIdOfCityEntry( $_POST['nameOfCity'], $_POST['nameOfCountry'] );

      $query = '
         UPDATE user_information
            SET id_of_hometown = ' . (integer)$idOfCity . '
            WHERE user_id = ' . (integer)$_SESSION['idOfLoggedInUser'];

      sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
   }


   function updateInDatabaseGenderDetails()
   {
      global $handleOfIfeFacebookDatabase;

      if ( doesNotConsistOfAlphabetsOnly( $_POST['genderDetails'] ) ) {
         return;
      }

      $rowContainingGenderId = retrieveFromDatabaseGenderIdAssociatedWithNameOfGender( $_POST['genderDetails'] );

      $query = '
         UPDATE user_information
            SET id_of_gender = "' . (integer)$rowContainingGenderId['gender_id'] . '"
            WHERE user_id = ' . (integer)$_SESSION["idOfLoggedInUser"];

      sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
   }


   function updateInDatabaseLanguageDetails( $idOfNewLanguage, $idOfLanguageToBeUpdated )
   {
      global $handleOfIfeFacebookDatabase;

      if ( $idOfNewLanguage == NONE_OF_THE_ABOVE ) {
         $idOfNewLanguage = insertIntoDatabaseLanguageEntryAndGetIdOfLanguageEntry( $_POST['nameOfNewLanguage'] );
      }

      if ( $idOfLanguageToBeUpdated == NEW_LANGUAGE ) {
         $query = '
            INSERT INTO user_and_language ( id_of_user, id_of_language )
               VALUES ( ' . (integer)$_SESSION['idOfLoggedInUser'] . ', ' . (integer)$idOfNewLanguage . ' )';
      }
      else {
         $query = '
            UPDATE user_and_language
               SET id_of_language = ' . (integer)$idOfNewLanguage . '
               WHERE id_of_language = ' . (integer)$idOfLanguageToBeUpdated . '
               AND id_of_user = '  .  (integer)$_SESSION['idOfLoggedInUser'];
      }

      sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
   }


   function updateInDatabaseFavouriteQuoteDetails()
   {
      global $handleOfIfeFacebookDatabase;

      $safeFavouriteQuotes = mysql_real_escape_string( $_POST['favouriteQuotes'] );

      $query = '
         UPDATE user_information
            SET favourite_quotes = "' . $safeFavouriteQuotes . '"
            WHERE user_id = ' . (integer)$_SESSION['idOfLoggedInUser'];

      sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
   }


   function updateInDatabaseAboutMeDetails()
   {
      global $handleOfIfeFacebookDatabase;

      $safeAboutMeDetails = mysql_real_escape_string( $_POST['aboutMe'] );

      $query = '
         UPDATE user_information
            SET about_me = "' . $safeAboutMeDetails . '"
            WHERE user_id = ' . (integer)$_SESSION['idOfLoggedInUser'];

      sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
   }


   function updateInDatabasePhoneNumberDetails()
   {
      global $handleOfIfeFacebookDatabase;

      if ( isNotValidPhoneNumber( $_POST['phoneNumber'] ) ) {
         return INVALID_PHONE_NUMBER;
      }

      $query = '
         UPDATE user_information
            SET phone_number = "' . convertToPhoneNumberWithCountryCode( $_POST['phoneNumber'] ) . '"
            WHERE user_id = ' . (integer)$_SESSION['idOfLoggedInUser'];

      sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
      return SUCCESSFUL;
   }


   function updateInDatabaseEmailAddressDetails()
   {
      global $handleOfIfeFacebookDatabase;

      if ( isNotValidEmailAddress( $_POST['emailAddress'] ) ) {
         return INVALID_EMAIL_ADDRESS;
      }

      $query = '
         UPDATE user_information
            SET email_address = "' . strtolower( $_POST['emailAddress'] ) . '"
            WHERE user_id = ' . (integer)$_SESSION['idOfLoggedInUser'];

      sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
      return SUCCESSFUL;
   }


   function updateInDatabaseIncrementNumberOfLikesByOne( $idOfStatusUpdate )
   {
      global $handleOfIfeFacebookDatabase;

      $query = '
         UPDATE status_updates
            SET number_of_likes = number_of_likes + 1
            WHERE status_update_id = ' . (integer)$idOfStatusUpdate;

      sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
   }


   function updateInDatabaseDecrementNumberOfLikesByOne( $idOfStatusUpdate )
   {
      global $handleOfIfeFacebookDatabase;

      $query = '
         UPDATE status_updates
            SET number_of_likes = number_of_likes - 1
            WHERE status_update_id = ' . (integer)$idOfStatusUpdate;

      sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
   }


   function updateInDatabaseFirstNameLastNameAndNickNameOfLoggedInUser( $firstName, $lastName, $nickName )
   {
      global $handleOfIfeFacebookDatabase;

      if ( isNotValidUserName( $firstName ) || isNotValidUserName( $lastName ) || isNotValidUserName( $nickName ) ) {
         return UNSUCCESSFUL;
      }

      $query = '
         UPDATE user_information
            SET
               first_name = "' . mysql_real_escape_string( $firstName ) . '",
               last_name = "' . mysql_real_escape_string( $lastName ) . '", 
               nick_name = "' . mysql_real_escape_string( $nickName ) . '"
            WHERE user_id = ' . (integer)$_SESSION['idOfLoggedInUser'];

      sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
      storeIntoSESSIONFirstNameOfLoggedInUser();

      return SUCCESSFUL;
   }


   function updateInDatabasePasswordOfLoggedInUser( $password )
   {
      global $handleOfIfeFacebookDatabase;

      $query = '
         UPDATE user_information
            SET login_password = "' . mysql_real_escape_string( $password ) . '"
            WHERE user_id = ' . (integer)$_SESSION['idOfLoggedInUser'];

      sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
   }
?>