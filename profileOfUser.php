<!DOCTYPE html>

<?php
   session_start();

   include_once 'includeFiles/booleanFunctions.php';
   include_once 'includeFiles/functionsForCreatingMarkups.php';
   include_once 'includeFiles/functionsForStoringDataIntoSESSION.php';
   include_once 'includeFiles/usefulConstants.php';


   if ( userIsNotLoggedIn() ) {
      $markup = getMarkupToTellUserToLogin();
      $nameOfRequiredUser = '';
   }
   else if ( !isset( $_GET['idOfRequiredUser'] ) && !isset( $_SESSION['idOfRequiredUser'] ) ) {
      header( 'Location: index.php' );
   }
   else if ( isset( $_GET['idOfRequiredUser'] ) && $_GET['idOfRequiredUser'] == $_SESSION['idOfLoggedInUser'] ) {
      header( 'Location: myProfile.php' );
   }
   else {

      if ( isset( $_GET['idOfRequiredUser'] ) ) {
         $_SESSION['idOfRequiredUser'] = $_GET['idOfRequiredUser'];
         header( 'Location: ' . $_SERVER['PHP_SELF'] );
      }

      $markup = 
      getMarkupForHeader() .
      getMarkupForTheOpeningTagOfMainBodyDiv() .
         getMarkupForTopOfProfilePageOfRequiredUser( 'profileOfUser.php' ) .
         getMarkupToDisplayLinkForRefreshingThisPage();

      if ( userHasNotClickedOnAnyLink() ) {
         $idOfStatusUpdates = retrieveFromDatabaseAndReturnInArrayIdOfSomeStatusUpdatesThatWerePostedByUser(
            $_SESSION['idOfRequiredUser'], DEFAULT_OFFSET, DEFAULT_NUMBER_OF_ROWS_FOR_STATUS_UPDATES );
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
            $_SESSION['idOfRequiredUser'], $_GET['offsetForStatusUpdates'], $_GET['numberOfStatusUpdatesToBeDisplayed'] );
         storeIntoSESSIONInformationAboutStatusUpdates( $_GET['offsetForStatusUpdates'], $idOfStatusUpdates );

         $markup .= getMarkupToDisplayAllStatusUpdatesContainedInArray( $idOfStatusUpdates );
      }

      $markup .= 
         getMarkupToDisplayLinkForViewingMoreStatusUpdatesThatWerePostedByUser( $_SESSION['idOfRequiredUser'] ) .
      getMarkupForClosingDivTag();

      $nameOfRequiredUser = getMarkupToDisplayFirstNameAndLastNameOfRequiredUser( $_SESSION['idOfRequiredUser'] );
   }
?>

<html>
   <head>
      <title><?php echo $nameOfRequiredUser ?>'s Timeline | ife_facebook</title>
      <meta name="viewport" content="width=device-width, content=1.0"/>
      <link href="stylesheets/ife_facebookStylesheet.css" type="text/css" rel="stylesheet"/>
   </head>

   <body>
      <?php 
         echo $markup;
      ?>

   </body>
</html>