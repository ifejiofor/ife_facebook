<?php
   session_start();

   include_once 'includeFiles/functionsForInsertingDataIntoDatabase.php';
   include_once 'includeFiles/functionsForUpdatingDataInDatabase.php';
   include_once 'includeFiles/functionsForDeletingDataFromDatabase.php';
   include_once 'includeFiles/functionsToBeUsedAsTestConditions.php';

   if ( userIsLoggedIn() && userHaveClickedOnTheLikeButton() ) {
      insertIntoDatabaseEntryToIndicateThatLoggedInUserLikesStatusUpdate( $_POST['idOfStatusUpdate'] );
      updateInDatabaseIncrementNumberOfLikesByOne( $_POST['idOfStatusUpdate'] );
      header( 'Location: index.php?requiredAction=hideNamesOfLikers#' . $_POST['idOfStatusUpdate'] );
   }
   else if ( userIsLoggedIn() && userHaveClickedOnTheUnlikeButton() ) {
      deleteFromDatabaseEntryThatIndicatesThatLoggedInUserLikesStatusUpdate( $_POST['idOfStatusUpdate'] );
      updateInDatabaseDecrementNumberOfLikesByOne( $_POST['idOfStatusUpdate'] );
      header( 'Location: index.php?requiredAction=hideNamesOfLikers#' . $_POST['idOfStatusUpdate'] );
   }
   else {
      header( 'Location: index.php' );
   }
?>