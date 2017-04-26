<!DOCTYPE html>

<?php
   session_start();

   include_once 'includeFiles/booleanFunctions.php';
   include_once 'includeFiles/functionsForCreatingMarkups.php';

   if ( userIsNotLoggedIn() ) {
      $markup = getMarkupToTellUserToLogin();
   }
   else {
      $markup = 
      getMarkupForHeader() . '
      <div class="mainBody whiteContainerWithBorder">
         <h1 class="bigSizedText smallBottomMargin">Find Friends</h1>
         <p>Is there anybody you will like to be friends with on ife_facebook?</p>
      ';

      $defaultSearchQuery = isset( $_GET['searchQuery'] ) ? $_GET['searchQuery'] : NULL;
      $markup .= getMarkupForFormContainingSearchBarForSearchingForIfeFacebookUsers( $defaultSearchQuery );

      if ( userHasNotClickedOnAnyLink() && userHasAtLeastOnePendingFriendRequest() ) {
         $markup .= getMarkupToDisplayPendingFriendRequests();
      }
      else if ( userHasNotClickedOnAnyLink() && userHasNoPendingFriendRequest() ) {
         $markup .= getMarkupToDisplayAListOfUsersRecommendedForFriendship();
      }
      else if ( userNeedsToViewSearchResults() && userDidNotInputValidSearchQuery() ) {
         $markup .= 
            getMarkupForErrorMessageToIndicateThatSearchQueryIsNotValid() .
            getMarkupToDisplayAListOfUsersRecommendedForFriendship();
      }
      else if ( userNeedsToViewSearchResults() && userInputtedValidSearchQuery() ) {
         $markup .=
            getMarkupToDisplaySearchResultsContainingUsersWhoseNamesMatchSearchQuery(
               $_GET['searchQuery'], $_GET['offsetForSearchResults'], $_GET['numberOfSearchResultsToBeDisplayed'] ) .
            getMarkupForLinkForViewingPreviousSearchResults() .
            getMarkupForLinkForViewingMoreSearchResults();
      }

      $markup .= '
      </div>';
   }
?>

<html>
   <head>
      <title>Find Friends | ife_facebook</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <link href="stylesheets/ife_facebookStylesheet.css" type="text/css" rel="stylesheet"/>
   </head>

   <body>
      <?php 
         echo $markup;
      ?>

   </body>
</html>