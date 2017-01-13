<!DOCTYPE html>

<?php 

   /* 
    * This page contains PHP script to authenticate 
    * the user's username and password.
    *
    * If they are correct, then the user_id of the user is stored in a 
    * SESSION variable (to indicate that the user is logged in)
    * 
    * The user is expected to arrive at this page only after he has filled 
    * the login form in the 'index.php' page.
    *
    * If he arrives through any other means, he will simply be 
    * redirected to the 'index.php' page
    */

   session_start();

   include_once 'includeFiles/functionsForCreatingMarkups.php';
   include_once 'includeFiles/functionsForRetrievingDataFromDatabase.php';
   include_once 'includeFiles/functionsForStoringDataIntoSESSION.php';


   if ( userDidNotFillTheLoginForm() ) {
      header( 'Location: index.php' );
   }
   else if ( userDidNotInputCorrectLoginDetails() ) {
      $markup = getMarkupToTellUserToReEnterLoginDetails();
   }
   else if ( userInputtedCorrectLoginDetails() ) {
      logTheUserIn();
      storeIntoSESSIONIdOfAllFriendsAndTotalNumberOfFriendsOfLoggedInUser();
      storeIntoSESSIONFirstNameOfLoggedInUser();
      redirectToTheSourcePage();
   }


   function userDidNotFillTheLoginForm()
   {
      return !isset( $_POST['loginButton'] );
   }


   function logTheUserIn( $idOfTheUser )
   {
      $rowContainingUserId = retrieveFromDatabaseUserIdAssociatedWithUserName( $_POST['userName'] );
      $_SESSION['idOfLoggedInUser'] = $rowContainingUserId['user_id'];
   }


   function redirectToTheSourcePage()
   {
      if ( isset( $_POST['urlOfSourcePage'] ) ) {
         header( 'Location: '  .  $_POST['urlOfSourcePage'] );
      }
      else {
         header( 'Location: index.php' );
      }

   }
?>


<html>
   <head>
      <title>Unable To Log In | ife_facebook</title>
      <link href="stylesheets/genericStylesheet.css" type="text/css" rel="stylesheet"/>
      <link href="stylesheets/stylesheetForFormForEditingProfileDetails.css" type="text/css" rel="stylesheet"/>
   </head>

   <body>
      <?php 
         echo $markup;
      ?>

   </body>

</html>