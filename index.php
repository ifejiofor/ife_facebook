<!DOCTYPE html>

<?php
   /* 
    * I recently learnt PHP and decided to develop a website so as to 
    * practice what I've learnt.
    *
    * I choose to call the website 'ife_facebook.com'.
    *
    * It is a social networking website that mimicks the basic functionalities 
    * (and some of the user interface) of Mark Zukerberg's 'facebook.com'.
    *
    * I started developing the website on 30th July 2016.
    *
    * My name is Ifechukwu Ejiofor.
    *
    * This file contains the homepage of 'ife_facebook.com'.
    */

   session_start();

   include_once 'includeFiles/functionsToBeUsedAsTestConditions.php';
   include_once 'includeFiles/functionsForCreatingMarkups.php';
   include_once 'includeFiles/functionsForStoringDataIntoSESSION.php';
   include_once 'includeFiles/usefulConstants.php';


   if ( userIsNotLoggedIn() ) {
      $markup = getMarkupForLoggedOutVersionOfIfeFacebookHomepage();
   }
   else {
      $markup = 
         getMarkupForHeader() . '

      <div class="loggedInBody">
      ' .
         getMarkupToDisplayTextAreaForPostingStatusUpdate() .
         getMarkupToDisplayLinkForRefreshingThisPage();

      if ( userHasNotClickedOnAnyLink() ) {
         $markup .= getMarkupToDisplaySomeStatusUpdatesFromDatabase( 0, DEFAULT_NUMBER_OF_ROWS_FOR_STATUS_UPDATES );
         storeIntoSESSIONInformationAboutStatusUpdates( 0, DEFAULT_NUMBER_OF_ROWS_FOR_STATUS_UPDATES );
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
         $markup .= getMarkupToDisplaySomeStatusUpdatesFromDatabase( $_GET['offsetForStatusUpdates'], $_GET['numberOfStatusUpdatesToBeDisplayed'] );
         storeIntoSESSIONInformationAboutStatusUpdates( $_GET['offsetForStatusUpdates'], $_GET['numberOfStatusUpdatesToBeDisplayed'] );
      }
    /*  else {
         header( 'Location: ' . $_SERVER['PHP_SELF'] );
      } */

      $markup .= 
         getMarkupToDisplayLinkForViewingMoreStatusUpdates() . '
      </div> <!-- end div.loggedInBody -->
      ';
   }
?>

<?php
   if ( userIsLoggedIn() ) {
      $markupContainingStylesheet = '
      <link href="stylesheets/genericStylesheet.css" type="text/css" rel="stylesheet" />
      <link href="stylesheets/stylesheetForLoggedInHeader.css" type="text/css" rel="stylesheet" />
      <link href="stylesheets/stylesheetForLoggedInBodyAndStatusUpdates.css" type="text/css" rel="stylesheet" />';
   }
   else {
      $markupContainingStylesheet = '
      <link href="stylesheets/stylesheetForHomepageWhenLoggedOut.css" type="text/css" rel="stylesheet" />';
   }
?>

<html>
   <head>
      <title>Home | ife_facebook</title>

      <?php
         echo $markupContainingStylesheet;
      ?>

   </head>

   <body>
      <?php 
         echo $markup;
      ?>

   </body>
</html>