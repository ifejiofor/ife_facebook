<!DOCTYPE html>

<?php
   include_once 'includeFiles/functionsToBeUsedAsTestConditions.php';
   include_once 'includeFiles/miscellaneousFunctions.php';
   include_once 'includeFiles/functionsForInsertingDataIntoDatabase.php';
   include_once 'includeFiles/functionsForCreatingMarkups.php';


   if ( signUpFormHaveNotBeenShownToTheUser() ) {
     header( 'Location: index.php' );
   }
   else if ( signUpFormHaveBeenShownToTheUser() && userDidNotInputValidSignUpDetails() ) {
      redirectToThePageContainingSignUpFormAndTellThePageAboutInvalidUserInputs();
   }
   else if ( signUpFormHaveBeenShownToTheUser() && userInputtedValidSignUpDetails() ) {
      insertIntoDatabaseEntryForNewUserOfIfeFacebook();
      $markup = getMarkupToCongratulateUserForSuccessfullySigningUp();
   }
?>

<html>
   <head>
      <title>Signed Up Successfully | ife_facebook</title>
      <link href="stylesheets/stylesheetForProcessSignUpRequestPage.css" type="text/css" rel="stylesheet" />
   </head>

   <body>
      <?php
         echo $markup;
      ?>

   </body>
</html>