<?php
   include_once 'includeFiles/functionsForRetrievingDataFromDatabase.php';
   include_once 'includeFiles/miscellaneousFunctions.php';

   function storeIntoSESSIONIdOfAllFriendsAndTotalNumberOfFriendsOfLoggedInUser()
   {
      $friendCount = storeIntoSESSIONIdOfTheFirstSetOfFriends();
      $friendCount = storeIntoSESSIONIdOfTheSecondSetOfFriends( $friendCount );
      storeIntoSESSIONTotalNumberOfFriends( $friendCount );
   }


   function storeIntoSESSIONIdOfTheFirstSetOfFriends()
   {
      $idOfFirstSetOfFriends = 
         retrieveFromDatabaseAndReturnInArrayIdOfFirstSetOfFriends( $_SESSION['idOfLoggedInUser'] );

      for ( $index = 0; $index < sizeof( $idOfFirstSetOfFriends ); $index++ ) {
         $_SESSION['idOfFriend' . $index] = $idOfFirstSetOfFriends[$index];
      }

      return $index;
   }


   function storeIntoSESSIONIdOfTheSecondSetOfFriends( $friendCount )
   {
      $idOfSecondSetOfFriends =
         retrieveFromDatabaseAndReturnInArrayIdOfSecondSetOfFriends( $_SESSION['idOfLoggedInUser'] );

      for ( $index = 0; $index < sizeof( $idOfSecondSetOfFriends ); $index++ ) {
         $_SESSION['idOfFriend' . ( $friendCount + $index )] = $idOfSecondSetOfFriends[$index];
      }

      return $friendCount + $index;
   }


   function storeIntoSESSIONTotalNumberOfFriends( $friendCount )
   {
      $_SESSION['totalNumberOfFriends'] = $friendCount;
   }


   function storeIntoSESSIONFirstNameOfLoggedInUser()
   {
      $namesOfLoggedInUser = retrieveFromDatabaseFirstNameLastNameAndNickName( $_SESSION['idOfLoggedInUser'] );
      $_SESSION['firstName'] = $namesOfLoggedInUser['first_name'];
   }

   function storeIntoSESSIONRelevantDetailsAboutAllLanguagesExistingInDatabase()
   {
      storeIntoSESSIONIdOfAllLanguagesExistingInDatabase();
      $totalNumberOfLanguages = storeIntoSESSIONNamesOfAllLanguagesExistingInDatabase();
      storeIntoSESSIONTotalNumberOfAllLanguagesExistingInDatabase( $totalNumberOfLanguages );
   }

   function storeIntoSESSIONIdOfAllLanguagesExistingInDatabase()
   {
      $idOfAllLanguages = retrieveFromDatabaseAndReturnInArrayIdOfAllLanguagesExistingInDatabase();

      for ( $index = 0; $index < sizeof( $idOfAllLanguages ); $index++ ) {
         $_SESSION['idOfLanguage' . $index] = $idOfAllLanguages[$index];
      }

      return $index;
   }

   function storeIntoSESSIONNamesOfAllLanguagesExistingInDatabase()
   {
      $namesOfAllLanguages = retrieveFromDatabaseAndReturnInArrayNamesOfAllLanguagesExistingInDatabase();

      for ( $index = 0; $index < sizeof( $namesOfAllLanguages ); $index++ ) {
         $_SESSION['nameOfLanguage' . $index] = 
            capitalizeWordsThatShouldBeCapitalized( $namesOfAllLanguages[$index] );
      }

      return $index;
   }


   function storeIntoSESSIONTotalNumberOfAllLanguagesExistingInDatabase( $languageCount )
   {
      $_SESSION['totalNumberOfLanguages'] = $languageCount;
   }


   function storeIntoSESSIONInformationAboutStatusUpdates( $offset, $numberOfRows )
   {
      $idOfStatusUpdates = 
         retrieveFromDatabaseAndReturnInArrayIdOfStatusUpdates( $offset, $numberOfRows );

      for ( $index = 0; $index < sizeof( $idOfStatusUpdates ); $index++ ) {
         $_SESSION['idOfStatusUpdate' . $index] = $idOfStatusUpdates[$index];
      }

      $_SESSION['totalNumberOfStatusUpdatesStoredInSESSION'] = sizeof( $idOfStatusUpdates );
      $_SESSION['totalNumberOfStatusUpdatesDisplayedSoFar'] = $offset + sizeof( $idOfStatusUpdates );
   }


   function storeIntoSESSIONInformationAboutCommentsOnStatusUpdate( $idOfStatusUpdate, $offset, $numberOfRows )
   {
      $idOfAssociatedComments = retrieveFromDatabaseAndReturnInArrayIdOfComments( 
         $idOfStatusUpdate, $offset, $numberOfRows );

      $_SESSION['totalNumberOfCommentsCurrentlyListed'] = sizeof( $idOfAssociatedComments );
      $_SESSION['totalNumberOfCommentsDisplayedSoFar'] = $offset + sizeof( $idOfAssociatedComments );
   }


   function storeIntoSESSIONInformationAboutNamesOfLikers(  $idOfStatusUpdate, $offset, $numberOfRows  )
   {
      $idOfAssociatedLikers = 
         retrieveFromDatabaseAndReturnInArrayIdOfLikers( $idOfStatusUpdate, $offset, $numberOfRows );

      $_SESSION['totalNumberOfLikersCurrentlyListed'] = sizeof( $idOfAssociatedLikers );
      $_SESSION['totalNumberOfLikersDisplayedSoFar'] = $offset + sizeof( $idOfAssociatedLikers );
   }
?>