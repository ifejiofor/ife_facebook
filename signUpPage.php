<!DOCTYPE html>
<?php
   session_start();

   include_once 'includeFiles/functionsForCreatingMarkups.php';
   include_once 'includeFiles/booleanFunctions.php';

   if ( userIsLoggedIn() ) {
      header( 'Location: index.php' );
   }
   else {
      $markup = '<div class="mainBody whiteContainerWithBorder">
            <h1 class="blueText centralizedText smallBottomMargin">Sign Up to <a href="index.php">ife_facebook</a></h1>
            ' .
            getMarkupForSignUpForm() . '
      </div>';
   }
?>

<html>
   <head>
      <title>Sign Up | ife_facebook</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
      <link href="stylesheets/ife_facebookStylesheet.css" type="text/css" rel="stylesheet"/>
   </head>

   <body>
      <?php
         echo $markup;
      ?>

   </body>
</html>