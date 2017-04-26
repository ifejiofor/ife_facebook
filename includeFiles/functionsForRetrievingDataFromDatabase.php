<?php
   include_once 'includeFiles/functionsForInteractingWithDatabaseAtLowLevel.php';
   include_once 'includeFiles/booleanFunctions.php';
   include_once 'includeFiles/miscellaneousFunctions.php';
   include_once 'includeFiles/usefulConstants.php';


   if ( !isset( $handleOfIfeFacebookDatabase ) ) {
      $handleOfIfeFacebookDatabase = connectToDatabase( 'ife_facebook_database' );
   }


   function retrieveFromDatabaseLoginPasswordAssociatedWithUserName( $userName )
   {
      global $handleOfIfeFacebookDatabase;

      if ( isNotValidEmailAddress( $userName ) && isNotValidPhoneNumber( $userName ) ) {
         return NULL;
      }

      if ( isValidPhoneNumber( $userName ) ) {
         $userName = convertToPhoneNumberWithCountryCode( $userName );
      }

      $query = 
         'SELECT login_password FROM user_information
            WHERE email_address = "'  .  $userName  .  '"
            OR phone_number = "'  .  $userName  .  '"';

      $resultOfQuery = sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
      $rowFromResultOfQuery = mysql_fetch_assoc( $resultOfQuery );
      return $rowFromResultOfQuery;
   }


   function retrieveFromDatabaseUserIdAssociatedWithUserName( $userName )
   {
      global $handleOfIfeFacebookDatabase;

      if ( isNotValidEmailAddress( $userName ) && isNotValidPhoneNumber( $userName ) ) {
         return NULL;
      }

      if ( isValidPhoneNumber( $userName ) ) {
         $userName = convertToPhoneNumberWithCountryCode( $userName );
      }

      $query = 
         'SELECT user_id FROM user_information
            WHERE email_address = "'  .  $userName  .  '"
            OR phone_number = "'  .  $userName  .  '"';

      $resultOfQuery = sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
      $rowFromResultOfQuery = mysql_fetch_assoc( $resultOfQuery );

      return $rowFromResultOfQuery;
   }


   function retrieveFromDatabaseAndReturnInArrayIdOfSomeStatusUpdatesThatWerePostedByLoggedInUserOrHisFriends( 
      $offset, $numberOfRows )
   {
      global $handleOfIfeFacebookDatabase;

      $query = createQueryForRetrievingIdOfStatusUpdatesThatWerePostedByLoggedInUserOrHisFriends( $offset, $numberOfRows );

      $resultOfQuery = sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
      $arrayContainingResultOfQuery = getArrayContainingResultOfQuery( $resultOfQuery, 'status_update_id' );

      return $arrayContainingResultOfQuery;
   }


   function createQueryForRetrievingIdOfStatusUpdatesThatWerePostedByLoggedInUserOrHisFriends( $offset, $numberOfRows )
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


   function retrieveFromDatabaseAndReturnInArrayIdOfSomeStatusUpdatesThatWerePostedByUser(
      $idOfUser, $offset, $numberOfRows )
   {
      global $handleOfIfeFacebookDatabase;

      $query = '
         SELECT status_update_id FROM status_updates
            WHERE id_of_poster = ' . (integer)$idOfUser . '
            ORDER BY time_of_posting DESC
            LIMIT ' . (integer)$offset . ', ' . (integer)$numberOfRows;

      $resultOfQuery = sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
      $arrayContainingResultOfQuery = getArrayContainingResultOfQuery( $resultOfQuery, 'status_update_id' );

      return $arrayContainingResultOfQuery;
   }


   function retrieveFromDatabaseAndReturnInArrayIdOfAllStatusUpdatesThatWerePostedByUser( $idOfUser )
   {
      global $handleOfIfeFacebookDatabase;

      $query = '
         SELECT status_update_id FROM status_updates
            WHERE id_of_poster = ' . (integer)$idOfUser;

      $resultOfQuery = sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
      $arrayContainingResultOfQuery = getArrayContainingResultOfQuery( $resultOfQuery, 'status_update_id' );

      return $arrayContainingResultOfQuery;
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
      $arrayContainingResultOfQuery = getArrayContainingResultOfQuery( $resultOfQuery, 'comment_id' );
      
      return  $arrayContainingResultOfQuery;

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


   function retrieveFromDatabasePhoneNumberDetails( $idOfUser )
   {
      global $handleOfIfeFacebookDatabase;

      $query = '
         SELECT phone_number FROM user_information
            WHERE user_id = '  .  (integer)$idOfUser;

      $resultOfQuery = sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
      $rowFromResultOfQuery = mysql_fetch_assoc( $resultOfQuery );

      return $rowFromResultOfQuery;
   }


   function retrieveFromDatabaseEmailAddressDetails( $idOfUser )
   {
      global $handleOfIfeFacebookDatabase;

      $query = '
         SELECT email_address FROM user_information
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
      $arrayContainingResultOfQuery = getArrayContainingResultOfQuery( $resultOfQuery, 'id_of_language' );
      
      return  $arrayContainingResultOfQuery;
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
      $arrayContainingResultOfQuery = getArrayContainingResultOfQuery( $resultOfQuery, 'language_id' );
      
      return  $arrayContainingResultOfQuery;
   }


   function retrieveFromDatabaseAndReturnInArrayNamesOfAllLanguagesExistingInDatabase()
   {
      global $handleOfIfeFacebookDatabase;

      $query = '
         SELECT name_of_language FROM languages
            ORDER BY name_of_language ASC';

      $resultOfQuery = sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
      $arrayContainingResultOfQuery = getArrayContainingResultOfQuery( $resultOfQuery, 'name_of_language' );
      
      return  $arrayContainingResultOfQuery;
   }


   function retrieveFromDatabaseNameOfLanguage( $idOfRequiredLanguage )
   {
      global $handleOfIfeFacebookDatabase;

      $query = '
         SELECT name_of_language FROM languages
            WHERE language_id = ' . $idOfRequiredLanguage;

      $resultOfQuery = sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
      $rowFromResultOfQuery = mysql_fetch_assoc( $resultOfQuery );

      return $rowFromResultOfQuery;
   }


   function retrieveFromDatabaseAndReturnInArrayIdOfFirstSetOfFriends( $idOfUser )
   {
      global $handleOfIfeFacebookDatabase;

      $query = '
         SELECT id_of_first_user FROM friend_relationships
            WHERE id_of_second_user = '  . (integer)$idOfUser;

      $resultOfQuery = sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
      $arrayContainingResultOfQuery = getArrayContainingResultOfQuery( $resultOfQuery, 'id_of_first_user' );
      
      return  $arrayContainingResultOfQuery;
   }


   function retrieveFromDatabaseAndReturnInArrayIdOfSecondSetOfFriends( $idOfUser )
   {
      global $handleOfIfeFacebookDatabase;

      $query = '
         SELECT id_of_second_user FROM friend_relationships
            WHERE id_of_first_user = '  . (integer)$idOfUser;

      $resultOfQuery = sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
      $arrayContainingResultOfQuery = getArrayContainingResultOfQuery( $resultOfQuery, 'id_of_second_user' );
      
      return  $arrayContainingResultOfQuery;
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
      $arrayContainingResultOfQuery = getArrayContainingResultOfQuery( $resultOfQuery, 'id_of_user' );
      
      return  $arrayContainingResultOfQuery;
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


   function retrieveFromDatabaseAndReturnInArrayIdOfAllStatusUpdatesWhichLoggedInUserLikes()
   {
      global $handleOfIfeFacebookDatabase;

      $query = '
         SELECT id_of_status_update FROM likes
            WHERE id_of_user = ' . (integer)$_SESSION['idOfLoggedInUser'];

      $resultOfQuery = sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
      $arrayContainingResultOfQuery = getArrayContainingResultOfQuery( $resultOfQuery, 'id_of_status_update' );
      
      return  $arrayContainingResultOfQuery;
   }


   function retrieveFromDatabaseUserIdAssociatedWithEmailAddressOrPhoneNumber( $userName )
   {
      global $handleOfIfeFacebookDatabase;

      if ( isNotValidEmailAddress( $userName ) && isNotValidPhoneNumber( $userName ) ) {
         return NULL;
      }

      if ( isValidPhoneNumber( $userName ) ) {
         $userName = convertToPhoneNumberWithCountryCode( $userName );
      }

      $query = '
         SELECT user_id FROM user_information
            WHERE email_address = "'  .  $userName  .  '"
            OR phone_number = "'  .  $userName  .  '"';

      $resultOfQuery = sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
      $rowFromResultOfQuery = mysql_fetch_assoc( $resultOfQuery );

      return $rowFromResultOfQuery;
   }


   function retrieveFromDatabaseUserIdOfAnotherUserAssociatedWithEmailAddress( $emailAddress )
   {
      global $handleOfIfeFacebookDatabase;

      if ( isNotValidEmailAddress( $emailAddress ) ) {
         return NULL;
      }

      $query = '
         SELECT user_id FROM user_information
            WHERE email_address = "'  .  $emailAddress  .  '"
            AND user_id != '  .  (integer)$_SESSION['idOfLoggedInUser'];

      $resultOfQuery = sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
      $rowFromResultOfQuery = mysql_fetch_assoc( $resultOfQuery );

      return $rowFromResultOfQuery;
   }


   function retrieveFromDatabaseUserIdOfAnotherUserAssociatedWithPhoneNumber( $phoneNumber )
   {
      global $handleOfIfeFacebookDatabase;

      if ( isNotValidPhoneNumber( $phoneNumber ) ) {
         return NULL;
      }

      $phoneNumber = convertToPhoneNumberWithCountryCode( $phoneNumber );

      $query = '
         SELECT user_id FROM user_information
            WHERE phone_number = "'  .  $phoneNumber  .  '"
            AND user_id != '  .  (integer)$_SESSION['idOfLoggedInUser'];

      $resultOfQuery = sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
      $rowFromResultOfQuery = mysql_fetch_assoc( $resultOfQuery );

      return $rowFromResultOfQuery;
   }


   function retrieveFromDatabasePasswordOfLoggedInUser()
   {
      global $handleOfIfeFacebookDatabase;

      $query = '
         SELECT login_password FROM user_information
            WHERE user_id = ' . (integer)$_SESSION['idOfLoggedInUser'];

      $resultOfQuery = sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
      $rowFromResultOfQuery = mysql_fetch_assoc( $resultOfQuery );

      return $rowFromResultOfQuery;
   }


   function retrieveFromDatabaseIdOfLanguageAssociatedWithNameOfLanguage( $nameOfLanguage )
   {
      global $handleOfIfeFacebookDatabase;

      if ( !consistsOfAlphabetsAndSpacesOnly( $nameOfLanguage ) ) {
         return NULL;
      }

      $query = '
         SELECT language_id FROM languages
            WHERE name_of_language = "' . strtolower( $nameOfLanguage ) . '"';

      $resultOfQuery = sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
      $rowFromResultOfQuery = mysql_fetch_assoc( $resultOfQuery );

      return $rowFromResultOfQuery;
   }


   function retrieveFromDatabaseCityIdAssociatedWithNameOfCityAndNameOfCountry( $nameOfCity, $nameOfCountry )
   {
      global $handleOfIfeFacebookDatabase;

      $safeNameOfCity = mysql_real_escape_string( $nameOfCity );
      $safeNameOfCountry = mysql_real_escape_string( $nameOfCountry );

      $query = '
         SELECT city_id FROM cities
            WHERE name_of_city = "'  .  strtolower( $safeNameOfCity )  . '"
            AND name_of_country = "' . strtolower( $safeNameOfCountry )  . '"';

      $resultOfQuery = sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
      $rowFromResultOfQuery = mysql_fetch_assoc( $resultOfQuery );

      return $rowFromResultOfQuery;
   }


   function retrieveFromDatabaseGenderIdAssociatedWithNameOfGender( $nameOfGender )
   {
      global $handleOfIfeFacebookDatabase;

      if ( doesNotConsistOfAlphabetsOnly( $nameOfGender ) ) {
         return NULL;
      }

      $query = '
         SELECT gender_id FROM genders
            WHERE name_of_gender = "' . $nameOfGender . '"';

      $resultOfQuery = sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
      $rowFromResultOfQuery = mysql_fetch_assoc( $resultOfQuery );

      return $rowFromResultOfQuery;
   }


   function retrieveFromDatabaseEntryThatIndicatesThatUsersAreFriendsOfEachOther( $idOfFirstUser, $idOfSecondUser )
   {
      global $handleOfIfeFacebookDatabase;

      $query = '
         SELECT id_of_first_user, id_of_second_user FROM friend_relationships
            WHERE ( id_of_first_user = ' . (integer)$idOfFirstUser . ' AND id_of_second_user = ' . (integer)$idOfSecondUser . ')
            OR ( id_of_first_user = ' . (integer)$idOfSecondUser . ' AND id_of_second_user = ' . (integer)$idOfFirstUser . ')';

      $resultOfQuery = sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
      $rowFromResultOfQuery = mysql_fetch_assoc( $resultOfQuery );

      return $rowFromResultOfQuery;
   }


   function rerieveFromDatabaseAndReturnInArrayIdOfUsersWhoseNamesMatchSearchQuery( 
      $searchQuery, $offset, $numberOfRows )
   {
      global $handleOfIfeFacebookDatabase;

      $sqlQuery = '
         SELECT user_id FROM user_information
            WHERE 0';

      $token = strtok( $searchQuery, ' ' );
      while ( $token != false ) {
         $token = strtolower( $token );

         $sqlQuery .= '
            OR first_name LIKE "%' . $token . '%"
            OR last_name LIKE "%' . $token . '%"
            OR nick_name LIKE "%' . $token . '%"';

         $token = strtok( ' ' );
      }

      $sqlQuery .= ' LIMIT ' . $offset . ', ' . $numberOfRows;

      $resultOfQuery = sendQueryToDatabaseAndGetResult( $sqlQuery, $handleOfIfeFacebookDatabase );
      return getArrayContainingResultOfQuery( $resultOfQuery, 'user_id' );
   }


   function retrieveFromDatabaseAndReturnInArrayIdOfAllUsersWhoseFriendRequestsHaveNotBeenAcceptedByLoggedInUser()
   {
      global $handleOfIfeFacebookDatabase;

      $query = '
         SELECT id_of_sender FROM friend_requests
            WHERE id_of_reciever = ' . $_SESSION['idOfLoggedInUser'];

      $resultOfQuery = sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
      return getArrayContainingResultOfQuery( $resultOfQuery, 'id_of_sender' );
   }


   function retrieveFromDatabaseEntryThatIndicatesThatFriendRequestSentByLoggedInUserHasNotYetBeenAcceptedByRequiredUser(
      $idOfRequiredUser )
   {
      global $handleOfIfeFacebookDatabase;

      $query = '
         SELECT id_of_sender, id_of_reciever FROM friend_requests
            WHERE id_of_sender = ' . $_SESSION['idOfLoggedInUser'] . '
            AND id_of_reciever = ' . $idOfRequiredUser;

      $resultOfQuery = sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
      $rowContainingResultOfQuery = mysql_fetch_assoc( $resultOfQuery );
      return $rowContainingResultOfQuery;
   }


   function retrieveFromDatabaseEntryThatIndicatesThatLoggedInUserHasNotYetAcceptedFriendRequestByRequiredUser( 
      $idOfRequiredUser )
   {
      global $handleOfIfeFacebookDatabase;

      $query = '
         SELECT id_of_sender, id_of_reciever FROM friend_requests
            WHERE id_of_sender = ' . $idOfRequiredUser . '
            AND id_of_reciever = ' . $_SESSION['idOfLoggedInUser'];

      $resultOfQuery = sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
      return mysql_fetch_assoc( $resultOfQuery );
   }


   function retrieveFromDatabaseAndReturnInArrayIdOfAllNotificationsThatAreMeantForLoggedInUserButHaveNotBeenRead()
   {
      global $handleOfIfeFacebookDatabase;

      $query = '
         SELECT notification_id FROM notifications
            WHERE id_of_user_whom_notification_is_meant_for = ' . $_SESSION['idOfLoggedInUser'] . '
            AND notification_state = "not_read"
            ORDER BY time_of_creating_notification DESC';

      $resultOfQuery = sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
      $arrayContainingResultOfQuery = getArrayContainingResultOfQuery( $resultOfQuery, 'notification_id' );
      
      return  $arrayContainingResultOfQuery;
   }


   function retrieveFromDatabaseAndReturnInArrayIdOfAllNotificationsThatAreMeantForLoggedInUser()
   {
      global $handleOfIfeFacebookDatabase;

      $query = '
         SELECT notification_id FROM notifications
            WHERE id_of_user_whom_notification_is_meant_for = ' . $_SESSION['idOfLoggedInUser'] . '
            ORDER BY time_of_creating_notification DESC';

      $resultOfQuery = sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
      $arrayContainingResultOfQuery = getArrayContainingResultOfQuery( $resultOfQuery, 'notification_id' );
      
      return  $arrayContainingResultOfQuery;
   }


   function retrieveFromDatabaseDetailsAboutNotification( $idOfNotification )
   {
      global $handleOfIfeFacebookDatabase;

      $query = '
         SELECT notification_text, 
            notification_state,
            MONTHNAME( time_of_creating_notification ) AS month,
            DAY( time_of_creating_notification ) AS day,
            HOUR( time_of_creating_notification ) AS hour,
            MINUTE( time_of_creating_notification ) AS minute
            FROM notifications
            WHERE notification_id = ' . $idOfNotification;

      $resultOfQuery = sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
      return mysql_fetch_assoc( $resultOfQuery );
   }


   function retrieveFromDatabaseAndReturnInArrayIdOfUsersAssociatedWithHometown( $idOfHometown )
   {
      global $handleOfIfeFacebookDatabase;

      $query = '
         SELECT user_id FROM user_information
            WHERE id_of_hometown = ' . (integer)$idOfHometown;

      $resultOfQuery = sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
      $arrayContainingResultOfQuery = getArrayContainingResultOfQuery( $resultOfQuery, 'user_id' );
      
      return  $arrayContainingResultOfQuery;
   }


   function retrieveFromDatabaseAndReturnInArrayIdOfUsersAssociatedWithCurrentCity( $idOfCurrentCity )
   {
      global $handleOfIfeFacebookDatabase;

      $query = '
         SELECT user_id FROM user_information
            WHERE id_of_current_city = ' . (integer)$idOfCurrentCity;

      $resultOfQuery = sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
      $arrayContainingResultOfQuery = getArrayContainingResultOfQuery( $resultOfQuery, 'user_id' );
      
      return  $arrayContainingResultOfQuery;
   }


   function retrieveFromDatabaseAndReturnInArrayIdOfUsersAssociatedWithLanguage( $idOfLanguage )
   {
      global $handleOfIfeFacebookDatabase;

      $query = '
         SELECT id_of_user FROM user_and_language
            WHERE id_of_language = ' . (integer)$idOfLanguage;

      $resultOfQuery = sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
      $arrayContainingResultOfQuery = getArrayContainingResultOfQuery( $resultOfQuery, 'id_of_user' );
      
      return  $arrayContainingResultOfQuery;
   }
?>