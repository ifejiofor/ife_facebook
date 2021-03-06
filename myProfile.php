<!DOCTYPE html>

<?php
   session_start();

   include_once 'includeFiles/booleanFunctions.php';
   include_once 'includeFiles/functionsForCreatingMarkups.php';
   include_once 'includeFiles/functionsForStoringDataIntoSESSION.php';
   include_once 'includeFiles/usefulConstants.php';

   if ( userIsNotLoggedIn() ) {
      $markup = getMarkupToTellUserToLogin();
   }
   else {
      $markup = 
         getMarkupForHeader() .
         getMarkupForTheOpeningTagOfMainBodyDiv() .
            getMarkupForTopOfProfilePageOfLoggedInUser( 'myProfile.php' ) .
            getMarkupToDisplayLinkForRefreshingThisPage();

      if ( userHasNotClickedOnAnyLink() ) {
         $idOfStatusUpdates = retrieveFromDatabaseAndReturnInArrayIdOfSomeStatusUpdatesThatWerePostedByUser(
            $_SESSION['idOfLoggedInUser'], DEFAULT_OFFSET, DEFAULT_NUMBER_OF_ROWS_FOR_STATUS_UPDATES );
         storeIntoSESSIONInformationAboutStatusUpdates( DEFAULT_OFFSET, $idOfStatusUpdates );

         $markup .= getMarkupToDisplayAllStatusUpdatesContainedInArray( $idOfStatusUpdates );
      }
      else if ( userHasClickedOnTheLinkForViewingComments() ) {
         $markup .= getMarkupToDisplayAllStatusUpdatesStoredInSESSIONAndShowCommentsOnTheRequiredStatusUpdate();
      }
      else if ( userHasClickedOnTheLinkForViewingNamesOfLikers() ) {
         $markup .= getMarkupToDisplayAllStatusUpdatesStoredInSESSIONAndShowNamesOfLikersOfTheRequiredStatusUpdate();
      }
      else if ( userHasClickedOnTheLinkForHidingComments() || userHasClickedOnTheLinkForHidingNamesOfLikers() ) {
         $markup .= getMarkupToDisplayAllStatusUpdatesStoredInSESSION();
      }
      else if ( userHasClickedOnTheLinkForViewingMoreStatusUpdates() ) {
         $idOfStatusUpdates = retrieveFromDatabaseAndReturnInArrayIdOfSomeStatusUpdatesThatWerePostedByUser(
            $_SESSION['idOfLoggedInUser'], $_GET['offsetForStatusUpdates'], $_GET['numberOfStatusUpdatesToBeDisplayed'] );
         storeIntoSESSIONInformationAboutStatusUpdates( $_GET['offsetForStatusUpdates'], $idOfStatusUpdates );
         
         $markup .= getMarkupToDisplayAllStatusUpdatesContainedInArray( $idOfStatusUpdates );
      }

      $markup .= 
            getMarkupToDisplayLinkForViewingMoreStatusUpdatesThatWerePostedByUser( $_SESSION['idOfLoggedInUser'] ) .
         getMarkupForClosingDivTag();
   }
?>

<html>
   <head>
      <title>My Timeline | ife_facebook</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <link href="stylesheets/ife_facebookStylesheet.css" type="text/css" rel="stylesheet"/>
   </head>

   <body>
      <?php 
         echo $markup;
      ?>

   </body>
</html>