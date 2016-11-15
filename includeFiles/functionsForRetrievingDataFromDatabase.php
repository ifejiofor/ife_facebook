<?php
   include_once 'includeFiles/functionsForInteractingWithDatabase.php';
   include_once 'includeFiles/miscellaneousFunctions.php';
   include_once 'includeFiles/usefulConstants.php';

   if ( !isset( $handleOfIfeFacebookDatabase ) ) {
      $handleOfIfeFacebookDatabase = connectToDatabase( 'ife_facebook_database' );
   }


   function retrieveFromDatabaseUserIdAndLoginPassword()
   {
      global $handleOfIfeFacebookDatabase;

      if ( isNotValidEmailAddress( $_POST['userName'] ) && isNotValidPhoneNumber( $_POST['userName'] ) ) {
         return NULL;
      }

      if ( isValidPhoneNumber( $_POST['userName'] ) ) {
         $userName = convertToPhoneNumberWithCountryCode( $_POST['userName'] );
      }
      else {
         $userName = $_POST['userName'];
      }

      $query = 
         'SELECT user_id, login_password FROM user_information
            WHERE email_address = "'  .  $userName  .  '"
            OR phone_number = "'  .  $userName  .  '"';

      $resultOfQuery = sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
      $rowFromResultOfQuery = mysql_fetch_assoc( $resultOfQuery );

      return $rowFromResultOfQuery;
   }


   function retrieveFromDatabaseAndReturnInArrayIdOfStatusUpdates( $offset, $numberOfRows )
   {
      global $handleOfIfeFacebookDatabase;

      $query = createQueryForRetrievingIdOfStatusUpdates( $offset, $numberOfRows );

      $resultOfQuery = sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
      $rowFromResultOfQuery = mysql_fetch_assoc( $resultOfQuery );

      if ( $rowFromResultOfQuery == false ) {
         return NULL;
      }
      else {

         while ( $rowFromResultOfQuery != false ) {
            $idOfRelevantStatusUpdates[] = $rowFromResultOfQuery['status_update_id'];
            $rowFromResultOfQuery = mysql_fetch_assoc( $resultOfQuery );
         }

         return $idOfRelevantStatusUpdates;
      }

   }


   function createQueryForRetrievingIdOfStatusUpdates( $offset, $numberOfRows )
   {
      $query = '
         SELECT status_update_id FROM status_updates
            WHERE id_of_poster = ' . (integer)$_SESSION['idOfLoggedInUser'];

      for ( $index = 0; $index < $_SESSION['totalNumberOfFriends']; $index++ ) {
         $query .= ' OR id_of_poster = ' . (integer)$_SESSION['idOfFriend' . $index];
      }

      $query .= '
         ORDER BY time_of_posting DESC
         LIMIT ' . (integer)$offset . ', ' . (integer)$numberOfRows;

      return $query;
   }


   function retrieveFromDatabaseDetailsOfStatusUpdate( $idOfStatusUpdate )
   {
      global $handleOfIfeFacebookDatabase;

      $query = '
         SELECT status_update_id,
            status_update_text,
            id_of_poster,
            number_of_likes,
            MONTHNAME( time_of_posting ) AS month_of_posting,
            DAYOFMONTH( time_of_posting ) AS day_of_posting,
            HOUR( time_of_posting ) AS hour_of_posting,
            MINUTE( time_of_posting ) AS minute_of_posting
            FROM status_updates
            WHERE status_update_id = ' . (integer)$idOfStatusUpdate;

      $resultOfQuery = sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
      $rowFromResultOfQuery = mysql_fetch_assoc( $resultOfQuery );

      return $rowFromResultOfQuery;
   }


   function retrieveFromDatabaseAndReturnInArrayIdOfComments( $idOfStatusUpdate, 
      $offset = 0, $numberOfRows = DEFAULT_NUMBER_OF_ROWS_FOR_COMMENTS )
   {
      global $handleOfIfeFacebookDatabase;

      $query = '
         SELECT comment_id FROM comments
            WHERE id_of_status_update = ' . $idOfStatusUpdate . '
            ORDER BY time_of_commenting DESC
            LIMIT ' . (integer)$offset . ', ' . (integer)$numberOfRows;

      $resultOfQuery = sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
      $rowFromResultOfQuery = mysql_fetch_assoc( $resultOfQuery );

      if ( $rowFromResultOfQuery == false ) {
         return NULL;
      }
      else {

         while ( $rowFromResultOfQuery != false ) {
            $idOfAssociatedComments[] = $rowFromResultOfQuery['comment_id'];
            $rowFromResultOfQuery = mysql_fetch_assoc( $resultOfQuery );
         }

         return $idOfAssociatedComments;
      }

   }


   function retrieveFromDatabaseDetailsOfComment( $idOfComment )
   {
      global $handleOfIfeFacebookDatabase;

      $query = '
         SELECT
            comment_id, 
            comment_text, 
            id_of_commenter, 
            id_of_status_update, 
            MONTHNAME( time_of_commenting ) AS month_of_commenting,
            DAYOFMONTH( time_of_commenting ) AS day_of_commenting,
            HOUR( time_of_commenting ) AS hour_of_commenting,
            MINUTE( time_of_commenting ) AS minute_of_commenting
            FROM comments
            WHERE comment_id = ' . (integer)$idOfComment;

      $resultOfQuery = sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
      $rowFromResultOfQuery = mysql_fetch_assoc( $resultOfQuery );

      return $rowFromResultOfQuery;
   }


   function retrieveFromDatabaseFirstNameLastNameAndNickName( $idOfUser )
   {
      global $handleOfIfeFacebookDatabase;

      $query = '
         SELECT first_name, last_name, nick_name FROM user_information
            WHERE user_id = ' . (integer)$idOfUser;

      $resultOfQuery = sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
      $rowFromResultOfQuery = mysql_fetch_assoc( $resultOfQuery );

      return $rowFromResultOfQuery;
   }


   function retrieveFromDatabaseBirthdayDetails( $idOfUser )
   {
      global $handleOfIfeFacebookDatabase;

      $query = '
         SELECT DAYOFMONTH( date_of_birth ) AS day_of_birth,
            MONTH( date_of_birth ) AS month_of_birth,
            YEAR( date_of_birth ) AS year_of_birth
            FROM user_information
            WHERE user_id = ' . (integer)$idOfUser;

      $resultOfQuery = sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
      $rowFromResultOfQuery = mysql_fetch_assoc( $resultOfQuery );

      return $rowFromResultOfQuery;
   }


   function retrieveFromDatabaseAboutMeDetails( $idOfUser )
   {
      global $handleOfIfeFacebookDatabase;

      $query = '
         SELECT about_me FROM user_information
            WHERE user_id = '  .  (integer)$idOfUser;

      $resultOfQuery = sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
      $rowFromResultOfQuery = mysql_fetch_assoc( $resultOfQuery );

      return $rowFromResultOfQuery;
   }


   function retrieveFromDatabaseIdOfCurrentCity( $idOfUser )
   {
      global $handleOfIfeFacebookDatabase;

      $query = '
         SELECT id_of_current_city FROM user_information
            WHERE user_id = ' . (integer)$idOfUser;

      $resultOfQuery = sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
      $rowFromResultOfQuery = mysql_fetch_assoc( $resultOfQuery );

      return $rowFromResultOfQuery;
   }


   function retrieveFromDatabaseIdOfHometown( $idOfUser )
   {
      global $handleOfIfeFacebookDatabase;

      $query = '
            SELECT id_of_hometown FROM user_information
               WHERE user_id = '  .  (integer)$idOfUser;

      $resultOfQuery = sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
      $rowFromResultOfQuery = mysql_fetch_assoc( $resultOfQuery );

      return $rowFromResultOfQuery;
   }


   function retrieveFromDatabaseCityDetails( $cityId )
   {
      global $handleOfIfeFacebookDatabase;

      $query = '
         SELECT name_of_city, name_of_country FROM cities
            WHERE city_id = ' . (integer)$cityId;

      $resultOfQuery = sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
      $rowFromResultOfQuery = mysql_fetch_assoc( $resultOfQuery );

      return $rowFromResultOfQuery;
   }


   function retrieveFromDatabaseFavouriteQuoteDetails( $idOfUser )
   {
      global $handleOfIfeFacebookDatabase;

      $query = '
         SELECT favourite_quotes FROM user_information
            WHERE user_id = '  .  (integer)$idOfUser;

      $resultOfQuery = sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
      $rowFromResultOfQuery = mysql_fetch_assoc( $resultOfQuery );

      return $rowFromResultOfQuery;
   }


   function retrieveFromDatabaseIdOfGender( $idOfUser )
   {
      global $handleOfIfeFacebookDatabase;

      $query = '
         SELECT id_of_gender FROM user_information
            WHERE user_id = '  .  (integer)$idOfUser;

      $resultOfQuery = sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
      $rowFromResultOfQuery = mysql_fetch_assoc( $resultOfQuery );

      return $rowFromResultOfQuery;
   }


   function retrieveFromDatabaseGenderDetails( $genderID )
   {
      global $handleOfIfeFacebookDatabase;

      $query = '
            SELECT name_of_gender FROM genders
               WHERE gender_id = ' . (integer)$genderID;

      $resultOfQuery = sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
      $rowContainingResultOfQuery = mysql_fetch_assoc( $resultOfQuery );

      return $rowContainingResultOfQuery;
   }


   function retrieveFromDatabaseAndReturnInArrayIdOfAllLanguagesSpoken( $idOfUser )
   {
     global $handleOfIfeFacebookDatabase;

     $query = '
         SELECT id_of_language FROM user_and_language
            WHERE id_of_user = '  .  (integer)$idOfUser;

      $resultOfQuery = sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
      $rowFromResultOfQuery = mysql_fetch_assoc( $resultOfQuery );

      if ( $rowFromResultOfQuery == false ) {
         return NULL;
      }
      else {

         while ( $rowFromResultOfQuery != false ) {
            $idOfLanguages[] = $rowFromResultOfQuery['id_of_language'];
            $rowFromResultOfQuery = mysql_fetch_assoc( $resultOfQuery );
         }

         return $idOfLanguages;
      }

   }


   function retrieveFromDatabaseAndReturnInArrayNamesOfAllLanguagesSpoken( $idOfLanguages )
   {
      global $handleOfIfeFacebookDatabase;

      for ( $index = 0; $index < sizeof( $idOfLanguages ); $index++ ) {
         $query = '
            SELECT name_of_language FROM languages
               WHERE language_id = '  . (integer)$idOfLanguages[$index];

         $resultOfQuery = sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
         $rowFromResultOfQuery = mysql_fetch_assoc( $resultOfQuery );

         $namesOfLanguages[] = $rowFromResultOfQuery['name_of_language'];
      }

      return $namesOfLanguages;
   }


   function retrieveFromDatabaseAndReturnInArrayIdOfAllLanguagesExistingInDatabase()
   {
      global $handleOfIfeFacebookDatabase;

      $query = '
         SELECT language_id FROM languages
            ORDER BY name_of_language ASC';

      $resultOfQuery = sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
      $rowFromResultOfQuery = mysql_fetch_assoc( $resultOfQuery );

      if ( $rowFromResultOfQuery == false ) {
         return NULL;
      }
      else {

         while ( $rowFromResultOfQuery != false ) {
            $idOfLanguages[] = $rowFromResultOfQuery['language_id'];
            $rowFromResultOfQuery = mysql_fetch_assoc( $resultOfQuery );
         }

         return $idOfLanguages;
      }

   }


   function retrieveFromDatabaseAndReturnInArrayNamesOfAllLanguagesExistingInDatabase()
   {
      global $handleOfIfeFacebookDatabase;

      $query = '
         SELECT name_of_language FROM languages
            ORDER BY name_of_language ASC';

      $resultOfQuery = sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
      $rowFromResultOfQuery = mysql_fetch_assoc( $resultOfQuery );

      if ( $rowFromResultOfQuery == false ) {
         return NULL;
      }
      else {

         while ( $rowFromResultOfQuery != false ) {
            $namesOfLanguages[] = $rowFromResultOfQuery['name_of_language'];
            $rowFromResultOfQuery = mysql_fetch_assoc( $resultOfQuery );
         }

         return $namesOfLanguages;
      }

   }


   function retrieveFromDatabaseAndReturnInArrayIdOfFirstSetOfFriends( $idOfUser )
   {
      global $handleOfIfeFacebookDatabase;

      $query = '
         SELECT id_of_first_user FROM friend_relationships
            WHERE id_of_second_user = '  . (integer)$idOfUser;

      $resultOfQuery = sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
      $rowFromResultOfQuery = mysql_fetch_assoc( $resultOfQuery );

      if ( $rowFromResultOfQuery == false ) {
         return NULL;
      }
      else {

         while ( $rowFromResultOfQuery != false ) {
            $idOfFirstSetOfFriends[] = $rowFromResultOfQuery['id_of_first_user'];
            $rowFromResultOfQuery = mysql_fetch_assoc( $resultOfQuery );
         }

         return $idOfFirstSetOfFriends;
      }
   }


   function retrieveFromDatabaseAndReturnInArrayIdOfSecondSetOfFriends( $idOfUser )
   {
      global $handleOfIfeFacebookDatabase;

      $query = '
         SELECT id_of_second_user FROM friend_relationships
            WHERE id_of_first_user = '  . (integer)$idOfUser;

      $resultOfQuery = sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
      $rowFromResultOfQuery = mysql_fetch_assoc( $resultOfQuery );

      if ( $rowFromResultOfQuery == false ) {
         return NULL;
      }
      else {

         while ( $rowFromResultOfQuery != false ) {
            $idOfSecondSetOfFriends[] = $rowFromResultOfQuery['id_of_second_user'];
            $rowFromResultOfQuery = mysql_fetch_assoc( $resultOfQuery );
         }

         return $idOfSecondSetOfFriends;
      }

   }


   function retrieveFromDatabaseAndReturnInArrayIdOfLikers( 
      $idOfStatusUpdate, $offset = 0, $numberOfRows = DEFAULT_NUMBER_OF_ROWS_FOR_LIKES )
   {
      global $handleOfIfeFacebookDatabase;

      $query = '
         SELECT id_of_user FROM likes
            WHERE id_of_status_update = ' . (integer)$idOfStatusUpdate . '
            LIMIT ' . (integer)$offset . ', ' . (integer)$numberOfRows;

      $resultOfQuery = sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
      $rowFromResultOfQuery = mysql_fetch_assoc( $resultOfQuery );

      if ( $rowFromResultOfQuery == false ) {
         return NULL;
      }
      else {

         while ( $rowFromResultOfQuery != false ) {
            $idOfAssociatedLikers[] = $rowFromResultOfQuery['id_of_user'];
            $rowFromResultOfQuery = mysql_fetch_assoc( $resultOfQuery );
         }

         return $idOfAssociatedLikers;
      }

   }


   function retrieveFromDatabaseEntryThatIndicatesThatUserLikesStatusUpdate( $idOfUser, $idOfStatusUpdate )
   {
      global $handleOfIfeFacebookDatabase;

      $query = '
         SELECT * FROM likes
            WHERE id_of_user = ' . (integer)$idOfUser . '
            AND id_of_status_update = ' . (integer)$idOfStatusUpdate;

      $resultOfQuery = sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
      $rowFromResultOfQuery = mysql_fetch_assoc( $resultOfQuery );

      return $rowFromResultOfQuery;
   }


   function retrieveFromDatabaseUserIdBasedOnEmailAddressOrPhoneNumber( $userName )
   {
      global $handleOfIfeFacebookDatabase;

      if ( isNotValidEmailAddress( $userName ) && isNotValidPhoneNumber( $userName ) ) {
         return NULL;
      }

      if ( isValidPhoneNumber( $userName ) ) {
         $userName = convertToPhoneNumberWithCountryCode( $userName );
      }

      $query = 
         'SELECT user_id, login_password FROM user_information
            WHERE email_address = "'  .  $userName  .  '"
            OR phone_number = "'  .  $userName  .  '"';

      $resultOfQuery = sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
      $rowFromResultOfQuery = mysql_fetch_assoc( $resultOfQuery );

      return $rowFromResultOfQuery;
   }
?>