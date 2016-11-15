<?php
   include_once 'includeFiles/functionsForInteractingWithDatabase.php';
   include_once 'includeFiles/miscellaneousFunctions.php';

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

      $safeNameOfCity = mysql_real_escape_string( $_POST['nameOfCity'] );
      $safeNameOfCountry = mysql_real_escape_string( $_POST['nameOfCountry'] );

      $query = '
         SELECT city_id FROM cities
            WHERE name_of_city = "'  .  strtolower( $safeNameOfCity )  . '"
            AND name_of_country = "' . strtolower( $safeNameOfCountry )  . '"';

      $resultOfQuery = sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
      $rowFromResultOfQuery = mysql_fetch_assoc( $resultOfQuery );

      if ( $rowFromResultOfQuery != false ) {
         $idOfCity = $rowFromResultOfQuery['city_id'];
      }
      else {
         $query = '
            INSERT INTO cities ( name_of_city, name_of_country )
               VALUES ( "' . strtolower( $safeNameOfCity ) . '", "' . strtolower( $safeNameOfCountry ) . '" )';

         sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
         $idOfCity = mysql_insert_id( $handleOfIfeFacebookDatabase );
      }

      $query = '
         UPDATE user_information
            SET id_of_current_city = ' . (integer)$idOfCity . '
            WHERE user_id = ' . (integer)$_SESSION['idOfLoggedInUser'];

      sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
   }


   function updateInDatabaseHometownDetails()
   {
      global $handleOfIfeFacebookDatabase;

      $safeNameOfCity = mysql_real_escape_string( $_POST['nameOfCity'] );
      $safeNameOfCountry = mysql_real_escape_string( $_POST['nameOfCountry'] );

      $query = '
         SELECT city_id FROM cities
            WHERE name_of_city = "'  .  strtolower( $safeNameOfCity )  . '"
            AND name_of_country = "' . strtolower( $safeNameOfCountry )  . '"';

      $resultOfQuery = sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
      $rowFromResultOfQuery = mysql_fetch_assoc( $resultOfQuery );

      if ( $rowFromResultOfQuery != false ) {
         $idOfCity = $rowFromResultOfQuery['city_id'];
      }
      else {
         $query = '
            INSERT INTO cities ( name_of_city, name_of_country )
               VALUES ( "' . strtolower( $safeNameOfCity ) . '", "' . strtolower( $safeNameOfCountry ) . '" )';

         sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
         $idOfCity = mysql_insert_id( $handleOfIfeFacebookDatabase );
      }

      $query = '
         UPDATE user_information
            SET id_of_hometown = ' . (integer)$idOfCity . '
            WHERE user_id = ' . (integer)$_SESSION['idOfLoggedInUser'];

      sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
   }


   function updateInDatabaseGenderDetails()
   {
      global $handleOfIfeFacebookDatabase;


      if ( doesNotContainAlphabetsOnly( $_POST['genderDetails'] ) ) {
         return;
      }

      $query = '
         SELECT gender_id FROM genders
            WHERE name_of_gender = "' . $_POST['genderDetails'] . '"';

      $resultOfQuery = sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
      $rowFromResultOfQuery = mysql_fetch_assoc( $resultOfQuery );

      $query = '
         UPDATE user_information
            SET id_of_gender = "' . (integer)$rowFromResultOfQuery['gender_id'] . '"
            WHERE user_id = ' . (integer)$_SESSION["idOfLoggedInUser"];

      sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
   }


   function updateInDatabaseLanguageDetails( $idOfNewLanguage, $idOfLanguageToBeUpdated )
   {
      global $handleOfIfeFacebookDatabase;

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
?>