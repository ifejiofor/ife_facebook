<?php
   include_once 'includeFiles/functionsForInteractingWithDatabase.php';
   include_once 'includeFiles/functionsForStoringDataIntoSESSION.php';
   include_once 'includeFiles/miscellaneousFunctions.php';
   include_once 'includeFiles/usefulConstants.php';

   if ( !isset( $handleOfIfeFacebookDatabase ) ) {
      $handleOfIfeFacebookDatabase = connectToDatabase( 'ife_facebook_database' );
   }


   function insertIntoDatabaseLanguageEntryAndGetIdOfLanguageEntry( $nameOfNewLanguage )
   {
      global $handleOfIfeFacebookDatabase;

      if ( nameOfLanguageIsInvalid( $_POST['nameOfNewLanguage'] ) ) {
         return NULL;
      }

      $query = '
         SELECT language_id FROM languages
            WHERE name_of_language = "' . strtolower( $_POST['nameOfNewLanguage'] ) . '"';

      $resultOfQuery = sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
      $rowFromResultOfQuery = mysql_fetch_assoc( $resultOfQuery );

      if ( $rowFromResultOfQuery != false ) {
         $idOfLatestLanguage = $rowFromResultOfQuery['language_id'];
      }
      else {
         $query = '
            INSERT INTO languages ( name_of_language )
               VALUES ( "' . strtolower( $_POST['nameOfNewLanguage'] ) . '" )';

         sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
         $idOfLatestLanguage = mysql_insert_id( $handleOfIfeFacebookDatabase );
         storeIntoSESSIONRelevantDetailsAboutAllLanguagesExistingInDatabase();
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
      if ( isNotValidUserName( $_POST['firstName'] ) ) {
         return INVALID_FIRST_NAME;
      }
      else if ( isNotValidUserName( $_POST['surname'] ) ) {
         return INVALID_SURNAME;
      }
      else if ( isNotValidEmailAddress( $_POST['userName'] ) && isNotValidPhoneNumber( $_POST['userName'] ) ) {
         return INVALID_USER_NAME;
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

      return INSERTION_SUCCESSFUL;
   }
?>