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

   include_once '/includeFiles/functionsForCreatingMarkups.php';
   include_once '/includeFiles/functionsForRetrievingDataFromDatabase.php';
   include_once '/includeFiles/functionsForStoringDataIntoSESSION.php';


   if ( userHaveFilledTheLoginForm() ) {
      $markup = validateTheUserAndPossiblyLogTheUserIn();
   }
   else {
      header( 'Location: index.php' );
   }


   function userHaveFilledTheLoginForm()
   {
      return isset( $_POST['userName'] );
   }


   function validateTheUserAndPossiblyLogTheUserIn()
   {
      $loginDetailsFromDatabase = retrieveFromDatabaseUserIdAndLoginPassword();

      if ( userNameIsNotCorrect( $loginDetailsFromDatabase ) ) {
         return getMarkupToShowThatUserNameIsNotCorrect();
      }
      else if ( userPasswordIsNotCorrect( $loginDetailsFromDatabase ) ) {
         return getMarkupToShowThatUserPasswordIsNotCorrect();
      }
      else {
         logTheUserIn( $loginDetailsFromDatabase['user_id'] );
         storeIntoSESSIONIdOfAllFriendsAndTotalNumberOfFriendsOfLoggedInUser();
         storeIntoSESSIONFirstNameOfLoggedInUser();
         redirectToTheSourcePage();
      }

   }


   function userNameIsNotCorrect( $loginDetailsFromDatabase )
   {
      return $loginDetailsFromDatabase == false;
   }


   function getMarkupToShowThatUserNameIsNotCorrect()
   {
      return '
      <div class="containerForEditForm">
         <h3>The email address or phone number you entered is not correct. Why not try to login again?</h3>
      '  . 
         getMarkupForLoginFormWithDefaultValues( NULL, NULL ) . '
      </div> 
      ';
   }


   function userPasswordIsNotCorrect( $loginDetailsFromDatabase )
   {
      return $loginDetailsFromDatabase['login_password'] != $_POST['userPassword'];
   }


   function getMarkupToShowThatUserPasswordIsNotCorrect()
   {
      return '
      <div class="containerForEditForm">
         <h3>The password you entered is not correct. Why not try to login again?</h3>
      '  . 
         getMarkupForLoginFormWithDefaultValues( $_POST['userName'], NULL ) . '
      </div>
      ';
   }


   function logTheUserIn( $idOfTheUser )
   {
      $_SESSION['idOfLoggedInUser'] = $idOfTheUser;
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
      <link href="stylesheets/genericStylesheet.css" type="text/css" rel="stylesheet"/>
      <link href="stylesheets/stylesheetForFormForEditingProfileDetails.css" type="text/css" rel="stylesheet"/>
   </head>

   <body>
      <?php 
         echo $markup;
      ?>

   </body>

</html>