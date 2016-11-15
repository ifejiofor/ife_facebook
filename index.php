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

   include_once 'includeFiles/functionsForManagingLoginStatus.php';
   include_once 'includeFiles/functionsForCreatingMarkups.php';
   include_once 'includeFiles/functionsForStoringDataIntoSESSION.php';
   include_once 'includeFiles/miscellaneousFunctions.php';
   include_once 'includeFiles/usefulConstants.php';

   if ( userIsNotLoggedIn() ) {
      $markup = '
      <header class="homepageHeader">' .
         getMarkupForIfeFacebookLogo() .
         getMarkupForLoginFormWithoutDefaultValues() . '
      </header>  <!-- end header.homepageHeader -->

      <div class="homepageBody">' .
         getMarkupForShortDescriptionOfIfeFacebook() .
         getMarkupForSignUpForm() . 
         getMarkupToDisplayLinkToSignUpPage() . '
      </div>  <!-- end div.homepageBody -->
      ';
   }
   else if ( logOutButtonHaveBeenClicked() ) {
      logTheUserOut();
   }
   else {
      $markup = 
         getMarkupForHeader() . '

      <div class="loggedInBody">
      ' .
         getMarkupToDisplayTextAreaForPostingStatusUpdate() .
         getMarkupToDisplayLinkForRefreshingThisPage();

      if ( userHaveNotClickedOnAnyButton() ) {
         $markup .= getMarkupToListStatusUpdatesFromDatabase( 0, DEFAULT_NUMBER_OF_ROWS_FOR_STATUS_UPDATES );
         storeIntoSESSIONInformationAboutStatusUpdates( 0, DEFAULT_NUMBER_OF_ROWS_FOR_STATUS_UPDATES );
      }
      else if ( userHaveClickedOnTheLinkForViewingComments() ) {
         $markup .= getMarkupToListStatusUpdatesFromSESSIONShowingCommentsOnTheRequiredStatusUpdate();
      }
      else if ( userHaveClickedOnTheLinkForViewingNamesOfLikers() ) {
         $markup .= getMarkupToListStatusUpdatesFromSESSIONShowingNamesOfLikersOfTheRequiredStatusUpdate();
      }
      else if ( userHaveClickedOnTheLinkForHidingComments() || userHaveClickedOnTheLinkForHidingNamesOfLikers() ) {
         $markup .= getMarkupToListStatusUpdatesFromSESSION();
      }
      else if ( userHaveClickedOnTheLinkForViewingMoreStatusUpdates() ) {
         $markup .= getMarkupToListStatusUpdatesFromDatabase( $_GET['offset'], $_GET['numberOfRows'] );
         storeIntoSESSIONInformationAboutStatusUpdates( $_GET['offset'], $_GET['numberOfRows'] );
      }
      else {
         header( 'Location: ' . $_SERVER['PHP_SELF'] );
      }

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