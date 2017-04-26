<!DOCTYPE html>

<?php
   session_start();

   include_once 'includeFiles/booleanFunctions.php';
   include_once 'includeFiles/functionsForCreatingMarkups.php';
   include_once 'includeFiles/functionsForUpdatingDataInDatabase.php';


   if ( userIsNotLoggedIn() ) {
      $markup = getMarkupToTellUserToLogIn();
   }
   else {
      $markup = 
      getMarkupForHeader() . '
      <div class="mainBody whiteContainerWithBorder">
         <h1 class="bigSizedText">Notifications</h1>
      ';

      $notifications = retrieveFromDatabaseAndReturnInArrayIdOfAllNotificationsThatAreMeantForLoggedInUser();
      if ( doesNotExistInDatabase( $notifications ) && userHasNoPendingFriendRequest() ) {
         $markup .= '
         <p class="smallTopMargin">There are no notifications to read.</p>';
      }
      else {
         // The user may have new friends probably because of a friend request being accepted e.t.c.
         storeIntoSESSIONIdOfAllFriendsAndTotalNumberOfFriendsOfLoggedInUser();

         $markup .= 
         getMarkupForClearNotificationsButton() . '
         <ul>';

         if ( userHasAtLeastOnePendingFriendRequest() ) {
            $markup .= '
            <li>You have some pending friend requests. <a href="findFriends.php">Click here to view them</a>.</li>';
         }

         for ( $index = 0; $index < sizeof( $notifications ); $index++ ) {
            $markup .= '
            <li>' . 
               getMarkupToDisplayDetailsAboutNotification( $notifications[$index] ) . '
            </li>';
         }

         $markup .= '
         </ul>';

         updateInDatabaseEntryThatIndicatesThatAllNotificationsMeantForLoggedInUserHasBeenRead();
      }

      $markup .= '
      </div>';
   }
?>

<html>
   <head>
      <title>Notifications | ife_facebook</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
      <link href="stylesheets/ife_facebookStylesheet.css" type="text/css" rel="stylesheet"/>
   </head>

   <body>
      <?php 
         echo $markup;
      ?>

   </body>
</html>