<!DOCTYPE html>

<?php
   session_start();

   include_once '/includeFiles/functionsForManagingLoginStatus.php';
   include_once '/includeFiles/functionsForInteractingWithDatabase.php';
   include_once '/includeFiles/functionsForCreatingMarkups.php';

   if ( userIsNotLoggedIn() ) {
      $markup = getMarkupToTellTheUserToLogIn( $_SERVER['PHP_SELF'] );
   }
   else if ( logOutButtonHaveBeenClicked() ) {
      logTheUserOut();
   }
   else {
      $handleOfDatabase = connectToDatabase( 'ife_facebook_database' );

      $markup = 
         getMarkupForHeader() . '

      <section class="mainSectionOfProfilePage">' .
         getMarkupForTopOfProfilePage( 'myFriends.php' );

      if ( $_SESSION["totalNumberOfFriends"] == 0 ) {
         $markup .= '
         <p>Sorry, you have no friends</p>';
      }
      else {
         $markup .= '
         <p>The following are your friends:</p>

            <ol>';

         for ( $index = 0; $index < $_SESSION["totalNumberOfFriends"]; $index++ ) {
            $query = '
               SELECT first_name, last_name FROM user_information
                  WHERE user_id = '  .  $_SESSION["idOfFriend" . $index];

            $resultOfQuery = sendQueryToDatabaseAndGetResult( $query, $handleOfDatabase );
            $rowFromResultOfQuery = mysql_fetch_assoc( $resultOfQuery );

            $markup .= '
               <li>'  .  $rowFromResultOfQuery["first_name"]  .  ' '  . $rowFromResultOfQuery["last_name"]  .  '</li>';
         }

         $markup .= '
            </ol>';
      }

      $markup .= '
      </section>  <!-- end section.mainSectionOfProfilePage -->
      ';
   }
?>


<html>
   <head>
      <title>My Friends</title>

      <link href="stylesheets/genericStylesheet.css" type="text/css" rel="stylesheet"/>
      <link href="stylesheets/stylesheetForLoggedInHeaderAndLoggedInBody.css" type="text/css" rel="stylesheet"/>
      <link href="stylesheets/stylesheetForTopOfProfilePage.css" type="text/css" rel="stylesheet"/>
   </head>

   <body>
      <?php 
         echo $markup;
      ?>

   </body>
</html>