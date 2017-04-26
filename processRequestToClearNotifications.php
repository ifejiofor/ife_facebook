<?php
   session_start();

   include_once 'includeFiles/booleanFunctions.php';

   if ( userIsNotLoggedIn() || !isset( $_POST['clearNotificationsButton'] ) ) {
      header( 'Location: index.php' );
   }

   deleteFromDatabaseAllNotificationsMeantForLoggedInUser();
   header( 'Location: notifications.php' );
?>