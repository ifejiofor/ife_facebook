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
    * I completed this version on 24th April 2017.
    *
    * My name is Ifechukwu Ejiofor.
    *
    * This file contains the homepage of 'ife_facebook.com'.
    *
    * *******************************************************************************************
    * * TODO:                                                                                   *
    * *  - I still need to give life to the "search ife_facebook" search bar                    *
    * *  - I still need to implement the forgotPassword.php page                                *
    * *  - I still need to include profile pictures and cover photos for each ife_facebook user *
    * *******************************************************************************************
    */

   session_start();

   include_once 'includeFiles/booleanFunctions.php';
   include_once 'includeFiles/functionsForCreatingMarkups.php';
   include_once 'includeFiles/functionsForStoringDataIntoSESSION.php';
   include_once 'includeFiles/usefulConstants.php';


   if ( userIsNotLoggedIn() ) {
      $markup = getMarkupForLoggedOutVersionOfIfeFacebookHomepage();
   }
   else {
      $markup = 
         getMarkupForHeader() .
         getMarkupForTheOpeningTagOfMainBodyDiv() .
            getMarkupToDisplayTextAreaForPostingStatusUpdate() .
            getMarkupToDisplayLinkForRefreshingThisPage();

      if ( userHasNotClickedOnAnyLink() ) {
         $idOfStatusUpdates = retrieveFromDatabaseAndReturnInArrayIdOfSomeStatusUpdatesThatWerePostedByLoggedInUserOrHisFriends( 
            DEFAULT_OFFSET, DEFAULT_NUMBER_OF_ROWS_FOR_STATUS_UPDATES );
         storeIntoSESSIONInformationAboutStatusUpdates( DEFAULT_OFFSET, $idOfStatusUpdates );

         // Because, the user may have new friends probably because of a friend request being accepted e.t.c.
         storeIntoSESSIONIdOfAllFriendsAndTotalNumberOfFriendsOfLoggedInUser();

         $markup .=
            getMarkupToDisplaySomeImportantNotifications() .
            getMarkupToDisplayAllStatusUpdatesContainedInArray( $idOfStatusUpdates );
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
         $idOfStatusUpdates = retrieveFromDatabaseAndReturnInArrayIdOfSomeStatusUpdatesThatWerePostedByLoggedInUserOrHisFriends(
            $_GET['offsetForStatusUpdates'], $_GET['numberOfStatusUpdatesToBeDisplayed'] );
         storeIntoSESSIONInformationAboutStatusUpdates( $_GET['offsetForStatusUpdates'], $idOfStatusUpdates );

         $markup .= getMarkupToDisplayAllStatusUpdatesContainedInArray( $idOfStatusUpdates );
      }

      $markup .= 
            getMarkupToDisplayLinkForViewingMoreStatusUpdatesThatWerePostedByLoggedInUserOrHisFriends() .
         getMarkupForClosingDivTag();
   }
?>

<html>
   <head>
      <title>Home | ife_facebook</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <link href="stylesheets/ife_facebookStylesheet.css" type="text/css" rel="stylesheet"/>
   </head>

   <body>
      <?php 
         echo $markup;
      ?>

   </body>
</html>