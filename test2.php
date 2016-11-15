<!DOCTYPE html>
<html>
<head>
<style>

</style>
</head>
<body>

<?php
   session_start();

   $resultOfQuery = mysql_query( 'select * from cities', $_SESSION['handle'] );
   $rowFromResultOfQuery = mysql_fetch_assoc( $resultOfQuery );

   echo $rowFromResultOfQuery['name_of_city'];
?>

</body>

</html>
