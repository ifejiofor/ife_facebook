<!DOCTYPE html>
<?php
   include_once 'includeFiles/functionsForCreatingMarkups.php';

   $markup = getMarkupForSignUpForm();
?>

<html>
   <head>
      <title>Sign Up | ife_facebook </title>
      <link href="stylesheets/stylesheetForSignUpPage.css" type="text/css" rel="stylesheet"/>
   </head>

   <body>
      <h1 class="mainHeader">Sign Up to <a href="index.php" class="linkInMainHeader">ife_facebook</a></h1>

      <?php
         echo $markup
      ?>

   </body>
</html>