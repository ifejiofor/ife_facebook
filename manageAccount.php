<!DOCTYPE html>

<?php
   session_start();

   include_once 'includeFiles/functionsToBeUsedAsTestConditions.php';
   include_once 'includeFiles/functionsForCreatingMarkups.php';


   if ( userIsNotLoggedIn() ) {
      $markup = getMarkupToTellUserToLogIn();
   }
   else {
      $markup =
         getMarkupForHeader() . '

      <section class="mainSectionOfProfilePage">' .
         getMarkupForTopOfProfilePage( 'editAccountInformation.php' ) . '
         <p><a href="editUserNames.php">Edit your firstname, surname, or nickname.</a></p>
         <p><a href="editPassword.php">Change your password.</a></p>
         <p><a href="deactivateAccount.php">Deactivate your ife_facebook account.</a></p>
      </section>  <!-- end section.mainSectionOfProfilePage -->
      ';
   }
?>

<html>
   <head>
      <title>Manage Account | ife_facebook</title>
      <link href="stylesheets/genericStylesheet.css" type="text/css" rel="stylesheet" />
      <link href="stylesheets/stylesheetForLoggedInHeader.css" type="text/css" rel="stylesheet" />
      <link href="stylesheets/stylesheetForTopOfProfilePage.css" type="text/css" rel="stylesheet" />
   </head>

   <body>
      <?php
         echo $markup;
      ?>

   </body>
</html>