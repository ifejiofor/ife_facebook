<?php
   include_once 'includeFiles/functionsForInteractingWithDatabaseAtLowLevel.php';
   include_once 'includeFiles/functionsForRetrievingDataFromDatabase.php';
   include_once 'includeFiles/functionsForUpdatingDataInDatabase.php';
   include_once 'includeFiles/functionsForStoringDataIntoSESSION.php';

   if ( !isset( $handleOfIfeFacebookDatabase ) ) {
      $handleOfIfeFacebookDatabase = connectToDatabase( 'ife_facebook_database' );
   }


   function deleteFromDatabaseEntryThatAssociatesLoggedInUserWithLanguage( $idOfLanguageToBeDeleted )
   {
      global $handleOfIfeFacebookDatabase;

      $query = '
         DELETE FROM user_and_language
            WHERE id_of_language = ' . (integer)$idOfLanguageToBeDeleted . '
            AND id_of_user = ' . (integer)$_SESSION['idOfLoggedInUser'];

      sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
   }


   function deleteFromDatabaseEntryThatIndicatesThatLoggedInUserLikesStatusUpdate( $idOfStatusUpdate )
   {
      global $handleOfIfeFacebookDatabase;

      $query = '
         DELETE FROM likes
            WHERE id_of_user = ' . (integer)$_SESSION['idOfLoggedInUser'] . '
            AND id_of_status_update = ' . (integer)$idOfStatusUpdate;

      sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
   }


   function deleteFromDatabaseEntryThatIndicatesThatRequiredUserSentFriendRequestToLoggedInUser( $idOfRequiredUser )
   {
      global $handleOfIfeFacebookDatabase;

      $query = '
         DELETE FROM friend_requests
            WHERE id_of_sender = ' . (integer)$idOfRequiredUser . '
            AND id_of_reciever = ' . (integer)$_SESSION['idOfLoggedInUser'];

      sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
   }


   function deleteFromDatabaseEntryThatIndicatesThatRequiredUserAndLoggedInUserAreFriends( $idOfRequiredUser )
   {
      global $handleOfIfeFacebookDatabase;

      $query = '
         DELETE FROM friend_relationships
            WHERE ( id_of_first_user = ' . (integer)$_SESSION['idOfLoggedInUser'] . ' AND id_of_second_user = ' . (integer)$idOfRequiredUser . ')
            OR ( id_of_first_user = ' . (integer)$idOfRequiredUser . ' AND id_of_second_user = ' . (integer)$_SESSION['idOfLoggedInUser'] . ' )';

      sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
   }


   function deleteFromDatabaseAllNotificationsMeantForLoggedInUser()
   {
      global $handleOfIfeFacebookDatabase;

      $query = '
         DELETE FROM notifications
            WHERE id_of_user_whom_notification_is_meant_for = ' . (integer)$_SESSION['idOfLoggedInUser'];

      sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
   }


   function deleteFromDatabaseAllEntriesThatAssociateLoggedInUserWithLanguagesAsWellAsAnyRedundantLanguageEntries()
   {
      $idOfLanguagesSpokenByLoggedInUser = 
         retrieveFromDatabaseAndReturnInArrayIdOfAllLanguagesSpoken( $_SESSION['idOfLoggedInUser'] );

      deleteFromDatabaseAllEntriesThatAssociateLoggedInUserWithLanguages();

      for ( $index = 0; $index < sizeof( $idOfLanguagesSpokenByLoggedInUser ); $index++ ) {
         deleteFromDatabaseLanguageEntryIfNoUserIsAssociatedWithTheLanguage( $idOfLanguagesSpokenByLoggedInUser[$index] );
      }
   }


   function deleteFromDatabaseLanguageEntryIfNoUserIsAssociatedWithTheLanguage( $idOfRequiredLanguage )
   {
      global $handleOfIfeFacebookDatabase;

      $usersWhoSpeakTheRequiredLanguage = 
         retrieveFromDatabaseAndReturnInArrayIdOfUsersAssociatedWithLanguage( $idOfRequiredLanguage );

      if ( doesNotExistInDatabase( $usersWhoSpeakTheRequiredLanguage ) ) {
         $query = '
            DELETE FROM languages
               WHERE language_id = ' . $idOfRequiredLanguage;

         sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
      }
   }


   function deleteFromDatabaseAllEntriesThatAssociateLoggedInUserWithLanguages()
   {
      global $handleOfIfeFacebookDatabase;

      $query = '
         DELETE FROM user_and_language
            WHERE id_of_user = ' . (integer)$_SESSION['idOfLoggedInUser'];

      sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
   }


   function deleteFromDatabaseAllEntriesThatAssociateLoggedInUserWithHisFriends()
   {
      global $handleOfIfeFacebookDatabase;

      $query = '
         DELETE FROM friend_relationships
            WHERE id_of_first_user = ' . (integer)$_SESSION['idOfLoggedInUser'] . '
            OR id_of_second_user = ' . (integer)$_SESSION['idOfLoggedInUser'];

      sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
   }


   function deleteFromDatabaseAllFriendRequestsSentToOrRecievedByLoggedInUser()
   {
      global $handleOfIfeFacebookDatabase;

      $query = '
         DELETE FROM friend_requests
            WHERE id_of_sender = ' . (integer)$_SESSION['idOfLoggedInUser'] . '
            OR id_of_reciever = ' . (integer)$_SESSION['idOfLoggedInUser'];

      sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
   }


   function deleteFromDatabaseAllStatusUpdatesPostedByLoggedInUserAsWellAsAnyRedundantCommentsAndLikes()
   {
      $statusUpdatesByLoggedInUser =
         retrieveFromDatabaseAndReturnInArrayIdOfAllStatusUpdatesThatWerePostedByUser( $_SESSION['idOfLoggedInUser'] );

      deleteFromDatabaseAllStatusUpdatesPostedByLoggedInUser();

      for ( $index = 0; $index < sizeof( $statusUpdatesByLoggedInUser ); $index++ ) {
         deleteFromDatabaseAllCommentsToStatusUpdate( $statusUpdatesByLoggedInUser[$index] );
         deleteFromDatabaseAllLikesToStatusUpdate( $statusUpdatesByLoggedInUser[$index] );
      }
   }


   function deleteFromDatabaseAllStatusUpdatesPostedByLoggedInUser()
   {
      global $handleOfIfeFacebookDatabase;

      $query = '
         DELETE FROM status_updates
            WHERE id_of_poster = ' . $_SESSION['idOfLoggedInUser'];

      sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
   }


   function deleteFromDatabaseAllCommentsToStatusUpdate( $idOfStatusUpdate )
   {
      global $handleOfIfeFacebookDatabase;

      $query = '
         DELETE FROM comments
            WHERE id_of_status_update = ' . $idOfStatusUpdate;

      sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
   }


   function deleteFromDatabaseAllLikesToStatusUpdate( $idOfStatusUpdate )
   {
      global $handleOfIfeFacebookDatabase;

      $query = '
         DELETE FROM likes
            WHERE id_of_status_update = ' . $idOfStatusUpdate;

      sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
   }


   function deleteFromDatabaseAllCommentsByLoggedInUserToAnyStatusUpdate()
   {
      global $handleOfIfeFacebookDatabase;

      $query = '
         DELETE FROM comments
            WHERE id_of_commenter = ' . $_SESSION['idOfLoggedInUser'];

      sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
   }


   function deleteFromDatabaseAllEntriesThatIndicateThatLoggedInUserLikesAnyStatusUpdate()
   {
      global $handleOfIfeFacebookDatabase;

      $statusUpdatesThatLoggedInUserLikes =
         retrieveFromDatabaseAndReturnInArrayIdOfAllStatusUpdatesWhichLoggedInUserLikes();

      if ( existsInDatabase( $statusUpdatesThatLoggedInUserLikes ) ) {
         for ( $index = 0; $index < sizeof( $statusUpdatesThatLoggedInUserLikes ); $index++ ) {
            updateInDatabaseDecrementNumberOfLikesByOne( $statusUpdatesThatLoggedInUserLikes[$index] );
         }
      }

      $query = '
         DELETE FROM likes
            WHERE id_of_user = ' . $_SESSION['idOfLoggedInUser'];

      sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
   }


   function deleteFromDatabaseEntryThatContainsInformationAboutUserAsWellAsAnyRedundantCityEntries()
   {
      $currentCityOfLoggedInUser = retrieveFromDatabaseIdOfCurrentCity( $_SESSION['idOfLoggedInUser'] );
      $hometownOfLoggedInUser = retrieveFromDatabaseIdOfHometown( $_SESSION['idOfLoggedInUser'] );

      deleteFromDatabaseEntryThatContainsInformationAboutLoggedInUser();
      deleteFromDatabaseCityEntryIfNoUserIsAssociatedWithTheCity( $currentCityOfLoggedInUser['id_of_current_city'] );
      deleteFromDatabaseCityEntryIfNoUserIsAssociatedWithTheCity( $hometownOfLoggedInUser['id_of_hometown'] );
   }


   function deleteFromDatabaseEntryThatContainsInformationAboutLoggedInUser()
   {
      global $handleOfIfeFacebookDatabase;

      $query = '
         DELETE FROM user_information
            WHERE user_id = ' . $_SESSION['idOfLoggedInUser'];

      sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
   }


   function deleteFromDatabaseCityEntryIfNoUserIsAssociatedWithTheCity( $idOfRequiredCity )
   {
      global $handleOfIfeFacebookDatabase;

      if ( $idOfRequiredCity == NULL ) {
         return;
      }

      $usersWhoseHometownIsTheRequiredCity =
         retrieveFromDatabaseAndReturnInArrayIdOfUsersAssociatedWithHometown( $idOfRequiredCity );
      $usersWhoseCurrentCityIsTheRequiredCity =
         retrieveFromDatabaseAndReturnInArrayIdOfUsersAssociatedWithCurrentCity( $idOfRequiredCity );

      if ( doesNotExistInDatabase( $usersWhoseHometownIsTheRequiredCity ) && 
         doesNotExistInDatabase( $usersWhoseCurrentCityIsTheRequiredCity ) )
      {
         $query = '
            DELETE FROM cities
               WHERE city_id = ' . $idOfRequiredCity;

         sendQueryToDatabaseAndGetResult( $query, $handleOfIfeFacebookDatabase );
      }
   }
?>