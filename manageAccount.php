<!DOCTYPE html>

<?php
   session_start();

   include_once 'includeFiles/booleanFunctions.php';
   include_once 'includeFiles/functionsForCreatingMarkups.php';


   if ( userIsNotLoggedIn() ) {
      $markup = getMarkupToTellUserToLogIn();
   }
   else {
      $markup =
      getMarkupForHeader() .
         getMarkupForTheOpeningTagOfMainBodyDiv() .
         getMarkupForTopOfProfilePageOfLoggedInUser( 'editAccountInformation.php' ) . '
         <p class="whiteContainerWithBorder bigTopPadding bigBottomPadding smallTopMargin"><a href="editUserNames.php">Edit your firstname, surname, or nickname.</a></p>
         <p class="whiteContainerWithBorder bigTopPadding bigBottomPadding smallTopMargin"><a href="editPassword.php">Change your password.</a></p>
         <p class="whiteContainerWithBorder bigTopPadding bigBottomPadding smallTopMargin"><a href="deactivateAccount.php">Deactivate your ife_facebook account.</a></p>' .
      getMarkupForClosingDivTag();
   }
?>

<html>
   <head>
      <title>Manage Account | ife_facebook</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <link href="stylesheets/ife_facebookStylesheet.css" type="text/css" rel="stylesheet" />
   </head>

   <body>
      <?php
         echo $markup;
      ?>

   </body>
</html>