<?php
   session_start();

   if ( isset( $_POST['logOutButton'] ) ) {
      session_destroy();
   }

   header( 'Location: index.php' );
?>