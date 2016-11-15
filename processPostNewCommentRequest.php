<?php
   session_start();

   include_once 'includeFiles/functionsForInsertingDataIntoDatabase.php';
   include_once 'includeFiles/functionsForManagingLoginStatus.php';
   include_once 'includeFiles/usefulConstants.php';

   if ( userIsLoggedIn() && isset( $_POST['idOfStatusUpdate'] ) && isset( $_POST['commentText'] ) && $_POST['commentText'] != '' ) {
      insertIntoDatabaseCommentOfLoggedInUser();
      header( 'Location: index.php?requiredAction=viewComments&idOfRequiredStatusUpdate=' . $_POST['idOfStatusUpdate'] . '&offset=0' . '&numberOfRows=' . DEFAULT_NUMBER_OF_ROWS_FOR_COMMENTS . '#' . $_POST['idOfStatusUpdate'] );
   }
   else {
      header( 'Location: index.php' );
   }

?>