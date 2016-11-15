<?php

   function connectToDatabase( $nameOfDatabase )
   {
      $databaseHandle = mysql_connect( 'localhost', 'ifechukwu', 'password' );

      if ( connectionToDatabaseWasSuccessful( $databaseHandle )  &&  
         mysql_select_db( $nameOfDatabase, $databaseHandle ) != false )
      {
         return $databaseHandle;
      }
      else {
         $errorMessage = '
         <html>
            <head>
               <title>Error!</title>
            </head>

            <body>
               <p>Error! Could not connect to '  .  $nameOfDatabase . ' database: '  .  mysql_error() . '</p>
            </body>
         </html>
         ';

         // function 'die' is used to terminate execution of script and display an error message
         die( $errorMessage );
      }

   }


   function connectionToDatabaseWasSuccessful( $databaseHandle )
   {
      return $databaseHandle != false;
   }


   function sendQueryToDatabaseAndGetResult( $requiredQuery, $databaseHandle )
   {
      $result = mysql_query( $requiredQuery, $databaseHandle );

      if ( queryingOfDatabaseWasSuccessful( $result ) ) {
         return $result;
      }
      else {
         $errorMessage = '
         <html>
            <head>
               <title>Error!</title>
            </head>

            <body>
               <p>Error! Could not query the database: ' . mysql_error() . '</p>
               <p>Below is your query:</p>
               <p>'  .  $requiredQuery  .  '</p>
             </body>
         </html>
         ';

         // function 'die' is used to terminate execution of script and display an error message
         die( $errorMessage );
      }

   }


   function queryingOfDatabaseWasSuccessful( $resultOfQuery )
   {
      return $resultOfQuery != false;
   }


/*   function isNotEmpty( $rowFromResultOfQuery )
   {
      return $rowFromResultOfQuery != false;
   }
*/
?>