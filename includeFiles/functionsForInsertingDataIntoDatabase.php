<?php
   include_once 'includeFiles/functionsForInteractingWithDatabaseAtLowLevel.php';
   include_once 'includeFiles/booleanFunctions.php';
   include_once 'includeFiles/functionsForStoringDataIntoSESSION.php';
   include_once 'includeFiles/miscellaneousFunctions.php';
   include_once 'includeFiles/usefulConstants.php';

   if ( !isset( $handleOfIfeFacebookDatabase ) ) {
      $handleOfIfeFacebookDatabase = connectToDatabase( 'ife_facebook_database' );
   }


   function insertIntoDatabaseLanguageEntryAndGetIdOfLanguageEntry( $nameOfNewLanguage )
   {
      global $handleOfIfeFacebookDatabase;

      $rowContainingIdOfLanguage = retrieveFromDatabaseIdOfLanguageAssociatedWithNameOfLanguage( $nameOfNewLanguage );

      if ( existsInDatabase( $rowContainingIdOfLanguage ) ) {
         $idOfLatestLanguage = $rowContainingIdOfLanguage['language_id'];
      }
      else {
         $query = '
            INSERT INTO languages ( name_of_language )
               VALUES ( "' . strtolower( $nameOfNewLanguage ) . '" )';

         sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
         $idOfLatestLanguage = mysql_insert_id( $handleOfIfeFacebookDatabase );
      }

      return $idOfLatestLanguage;
   }


   function insertIntoDatabaseCommentOfLoggedInUser()
   {
      global $handleOfIfeFacebookDatabase;

      $safeCommentText = mysql_real_escape_string( $_POST['commentText'] );

      $query = '
         INSERT INTO comments ( comment_text, id_of_commenter, id_of_status_update, time_of_commenting )
            VALUES ( "' . $safeCommentText . '", ' . (integer)$_SESSION['idOfLoggedInUser'] . ', ' . (integer)$_POST['idOfStatusUpdate'] . ', NOW() )';

      sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
   }


   function insertIntoDatabaseEntryToIndicateThatLoggedInUserLikesStatusUpdate( $idOfStatusUpdate )
   {
      global $handleOfIfeFacebookDatabase;

      $query = '
         INSERT INTO likes ( id_of_user, id_of_status_update )
            VALUES ( ' . (integer)$_SESSION['idOfLoggedInUser'] . ', ' . (integer)$idOfStatusUpdate . ' )';

      sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
   }


   function insertIntoDatabaseStatusUpdateByLoggedInUser()
   {
      global $handleOfIfeFacebookDatabase;

      $safeStatusUpdateText = mysql_real_escape_string( $_POST['statusUpdateText'] );

      $query = '
         INSERT INTO status_updates ( status_update_text, id_of_poster, time_of_posting, number_of_likes )
            VALUES ( "' . $safeStatusUpdateText . '", ' . (integer)$_SESSION['idOfLoggedInUser'] . ', NOW(), 0 )';

      sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
   }


   function insertIntoDatabaseEntryForNewUserOfIfeFacebook()
   {
      global $handleOfIfeFacebookDatabase;

      // The test for invalid password have not yet been implemented
      if ( isNotValidUserName( $_POST['firstName'] ) || isNotValidUserName( $_POST['surname'] ) ) {
         return;
      }

      if ( isNotValidEmailAddress( $_POST['userName'] ) && isNotValidPhoneNumber( $_POST['userName'] ) ) {
         return;
      }

      $safeFirstName = mysql_real_escape_string( $_POST['firstName'] );
      $safeSurname = mysql_real_escape_string( $_POST['surname'] );
      $safeUserPassword = mysql_real_escape_string( $_POST['userPassword'] );
      $formattedUserName = ( isValidPhoneNumber( $_POST['userName'] ) ? 
         convertToPhoneNumberWithCountryCode( $_POST['userName'] ) : $_POST['userName'] );

      $query = '
         INSERT INTO user_information ( 
            first_name, 
            last_name, 
            ' . ( isValidEmailAddress( $_POST['userName'] ) ? 'email_address' : 'phone_number' ) . ',
            login_password
         )

         VALUES ( 
            "' . $safeFirstName . '", 
            "' . $safeSurname . '", 
            "' . strtolower( $formattedUserName ) . '", 
            "' . $safeUserPassword . '"
         )';

      sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
   }


   function insertIntoDatabaseCityEntryAndGetIdOfCityEntry( $nameOfCity, $nameOfCountry )
   {
      global $handleOfIfeFacebookDatabase;

      $safeNameOfCity = mysql_real_escape_string( $nameOfCity );
      $safeNameOfCountry = mysql_real_escape_string( $nameOfCountry );

      $row = retrieveFromDatabaseCityIdAssociatedWithNameOfCityAndNameOfCountry( $nameOfCity, $nameOfCountry );

      if ( existsInDatabase( $row ) ) {
         $idOfCity = $row['city_id'];
      }
      else {
         $query = '
            INSERT INTO cities ( name_of_city, name_of_country )
               VALUES ( "' . strtolower( $safeNameOfCity ) . '", "' . strtolower( $safeNameOfCountry ) . '" )';

         sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
         $idOfCity = mysql_insert_id( $handleOfIfeFacebookDatabase );
      }

      return $idOfCity;
   }


   function insertIntoDatabaseEntryThatIndicatesThatLoggedInUserSentFriendRequestToRequiredUser( $idOfRequiredUser )
   {
      global $handleOfIfeFacebookDatabase;

      $query = '
         INSERT INTO friend_requests ( id_of_sender, id_of_reciever )
            VALUES ( ' . (integer)$_SESSION['idOfLoggedInUser'] . ', ' . (integer)$idOfRequiredUser . ' )';

      sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
   }


   function insertIntoDatabaseEntryToIndicateThatRequiredUserAndLoggedInUserAreNowFriends( $idOfRequiredUser )
   {
      global $handleOfIfeFacebookDatabase;

      $query = '
         INSERT INTO friend_relationships ( id_of_first_user, id_of_second_user )
            VALUES ( ' . (integer)$idOfRequiredUser . ', ' . (integer)$_SESSION['idOfLoggedInUser'] . ' )';

      sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
   }


   function insertIntoDatabaseNotificationEntry( $notificationText, $idOfUserWhomNotificationIsMeantFor )
   {
      global $handleOfIfeFacebookDatabase;

      $query = '
         INSERT INTO notifications ( id_of_user_whom_notification_is_meant_for, notification_text, time_of_creating_notification, notification_state )
         VALUES ( ' . (integer)$idOfUserWhomNotificationIsMeantFor . ', "' . mysql_real_escape_string( $notificationText ) . '", NOW(), "not_read" )';

      sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
   }
?>