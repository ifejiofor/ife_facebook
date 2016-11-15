<!DOCTYPE html>

<!-- this page is merely used by me to test any PHP functionality that I want to really understand -->
<html>
   <head>
   </head>

   <body>

<?php
   $var = isset( $_GET['abcd'] ) ? $_GET['abcd'] : NULL;

   if ( $var === NULL ) {
      echo 'NULL';
   }
   else if ( $var === '' ) {
      echo 'empty string';
   }
   else {
      echo $var;
   }   
?>
   </body>

</html>
