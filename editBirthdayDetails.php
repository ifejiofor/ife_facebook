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
         <h3>Edit Bithday Details</h3>
      ';

      if ( userHaveNotClickedOnAnyButton() ) {
         $markup .= getMarkupForFormForEditingBirthdayDetailsAndSetValuesRetrievedFromDatabaseAsDefault();
      }
      else if ( saveButtonHaveBeenClicked() ) {
         $markup .= validateAndPossiblyUpdateBirthdayDetails();
      }
      else if ( cancelButtonHaveBeenClicked() ) {
         header( 'Location: aboutMe.php#Birthday' );
      }

      $markup .= '
      </div> <!-- end div.containerForEditForm -->
      ';
   }


   function getMarkupForFormForEditingBirthdayDetailsAndSetValuesRetrievedFromDatabaseAsDefault()
   {
      $rowContainingBirthdayDetails = retrieveFromDatabaseBirthdayDetails( $_SESSION['idOfLoggedInUser'] );

      $defaultDayOfBirth = $rowContainingBirthdayDetails['day_of_birth'];
      $defaultMonthOfBirth = $rowContainingBirthdayDetails['month_of_birth'];
      $defaultYearOfBirth = $rowContainingBirthdayDetails['year_of_birth'];

      return getMarkupForFormForEditingBirthdayDetails( $defaultDayOfBirth, 
         $defaultMonthOfBirth, $defaultYearOfBirth );
   }


   function validateAndPossiblyUpdateBirthdayDetails()
   {
      if ( userSelectedAnInvalidValueInTheForm() ) {
         return getMarkupForFormForEditingBirthdayDetails( $_POST['dayOfBirth'], 
            $_POST['monthOfBirth'], $_POST['yearOfBirth'] );
      }
      else if ( theDateSelectedByTheUserIsNotACalenderDate() ) {
         return
         ( 
            getMarkupForFormForEditingBirthdayDetails( $_POST['dayOfBirth'], 
               $_POST['monthOfBirth'], $_POST['yearOfBirth'] ) . 
            getMarkupToIndicateInvalidDate()
         );
      }
      else {  // the date selected by the user is valid
         updateInDatabaseBirthdayDetails();
         header( 'Location: aboutMe.php#Birthday' );
      }
 
   }


   function userSelectedAnInvalidValueInTheForm()
   {
      return $_POST['monthOfBirth'] == INVALID || $_POST['dayOfBirth'] == INVALID || 
         $_POST['yearOfBirth'] == INVALID;
   }


   function theDateSelectedByTheUserIsNotACalenderDate()
   {
      return !isValidCalenderDate( $_POST['dayOfBirth'], $_POST['monthOfBirth'], $_POST['yearOfBirth'] );
   }


   function getMarkupToIndicateInvalidDate()
   {
      return '
            <span class="errorMessageInEditForm">
               Invalid Date: <br />
               In ' . $_POST['yearOfBirth'] . ', there was no ' . 
               convertToNameOfMonth( $_POST['monthOfBirth'] ) . ' ' . $_POST['dayOfBirth'] . '.
               <br />
               Please select a valid date.
            </span>
      ';
   }
?>


<html>
   <head>
      <title>Edit Birthday</title>

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