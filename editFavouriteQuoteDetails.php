<!DOCTYPE html>

<?php
   session_start();

   include_once 'includeFiles/functionsForManagingLoginStatus.php';
   include_once 'includeFiles/functionsForCreatingMarkups.php';
   include_once 'includeFiles/functionsForRetrievingDataFromDatabase.php';
   include_once 'includeFiles/functionsForUpdatingDataInDatabase.php';
   include_once 'includeFiles/miscellaneousFunctions.php';

   if ( userIsNotLoggedIn() ) {
      $markup = getMarkupToTellTheUserToLogIn( $_SERVER['PHP_SELF'] );
   }
   else if ( logOutButtonHaveBeenClicked() ) {
      logTheUserOut();
   }
   else {
      $markup = 
         getMarkupForHeader() . '
      <div class="containerForEditForm">
         <h2>Edit Profile</h2>
         <h3>Edit Favourite Quotes</h3>
      ';

      if ( userHaveNotClickedOnAnyButton() ) {
         $markup .= 
            getMarkupForFormForEditingFavouriteQuoteDetailsWithValuesRetrievedFromDatabaseAsDefault();
      }
      else if ( saveButtonHaveBeenClicked() ) {
         $markup .= validateAndPossiblyUpdateFavouriteQuoteDetails();
      }
      else if ( cancelButtonHaveBeenClicked() ) {
         header( 'Location: aboutMe.php#Favourite Quotes' );
      }

      $markup .= '
      </div> <!-- end div.containerForEditForm -->'; 
   }


   function getMarkupForFormForEditingFavouriteQuoteDetailsWithValuesRetrievedFromDatabaseAsDefault()
   {
      $rowContainingFavouriteQuoteDetails = 
         retrieveFromDatabaseFavouriteQuoteDetails( $_SESSION['idOfLoggedInUser'] );

      return getMarkupForFormForEditingFavouriteQuoteDetails( 
         $rowContainingFavouriteQuoteDetails['favourite_quotes'] );
   }


   function validateAndPossiblyUpdateFavouriteQuoteDetails()
   {

      if ( userDidNotInputHisFavouriteQuotes() ) {
         return getMarkupForFormForEditingFavouriteQuoteDetails( INVALID );
      }
      else {
         updateInDatabaseFavouriteQuoteDetails();
         header( 'Location: aboutMe.php#Favourite Quotes' );
      }

   }


   function userDidNotInputHisFavouriteQuotes() {
      return $_POST['favouriteQuotes'] == '';
   }
?>

<html>
   <head>
      <title>Edit Favourite Quotes</title>
      <link href="stylesheets/genericStylesheet.css" type="text/css" rel="stylesheet"/>
      <link href="stylesheets/stylesheetForLoggedInHeaderAndLoggedInBody.css" type="text/css" rel="stylesheet"/>
      <link href="stylesheets/stylesheetForFormForEditingProfileDetails.css" type="text/css" rel="stylesheet"/>
   </head>

   <body>
      <?php
         echo $markup;
      ?>

   </body>
</html>