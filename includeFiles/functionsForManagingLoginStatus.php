<?php
   function userIsLoggedIn()
   {
      return isset( $_SESSION['idOfLoggedInUser'] );
   }


   function userIsNotLoggedIn()
   {
      return !userIsLoggedIn();
   }


   function logOutButtonHaveBeenClicked()
   {
      return isset( $_POST['logOutButton'] );
   }


   function logTheUserOut()
   {
      session_destroy();
      header( 'Location: index.php' );
   }
?>