<?php
   function convertToNameOfMonth( $monthNumber )
   {
      $monthNames = array( 
         '', 
         'January', 
         'February', 
         'March', 
         'April', 
         'May', 
         'June', 
         'July', 
         'August', 
         'September', 
         'October', 
         'November', 
         'December'
      );

      if ( $monthNumber >= 1 && $monthNumber <= 12 ) {
         return $monthNames[$monthNumber];
      }
      else {
         return 'Error';
      }

   }


   /*
      TODO: I hope to improve this function to do more sophisticated capitalizations such as,
         capitalizing a name like 'dar es salaam' into 
         'Dar es Salaam' instead of 'Dar Es Salaam', e.t.c.
   */
   function capitalizeWordsThatShouldBeCapitalized( $requiredString )
   {
      $requiredString = strtolower( $requiredString );

      return ucwords( $requiredString );
   }

   /*
      TODO: I will write the definition of this function later when I'm chanced.
   */
   function isValidCalenderDate( $day, $month, $year ) {
      return true;
   } 


   function existsInDatabase( $valueRetrievedFromDatabase )
   {
      return $valueRetrievedFromDatabase != NULL && $valueRetrievedFromDatabase != false;
   }


   function doesNotExistInDatabase( $valueRetrievedFromDatabase )
   {
      return !existsInDatabase( $valueRetrievedFromDatabase );
   }

   function saveButtonHaveBeenClicked()
   {
      return isset( $_POST['saveButton'] );
   }


   function cancelButtonHaveBeenClicked()
   {
      return isset( $_POST['cancelButton'] );
   }


   function editLanguageButtonHaveBeenClicked()
   {
      return isset( $_POST['editLanguageButton'] );
   }


   function deleteLanguageButtonHaveBeenClicked()
   {
      return isset( $_POST['deleteLanguageButton'] );
   }


   function addNewLanguageButtonHaveBeenClicked()
   {
      return isset( $_POST['addNewLanguageButton'] );
   }


   function doneButtonHaveBeenClicked()
   {
      return isset( $_POST['doneButton'] );
   }


   function userHaveNotClickedOnAnyButton()
   {
      return !$_POST && !$_GET;
   }


   function userHaveClickedOnTheLinkForViewingComments()
   {
      return isset( $_GET['requiredAction'] ) && $_GET['requiredAction'] == 'viewComments';
   }


   function userHaveClickedOnTheLinkForHidingComments()
   {
      return isset( $_GET['requiredAction'] ) && $_GET['requiredAction'] == 'hideComments';
   }


   function userHaveClickedOnTheLinkForViewingMoreStatusUpdates()
   {
      return isset( $_GET['requiredAction'] ) && $_GET['requiredAction'] == 'viewMoreStatusUpdates';
   }


   function userHaveClickedOnTheLinkForViewingNamesOfLikers()
   {
      return isset( $_GET['requiredAction'] ) && $_GET['requiredAction'] == 'viewNamesOfLikers';
   }


   function userHaveClickedOnTheLinkForHidingNamesOfLikers()
   {
      return isset( $_GET['requiredAction'] ) && $_GET['requiredAction'] == 'hideNamesOfLikers';
   }


   function isValidEmailAddress( $email )
   {
      return !isNotValidEmailAddress( $email );
   }


   function isNotValidEmailAddress( $email )
   {
      if ( emailUserNameIsNotValid( $email ) ) {
         return true;
      }

      $startingIndexOfEmailProviderName = getStartingIndexOfEmailProviderName( $email );

      if ( emailProviderNameIsNotValid( $email, $startingIndexOfEmailProviderName ) ) {
         return true;
      }

      $startingIndexOfEmailProviderExtension = 
         getStartingIndexOfEmailProviderExtension( $email, $startingIndexOfEmailProviderName );

      if ( emailProviderExtensionIsNotValid( $email, $startingIndexOfEmailProviderExtension ) ) {
         return true;
      }

      return false;
   }


   function emailUserNameIsNotValid( $email )
   {

      for ( $index = 0; $index < strlen( $email ) && $email[$index] != '@' && 
         isValidEmailUserNameCharacter( $email[$index] ); $index++ )
         ;

      if ( $index == strlen( $email ) ) {
         return true;
      }

      if ( $email[$index] == '@' ) {
         return $index == 0;
      }

      if ( !isValidEmailUserNameCharacter( $email[$index] ) ) {
         return true;
      }

   }


   function isValidEmailUserNameCharacter( $char )
   {
      return  isAlpha( $char ) || isDigit( $char ) || 
         isSpecialCharacterAllowedInEmailUserName( $char );
   }


   function getStartingIndexOfEmailProviderName( $email )
   {
      for ( $index = 0; $email[$index] != '@'; $index++ )
         ;

      return $index + 1;
   }


   function emailProviderNameIsNotValid( $email, $startingIndexOfEmailProviderName )
   {

      for ( $index = $startingIndexOfEmailProviderName; $index < strlen( $email ) && 
         $email[$index] != '.' && isAlpha( $email[$index] ); $index++ )
         ;

      if ( $index == strlen( $email ) ) {
         return true;
      }

      if ( $email[$index] == '.' ) {
         return $index == $startingIndexOfEmailProviderName;
      }

      if ( !isAlpha( $email[$index] ) ) {
         return true;
      }

   }


   function getStartingIndexOfEmailProviderExtension( $email, $startingIndexOfEmailProviderName )
   {
      for ( $index = $startingIndexOfEmailProviderName; $email[$index] != '.'; $index++ )
         ;

      return $index + 1;
   }


   function emailProviderExtensionIsNotValid( $email, $startingIndexOfEmailProviderExtension )
   {
      for ( $index = $startingIndexOfEmailProviderExtension; $index < strlen( $email ) && 
         isAlpha( $email[$index] ) ; $index++ )
         ;

      if ( $index == strlen( $email ) ) {
         return $index == $startingIndexOfEmailProviderExtension;
      }

      if ( !isAlpha( $email[$index] ) ) {
         return true;
      }

   }


   function isNotValidPhoneNumber( $phoneNumber )
   {
      return !isValidPhoneNumber( $phoneNumber );
   }


   function isValidPhoneNumber( $phoneNumber )
   {
      if ( $phoneNumber[0] != '+' && $phoneNumber[0] != '0' ) {
         return false;
      }

      if ( $phoneNumber[0] == '+' && strlen( $phoneNumber ) != 14 ) {
         return false;
      }

      if ( $phoneNumber[0] == '0' && strlen( $phoneNumber ) != 11 ) {
         return false;
      }

      for ( $index = 1; $index < strlen( $phoneNumber ) && isDigit( $phoneNumber[$index] ); $index++ )
         ;

      if ( $index == strlen( $phoneNumber ) ) {
         return true;
      }

      if ( !isDigit( $phoneNumber[$index] ) ) {
         return false;
      }

   }


   function convertToPhoneNumberWithCountryCode( $phoneNumber, $countryCode = '+234' )
   {

      if (  $phoneNumber[0] == '0' ) {
         $phoneNumberWithCountryCode = $countryCode;

         for ( $index = 1; $index < strlen( $phoneNumber ); $index++ ) {
            $phoneNumberWithCountryCode .= $phoneNumber[$index];
         }

         return $phoneNumberWithCountryCode;
      }
      else {
         return $phoneNumber;
      }

   }


   function isNotValidUserName( $string )
   {
      return !isValidUserName( $string );
   }


   function isValidUserName( $string )
   {
      for ( $index = 0; $index < strlen( $string ); $index++ ) {

         if ( !isAlpha( $string[$index] ) &&  !isSpecialCharacterAllowedInOrdinaryUserName( $string[$index] ) ) {
            break;
         }

      }

      if ( $index == strlen( $string ) ) {
         return true;
      }

      if ( !isAlpha( $string[$index] ) &&  !isSpecialCharacterAllowedInOrdinaryUserName( $string[$index] ) ) {
         return false;
      }

   }


   function nameOfLanguageIsInvalid( $nameOfLanguage )
   {
      return !consistsOfAlphabetsAndSpacesOnly( $nameOfLanguage );
   }


   function consistsOfAlphabetsAndSpacesOnly( $string )
   {
      $atLeastOneAlphabetExists = false;

      for ( $index = 0; $index < strlen( $string ); $index++ ) {

         if ( !isAlpha( $string[$index] ) && $string[$index] != ' ' ) {
            break;
         }

         if ( isAlpha( $string[$index] ) ) {
            $atLeastOneAlphabetExists = true;
         }

      }

      if ( $index == strlen( $string ) ) {
         return $atLeastOneAlphabetExists;
      }

      if ( !isAlpha( $string[$index] ) && $string[$index] != ' ' ) {
         return false;
      }

   }


   function consistsOfAlphabetsOnly( $string )
   {
      for ( $index = 0; $index < strlen( $string ); $index++ ) {

         if ( !isAlpha( $string[$index] ) ) {
            break;
         }

      }

      if ( $index == strlen( $string ) ) {
         return true;
      }

      if ( !isAlpha( $string[$index] ) ) {
         return false;
      }

   }


   function isAlpha( $char )
   {
      $char = strtolower( $char );

      return $char == 'a' || $char == 'b'|| $char == 'c' || $char == 'd' || $char == 'e' || $char == 'f'
         || $char == 'g' || $char == 'h'|| $char == 'i'|| $char == 'j'|| $char == 'k'|| $char == 'l'
         || $char == 'm'|| $char == 'n'|| $char == 'o'|| $char == 'p'|| $char == 'q'|| $char == 'r'
         || $char == 's'|| $char == 't'|| $char == 'u'|| $char == 'v'|| $char == 'w'|| $char == 'x'
         || $char == 'y'|| $char == 'z';
   }


   function isDigit( $char )
   {
      return $char == '0' || $char == '1' || $char == '2' || $char == '3' || $char == '4' || 
         $char == '5' || $char == '6' || $char == '7' || $char == '8' || $char == '9';
   }


   function isSpecialCharacterAllowedInEmailUserName( $char )
   {
      return $char == '.' || $char == '_';
   }


   function isSpecialCharacterAllowedInOrdinaryUserName( $char )
   {
      return $char == '\'' || $char == '-';
   }


 /*  function printErrorMessageAndTerminateScript( $errorMessage )
   {
      session_destroy();

      die( '
      <html>
         <head>
            <title>Error!</title>
         </head>

         <body>
            <p>' . $errorMessage . '</p>

            <a href="' . $_SERVER['PHP_SELF'] . '">Go back</a>
         </body>
      </html>' );
   }
*/
?>