<!DOCTYPE html>

<?php
   include_once 'includeFiles/functionsForInsertingDataIntoDatabase.php';
   include_once 'includeFiles/functionsForRetrievingDataFromDatabase.php';
   include_once 'includeFiles/functionsForCreatingMarkups.php';
   include_once 'includeFiles/usefulConstants.php';


   if ( signUpFormHaveNotBeenShownToTheUser() ) {
     header( 'Location: index.php' );
   }
   else if ( signUpFormWasNotFilledCompletely() ) {
      header( 'Location: ' . $_POST['urlOfSourcePage'] . '?requiredAction=showThatSignUpFormWasNotFilledCompletely&firstName=' . $_POST['firstName'] . '&surname=' . $_POST['surname'] . '&userName=' . $_POST['userName'] . '&confirmationOfUserName=' . $_POST['confirmationOfUserName'] . ( userPasswordOrConfirmationOfUserPasswordHaveNotBeenProvided() ? '&userPasswordOrConfirmationOfUserPasswordHaveNotBeenProvided' : '' ) );
   }  
   else if ( userNameIsDifferentFromConfirmationOfUserName() ) {
      header( 'Location: ' . $_POST['urlOfSourcePage'] . '?requiredAction=showThatUserNameIsDifferentFromConfirmationOfUserName&firstName=' . $_POST['firstName'] . '&surname=' . $_POST['surname'] . '&userName=' . $_POST['userName'] . '&confirmationOfUserName=' . $_POST['confirmationOfUserName'] );
   }
   else if ( userPasswordIsDifferentFromConfirmationOfUserPassword() ) {
      header( 'Location: ' . $_POST['urlOfSourcePage'] . '?requiredAction=showThatUserPasswordIsDifferentFromConfirmationOfUserPassword&firstName=' . $_POST['firstName'] . '&surname=' . $_POST['surname'] . '&userName=' . $_POST['userName'] . '&confirmationOfUserName=' . $_POST['confirmationOfUserName'] );
   }
   else {
      $anotherUserWithTheSameUserName = 
         retrieveFromDatabaseUserIdBasedOnEmailAddressOrPhoneNumber( $_POST['userName'] );

      if ( existsInDatabase( $anotherUserWithTheSameUserName ) ) {
         header( 'Location: ' . $_POST['urlOfSourcePage'] . '?requiredAction=showThatUserNameAlreadyExists&firstName=' . $_POST['firstName'] . '&surname=' . $_POST['surname'] . '&userName=' . $_POST['userName'] . '&confirmationOfUserName=' . $_POST['confirmationOfUserName'] );
      }
      else {
         $resultOfInsertion = insertIntoDatabaseEntryForNewUserOfIfeFacebook();

         if ( $resultOfInsertion == INVALID_FIRST_NAME ) {
            header( 'Location: ' . $_POST['urlOfSourcePage'] . '?requiredAction=showThatFirstNameIsInvalid&firstName=' . $_POST['firstName'] . '&surname=' . $_POST['surname'] . '&userName=' . $_POST['userName'] . '&confirmationOfUserName=' . $_POST['confirmationOfUserName'] );
         }
         else if ( $resultOfInsertion == INVALID_SURNAME ) {
            header( 'Location: ' . $_POST['urlOfSourcePage'] . '?requiredAction=showThatSurnameIsInvalid&firstName=' . $_POST['firstName'] . '&surname=' . $_POST['surname'] . '&userName=' . $_POST['userName'] . '&confirmationOfUserName=' . $_POST['confirmationOfUserName'] );
         }
         else if ( $resultOfInsertion == INVALID_USER_NAME ) {
            header( 'Location: ' . $_POST['urlOfSourcePage'] . '?requiredAction=showThatUserNameIsInvalid&firstName=' . $_POST['firstName'] . '&surname=' . $_POST['surname'] . '&userName=' . $_POST['userName'] . '&confirmationOfUserName=' . $_POST['confirmationOfUserName'] );
         }
         else if ( $resultOfInsertion == INVALID_USER_PASSWORD ) {
            header( 'Location: ' . $_POST['urlOfSourcePage'] . '?requiredAction=showThatUserPasswordIsInvalid&firstName=' . $_POST['firstName'] . '&surname=' . $_POST['surname'] . '&userName=' . $_POST['userName'] . '&confirmationOfUserName=' . $_POST['confirmationOfUserName'] );
         }
         else if ( $resultOfInsertion == INSERTION_SUCCESSFUL ) {
            $markup = getMarkupToCongratulateUserForSuccessfullySigningUp();
         }

      }

   }


   function signUpFormHaveNotBeenShownToTheUser()
   {
      return !isset( $_POST['signUpButton'] );
   }


   function signUpFormWasNotFilledCompletely()
   {
      return $_POST['firstName'] == '' || $_POST['surname'] == '' || $_POST['userName'] == '' || 
         $_POST['confirmationOfUserName'] == '' || $_POST['userPassword'] == '' || 
         $_POST['confirmationOfUserPassword'] == '';
   }


   function userPasswordOrConfirmationOfUserPasswordHaveNotBeenProvided()
   {
      return $_POST['userPassword'] == '' || $_POST['confirmationOfUserPassword'] == '';
   }


   function userNameIsDifferentFromConfirmationOfUserName()
   {
      return $_POST['userName'] != $_POST['confirmationOfUserName'];
   }


   function userPasswordIsDifferentFromConfirmationOfUserPassword()
   {
      return $_POST['userPassword'] != $_POST['confirmationOfUserPassword'];
   }
?>

<html>
   <head>
      <title>Signed Up Successfully | ife_facebook</title>
   </head>

   <body>
      <?php
         echo $markup;
      ?>

   </body>
</html>