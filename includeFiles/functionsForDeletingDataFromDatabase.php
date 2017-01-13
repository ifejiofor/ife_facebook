<?php
   include_once 'includeFiles/functionsForAccessingDatabase.php';

   if ( !isset( $handleOfIfeFacebookDatabase ) ) {
      $handleOfIfeFacebookDatabase = connectToDatabase( 'ife_facebook_database' );
   }


   function deleteFromDatabaseLanguageEntry( $idOfLanguageToBeDeleted )
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
?>