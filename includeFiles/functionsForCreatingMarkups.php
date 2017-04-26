<?php
   include_once 'includeFiles/functionsForRetrievingDataFromDatabase.php';
   include_once 'includeFiles/functionsForStoringDataIntoSESSION.php';
   include_once 'includeFiles/booleanFunctions.php';
   include_once 'includeFiles/miscellaneousFunctions.php';
   include_once 'includeFiles/usefulConstants.php';


   function getMarkupForHeader()
   {
      $notifications = 
         retrieveFromDatabaseAndReturnInArrayIdOfAllNotificationsThatAreMeantForLoggedInUserButHaveNotBeenRead();
      $numberOfNotifications = sizeof( $notifications );


      return '<header class="mainHeader fixedOnLargeScreens">
         <a href="index.php" class="floatedToLeft"><h1 class="ifeFacebookShortLogo">f</h1></a>

         <form class="floatedToLeft halfWidth">
            <input type="text" name="searchQuery" placeholder="Search ife_facebook" class="threeQuartersWidth" />
            <input type="submit" value="Search" class="blueButton" />
         </form>

         <nav class="floatedToLeft whiteHorizontalNavigationLinksWithoutBorders">
            <ul>
               <li><a href="myProfile.php">' . $_SESSION['firstName'] . '</a></li>
               <li><a href="index.php">Home</a></li>
               <li><a href="findFriends.php">Find Friends</a></li>
               <li><a href="notifications.php">Notifications' . ( $numberOfNotifications == 0 ? '' : '<span class="redBadge">' . $numberOfNotifications . '</span>' ) . '</a></li>
            </ul>
         </nav>

         <form method="POST" action="processLogoutRequest.php" class="floatedToLeft">
            <input type="submit" value="Log Out" name="logOutButton" class="blueButton" />
         </form>
      </header>
      ';
   }


   function getMarkupForTheOpeningTagOfMainBodyDiv()
   {
      return '
      <div class="mainBody">';
   }


   function getMarkupForClosingDivTag()
   {
      return '
      </div>';
   }


   function getMarkupForLoggedOutVersionOfIfeFacebookHomepage()
   {
      return '<div class="disappearsOnSmallScreens">
         <header class="mainHeader">
            <a href="index.php" class="floatedToLeft"><h1 class="ifeFacebookLongLogo">ife_facebook</h1></a>' .
            getMarkupForLoginFormThatDispaysOnSingleLine() . '
         </header>

         <div class="thirtyPercentWidth massiveTopMargin massiveLeftMargin floatedToLeft" >
            <img src="images/connectWithPeople.jpg" width="200px" height="200px" class="shortDescriptionImage" alt="connect with people that matter to you"/>
            <p class="bigSizedText">ife_facebook is an online community where you can connect with those that matter to you</p>
         </div>

         <div class="thirtyPercentWidth massiveTopMargin massiveRightMargin floatedToRight">
            <h1 class="transparentContainerWithoutBorder">Sign Up</h1>
            <p class="transparentContainerWithoutBorder">It\'s free and always will be.</p>
         ' . getMarkupForSignUpForm() . '
         </div>
      </div>

      <div class="disappearsOnLargeScreens">
            <header class="mainHeader">
               <a href="index.php"><h1 class="ifeFacebookLongLogo">ife_facebook</h1></a>
            </header>

            <h2 class="smallTopMargin">Log In</h2>' . 
            getMarkupForLoginFormThatDispaysOnMultipleLines() . '

            <p class="smallTopMargin">Don\'t have an ife_facebook account?</p>
            <p class="verySmallBottomMargin">Just click on the link below to sign up for free.</p>
            <a href="signUpPage.php" class="bigGreenButton">Sign Up</a>
      </div>';
   }


   function getMarkupForSignUpForm()
   {
      if ( isset( $_GET['requiredAction'] ) && $_GET['requiredAction'] == 'showThatSignUpFormWasNotFilledCompletely' ) {
         return getMarkupForSignUpFormAndShowThatTheFormWasNotFilledCompletely();
      }
      else if ( isset( $_GET['requiredAction'] ) && $_GET['requiredAction'] == 'showThatUserNameIsDifferentFromConfirmationOfUserName' ) {
         return getMarkupForSignUpFormAndShowThatUserNameIsDifferentFromConfirmationOfUserName();
      }
      else if ( isset( $_GET['requiredAction'] ) && $_GET['requiredAction'] == 'showThatUserPasswordIsDifferentFromConfirmationOfUserPassword' ) {
         return getMarkupForSignUpFormAndShowThatUserPasswordIsDifferentFromConfirmationOfUserPassword();
      }
      else if ( isset( $_GET['requiredAction'] ) && $_GET['requiredAction'] == 'showThatUserNameAlreadyExists' ) {
         return getMarkupForSignUpFormAndShowThatUserNameAlreadyExists();
      }
      else if ( isset( $_GET['requiredAction'] ) && $_GET['requiredAction'] == 'showThatUserInputtedInvalidSignUpDetails' ) {
         return getMarkupForSignUpFormAndShowThatUserInputtedInvalidSignUpDetails();
      }
      else {
         return getMarkupForSignUpFormWithoutErrorMessages();
      }

   }


   function getMarkupForSignUpFormAndShowThatTheFormWasNotFilledCompletely()
   {
      return
         getMarkupForTheOpeningTagOfNestedFormElement( 'POST', 'processSignUpRequest.php' ) .
            getMarkupForHiddenInputElementContainingUrlOfTheCurrentPage() .

            getMarkupForInputElementsForEnteringFirstNameAndSurname( $_GET['firstName'], $_GET['surname'] ) .
            getMarkupForErrorMessageIfValueIsEmpty( $_GET['firstName'], 'Enter your first name' ) .
            getMarkupForErrorMessageIfValueIsEmpty( $_GET['surname'], 'Enter your surname' ) .

            getMarkupForInputElementForEnteringEmailOrPhone( $_GET['userName'] ) .
            getMarkupForErrorMessageIfValueIsEmpty( $_GET['userName'], 'Enter your email address or phone number' ) .

            getMarkupForInputElementForReEnteringEmailOrPhone( $_GET['confirmationOfUserName'] ) .
            getMarkupForErrorMessageIfValueIsEmpty( $_GET['confirmationOfUserName'], 'Re-enter your email address or phone number' ) .

            getMarkupForInputElementsForEnteringPasswordAndConfirmationOfPassword() .
            getMarkupForErrorMessageIfPasswordWasNotPreviouslyFilledByUser( 'Enter your password as well as its confirmation' ) .

            getMarkupForSignUpButton() .
         getMarkupForTheClosingTagOfNestedFormElement();
   }


   function getMarkupForSignUpFormAndShowThatUserNameIsDifferentFromConfirmationOfUserName()
   {
      return
         getMarkupForTheOpeningTagOfNestedFormElement( 'POST', 'processSignUpRequest.php' ) .
            getMarkupForHiddenInputElementContainingUrlOfTheCurrentPage() .
            getMarkupForInputElementsForEnteringFirstNameAndSurname( $_GET['firstName'], $_GET['surname'] ) .

            getMarkupForInputElementForEnteringEmailOrPhone( $_GET['userName'] ) .
            getMarkupForInputElementForReEnteringEmailOrPhone( $_GET['confirmationOfUserName'] ) .
            getMarkupForErrorMessage( 'The email addresses (or phone numbers) you entered do not match' ) .

            getMarkupForInputElementsForEnteringPasswordAndConfirmationOfPassword() .
            getMarkupForSignUpButton() .
         getMarkupForTheClosingTagOfNestedFormElement();
   }


   function getMarkupForSignUpFormAndShowThatUserPasswordIsDifferentFromConfirmationOfUserPassword()
   {
      return
         getMarkupForTheOpeningTagOfNestedFormElement( 'POST', 'processSignUpRequest.php' ) .
            getMarkupForHiddenInputElementContainingUrlOfTheCurrentPage() .
            getMarkupForInputElementsForEnteringFirstNameAndSurname( $_GET['firstName'], $_GET['surname'] ) .
            getMarkupForInputElementForEnteringEmailOrPhone( $_GET['userName'] ) .
            getMarkupForInputElementForReEnteringEmailOrPhone( $_GET['confirmationOfUserName'] ) .

            getMarkupForInputElementsForEnteringPasswordAndConfirmationOfPassword() .
            getMarkupForErrorMessage( 'The passwords you entered do not match' ) .

            getMarkupForSignUpButton() .
         getMarkupForTheClosingTagOfNestedFormElement();
   }


   function getMarkupForSignUpFormAndShowThatUserNameAlreadyExists()
   {
      return
         getMarkupForTheOpeningTagOfNestedFormElement( 'POST', 'processSignUpRequest.php' ) .
            getMarkupForHiddenInputElementContainingUrlOfTheCurrentPage() .
            getMarkupForInputElementsForEnteringFirstNameAndSurname( $_GET['firstName'], $_GET['surname'] ) .

            getMarkupForInputElementForEnteringEmailOrPhone( $_GET['userName'] ) .
            getMarkupForInputElementForReEnteringEmailOrPhone( $_GET['confirmationOfUserName'] ) .
            getMarkupForErrorMessage( 'The email address (or phone number) you entered is already used by another ife_facebook user' ) .

            getMarkupForInputElementsForEnteringPasswordAndConfirmationOfPassword() .
            getMarkupForSignUpButton() .
         getMarkupForTheClosingTagOfNestedFormElement();
   }


   function getMarkupForSignUpFormAndShowThatUserInputtedInvalidSignUpDetails()
   {
      return
         getMarkupForTheOpeningTagOfNestedFormElement( 'POST', 'processSignUpRequest.php' ) .
            getMarkupForHiddenInputElementContainingUrlOfTheCurrentPage() .

            getMarkupForInputElementsForEnteringFirstNameAndSurname( $_GET['firstName'], $_GET['surname'] ) .
            getMarkupForErrorMessageIfValueIsAnInvalidName( $_GET['firstName'], 'Invalid first name' ) .
            getMarkupForErrorMessageIfValueIsAnInvalidName( $_GET['surname'], 'Invalid surname' ) .

            getMarkupForInputElementForEnteringEmailOrPhone( $_GET['userName'] ) .
            getMarkupForInputElementForReEnteringEmailOrPhone( $_GET['confirmationOfUserName'] ) .
            getMarkupForErrorMessageIfValueIsAnInvalidEmailAndInvalidPhone( $_GET['userName'], 'Invalid email address (or phone number)' ) .

            getMarkupForInputElementsForEnteringPasswordAndConfirmationOfPassword() .
            getMarkupForSignUpButton() .
         getMarkupForTheClosingTagOfNestedFormElement();
   }


   function getMarkupForSignUpFormWithoutErrorMessages()
   {
      return
         getMarkupForTheOpeningTagOfNestedFormElement( 'POST', 'processSignUpRequest.php' ) .
            getMarkupForHiddenInputElementContainingUrlOfTheCurrentPage() .
            getMarkupForInputElementsForEnteringFirstNameAndSurname() .
            getMarkupForInputElementForEnteringEmailOrPhone() .
            getMarkupForInputElementForReEnteringEmailOrPhone() .
            getMarkupForInputElementsForEnteringPasswordAndConfirmationOfPassword() .
            getMarkupForSignUpButton() .
         getMarkupForTheClosingTagOfNestedFormElement();
   }


   function getMarkupForHiddenInputElementContainingUrlOfTheCurrentPage()
   {
      return '
               <input type="hidden" name="urlOfSourcePage" value="' . $_SERVER['PHP_SELF'] . '" />
      ';
   }


   function getMarkupForInputElementsForEnteringFirstNameAndSurname( $defaultFirstName = NULL, $defaultSurname = NULL )
   {
      return '
               <div class="transparentContainerWithoutBorder">
                  <input type="text" name="firstName" placeholder="First name" value="' . $defaultFirstName . '" class="fortyEightPercentWidthOnLargeScreens floatedToLeftOnLargeScreens verySmallBottomMargin" />
                  <input type="text" name="surname" placeholder="Surname" value="' . $defaultSurname . '" class="fortyEightPercentWidthOnLargeScreens floatedToRightOnLargeScreens" />
               </div>
      ';
   }


   function getMarkupForInputElementForEnteringEmailOrPhone( $defaultUserName = NULL )
   {
      return '
               <div class="transparentContainerWithoutBorder">
                  <input type="text" name="userName" placeholder="Email address or phone number" value="' . $defaultUserName . '" class="fullWidth" />
               </div>
      ';
   }


   function getMarkupForInputElementForReEnteringEmailOrPhone( $defaultConfirmationOfUserName = NULL )
   {
      return '
               <div class="transparentContainerWithoutBorder">
                  <input type="text" name="confirmationOfUserName" placeholder="Re-enter email address or phone number" value="' . $defaultConfirmationOfUserName . '" class="fullWidth" />
               </div>
      ';
   }


   function getMarkupForInputElementsForEnteringPasswordAndConfirmationOfPassword()
   {
      return '
               <div class="transparentContainerWithoutBorder">
                  <input type="password" name="userPassword" placeholder="Password you will like to use for ife_facebook" class="fullWidth" />
               </div>

               <div class="transparentContainerWithoutBorder">
                  <input type="password" name="confirmationOfUserPassword" placeholder="Confirm password" class="fullWidth" />
               </div>
      ';
   }


   function getMarkupForSignUpButton()
   {
      return '
               <div class="transparentContainerWithoutBorder">
                  <input type="submit" name="signUpButton" value="Sign Up" class="bigGreenButton">
               </div>';
   }


   function getMarkupToCongratulateUserForSuccessfullySigningUp()
   {
      return '<section class="mainBody whiteContainerWithBorder">
         <h1 class="centralizedText blueText smallBottomMargin">Successfully Signed Up</h1>

         <p class="centralizedText smallBottomMargin">Congratulations! You\'ve successfully signed up with <a href="index.php" class="boldText">ife_facebook</a>.</p>

         <div class="whiteContainerWithBorder smallBottomMargin boxShadowEffect">
            <p class="darkGreyText">Your username is: <span class="smallSizedText">' . $_POST['userName'] . '</span></p>
            <p class="darkGreyText">Your password is: <span class="smallSizedText">' . $_POST['userPassword'] . '</span></p>
         </div>

         <p class="centralizedText smallBottomMargin">Keep the above details safe. You will always need them whenever you want to log in to <a href="index.php" class="boldText">ife_facebook</a>.</p>
         <p class="centralizedText smallBottomMargin">If you want to log in immediately, click on the link below:</p>
         <p class="centralizedText"><a href="index.php">Log in to ife_facebook</a></p>
      </section>';
   }


   function getMarkupToTellUserToReEnterLoginDetails()
   {

      if ( userInputtedIncorrectUserName() ) {
         return getMarkupToTellUserToReEnterLoginDetailsBecauseUserNameIsNotCorrect();
      }

      if ( userInputtedIncorrectPassword() ) {
         return getMarkupToTellUserToReEnterLoginDetailsBecausePasswordIsNotCorrect();
      }

   }


   function getMarkupToTellUserToReEnterLoginDetailsBecauseUserNameIsNotCorrect()
   {
      return '<div class="mainBody whiteContainerWithBorder">
            <h1 class="blueText smallBottomMargin">Incorrect Username</h1>
            <p class="smallBottomMargin">The email address or phone number you entered is not correct. Please, re-enter your login details.</p>' . 
            getMarkupForLoginFormThatDispaysOnMultipleLines( NULL, NULL ) . '
      </div>';
   }


   function getMarkupToTellUserToReEnterLoginDetailsBecausePasswordIsNotCorrect()
   {
      return '
      <div class="mainBody whiteContainerWithBorder">
            <h1 class="blueText smallBottomMargin">Incorrect Password</h1>
            <p class="smallBottomMargin">The password you entered is not correct. Please, re-enter your password.</p>' . 
            getMarkupForLoginFormThatDispaysOnMultipleLines( $_POST['userName'], NULL ) . '
      </div>';
   }


   function getMarkupForLoginFormThatDispaysOnSingleLine( $defaultUserName = NULL, $defaultUserPassword = NULL )
   {
      return '

            <form method="POST" action="processLoginRequest.php" class="transparentContainerWithoutBorder floatedToRight">' .
               getMarkupForHiddenInputElementThatKeepsTrackOfTheSourcePage() . '
               <div class="floatedToLeft verySmallRightMargin">
                  <label for="userName" class="smallSizedText whiteText displayAsBlock">Email or Phone</label>
                  <input type="text" id="userName" name="userName" value="' . $defaultUserName . '"/>
               </div>

               <div class="floatedToLeft verySmallRightMargin">
                  <label for="userPassword" class="smallSizedText whiteText displayAsBlock">Password</label>
                  <input type="password" id="userPassword" name="userPassword" value="' . $defaultUserPassword . '"/>
               </div>

               <div class="floatedToLeft massiveRightMargin">
                  <input type="submit" name="loginButton" value="Log In" class="blueButton verySmallTopMargin" />
               </div>
            </form>';
   }


   function getMarkupForLoginFormThatDispaysOnMultipleLines( $defaultUserName = NULL, $defaultUserPassword = NULL )
   {
      return '

            <form method="POST" action="processLoginRequest.php" class="transparentContainerWithBorder">' .
               getMarkupForHiddenInputElementThatKeepsTrackOfTheSourcePage() . '
               <div class="smallTopMargin">
                  <label for="userName" class="thirtyPercentWidth">Email or Phone:</label>
                  <input type="text" id="userName" name="userName" value="' . $defaultUserName . '"/>
               </div>

               <div class="smallTopMargin">
                  <label for="userPassword" class="thirtyPercentWidth">Password</label>
                  <input type="password" id="userPassword" name="userPassword" value="' . $defaultUserPassword . '"/>
               </div>

               <div class="smallTopMargin">
                 <input type="submit" name="loginButton" value="Log In" class="blueButton" />
               </div>
            </form>';
   }


   function getMarkupForHiddenInputElementThatKeepsTrackOfTheSourcePage()
   {
      /*
         The source page is the page where the user will be redirected to after he logs in
      */
      if ( isset( $_POST['urlOfSourcePage'] ) ) {
         return '
               <input type="hidden" name="urlOfSourcePage" value="'  .  $_POST['urlOfSourcePage']  .  '"/>
         ';
      }
      else {
         return '';
      }

   }


   function getMarkupToTellUserToLogin( $urlOfSourcePage = NULL )
   {
      return '
      <div class="mainBody whiteContainerWithBorder">
         <p class="bigSizedText smallTopMargin smallBottomMargin">You must login to continue</p>

         <form method="POST" action="index.php">
            <input type="hidden" name="urlOfSourcePage" value="' . ( $urlOfSourcePage == NULL ? $_SERVER['PHP_SELF'] : $urlOfSourcePage ) . '" />
            <input type="submit" value="Click Here To Log In" class="bigBlueButton"/>
         </form>
      </div>
      ';
   }


   function getMarkupToDisplayTextAreaForPostingStatusUpdate()
   {
      return '
         <form method="POST" action="processPostNewStatusUpdateRequest.php">
            <div>
               <label for="statusUpdateText" class="darkGreyText">What\'s on your mind? Post it.</label>
               <textarea id="statusUpdateText" name="statusUpdateText"></textarea>
            </div>

            <div class="lightBlueContainerWithBorder">
               <input type="submit" value="Post" class="bigBlueButton floatedToRight" />
            </div>
         </form>
      ';
   }


   function getMarkupToDisplayLinkForRefreshingThisPage()
   {
      return '
         <h1 class="moderateSizedText smallTopMargin">News Feed (<a href="' . $_SERVER['PHP_SELF'] . '">refresh</a>)</h1>
      ';
   }


   function getMarkupToDisplayAllStatusUpdatesContainedInArray( $arrayContainingIdOfStatusUpdates )
   {

      if ( $arrayContainingIdOfStatusUpdates == NULL ) {
         return '
         <p>Sorry, No relevant status update exists.</p>';
      }

      $list = '';

      for ( $index = 0; $index < sizeof( $arrayContainingIdOfStatusUpdates ); $index++ ) {
         $list .= getMarkupToDisplayStatusUpdateInDefaultFormat( $arrayContainingIdOfStatusUpdates[$index] );
      }

      return $list;
   }


   function getMarkupToDisplayAllStatusUpdatesStoredInSESSION()
   {
      $list = '';

      for ( $index = 0; $index < $_SESSION['totalNumberOfStatusUpdatesStoredInSESSION']; $index++ ) {
         $list .= 
            getMarkupToDisplayStatusUpdateInDefaultFormat( $_SESSION['idOfStatusUpdate' . $index] );
      }

      return $list;
   }


   function getMarkupToDisplayAllStatusUpdatesStoredInSESSIONAndShowCommentsOnTheRequiredStatusUpdate()
   {
      $list = '';

      for ( $index = 0; $index < $_SESSION['totalNumberOfStatusUpdatesStoredInSESSION']; $index++ ) {

         if ( $_SESSION['idOfStatusUpdate' . $index] == $_GET['idOfRequiredStatusUpdate'] ) {
            $list .= getMarkupToDisplayStatusUpdateShowingComments( $_SESSION['idOfStatusUpdate' . $index] );
         }
         else {
            $list .= getMarkupToDisplayStatusUpdateInDefaultFormat( $_SESSION['idOfStatusUpdate' . $index] );
         }

      }

      return $list;
   }


   function getMarkupToDisplayAllStatusUpdatesStoredInSESSIONAndShowNamesOfLikersOfTheRequiredStatusUpdate()
   {
      $list = '';

      for ( $index = 0; $index < $_SESSION['totalNumberOfStatusUpdatesStoredInSESSION']; $index++ ) {

         if ( $_SESSION['idOfStatusUpdate' . $index] == $_GET['idOfRequiredStatusUpdate'] ) {
            $list .= getMarkupToDisplayStatusUpdateShowingNamesOfLikers( $_SESSION['idOfStatusUpdate' . $index] );
         }
         else {
            $list .= getMarkupToDisplayStatusUpdateInDefaultFormat( $_SESSION['idOfStatusUpdate' . $index] );
         }

      }

      return $list;
   }


   function getMarkupToDisplayStatusUpdateInDefaultFormat( $idOfStatusUpdate )
   {
      $detailsOfStatusUpdate = retrieveFromDatabaseDetailsOfStatusUpdate( $idOfStatusUpdate );

      if ( doesNotExistInDatabase( $detailsOfStatusUpdate ) ) {
         return '
         <section class="whiteContainerWithBorder bigBottomMargin">Can\'t find this status update, it may have been deleted.</section>';
      }
      else {
         return '
         <section class="whiteContainerWithBorder noPadding bigBottomMargin" id="' . $detailsOfStatusUpdate['status_update_id'] . '">
            ' . getMarkupToDisplayHeaderAndBodyOfStatusUpdate( $detailsOfStatusUpdate ) . '

            <footer class="lightBlueContainerWithoutBorder topBorder">
               <section class="lightBlueContainerWithoutBorder noPadding verySmallBottomMargin bottomBorder">' .
                  getMarkupToDisplayLikeButtonOrUnlikeButton( $detailsOfStatusUpdate['status_update_id'] ) . 
                  getMarkupToDisplayLinkForViewingNamesOfLikers( $detailsOfStatusUpdate['number_of_likes'], $detailsOfStatusUpdate['status_update_id'] ) . '
               </section>

               <section class="lightBlueContainerWithoutBorder noPadding">' .
                  getMarkupToDisplayLinkForViewingComments( $detailsOfStatusUpdate['status_update_id'] ) .
                  getMarkupForPostCommentForm( $detailsOfStatusUpdate['status_update_id'] ) . '
               </section>
            </footer>
         </section>
         ';
      }

   }


   function getMarkupToDisplayStatusUpdateShowingComments( $idOfStatusUpdate )
   {
      $detailsOfStatusUpdate = retrieveFromDatabaseDetailsOfStatusUpdate( $idOfStatusUpdate );
      storeIntoSESSIONInformationAboutCommentsOnStatusUpdate( 
         $idOfStatusUpdate, $_GET['offsetForComments'], $_GET['numberOfCommentsToBeDisplayed'] );

      if ( doesNotExistInDatabase( $detailsOfStatusUpdate ) ) {
         return '
         <section class="whiteContainerWithBorder bigBottomMargin">Can\'t find this status update, it may have been deleted.</section>';
      }
      else {
         return '
         <section class="whiteContainerWithBorder noPadding bigBottomMargin" id="' . $detailsOfStatusUpdate['status_update_id'] . '">
            ' . getMarkupToDisplayHeaderAndBodyOfStatusUpdate( $detailsOfStatusUpdate ) . '

            <footer class="lightBlueContainerWithoutBorder topBorder">
               <section class="lightBlueContainerWithoutBorder noPadding verySmallBottomMargin bottomBorder">' .
                  getMarkupToDisplayLikeButtonOrUnlikeButton( $detailsOfStatusUpdate['status_update_id'] ) . 
                  getMarkupToDisplayLinkForViewingNamesOfLikers( $detailsOfStatusUpdate['number_of_likes'], $detailsOfStatusUpdate['status_update_id'] ) . '
               </section>

               <section class="lightBlueContainerWithoutBorder noPadding">' .
                  getMarkupToDisplayLinkForHidingComments( $detailsOfStatusUpdate['status_update_id'] ) .
                  getMarkupToDisplayGeneralHeadingForComments() .
                  getMarkupToDisplaySomeCommentsOnTheSpecifiedStatusUpdate( $detailsOfStatusUpdate['status_update_id'], 
                     $_GET['offsetForComments'], $_GET['numberOfCommentsToBeDisplayed'] ) .  
                  getMarkupToDisplayLinkForViewingOlderComments( $detailsOfStatusUpdate['status_update_id'] ) .
                  getMarkupToDisplayLinkForViewingNewerComments( $detailsOfStatusUpdate['status_update_id'] ) .
                  getMarkupForPostCommentForm( $detailsOfStatusUpdate['status_update_id'] ) . '
               </section>
            </footer>
         </section>
         ';
      }

   }


   function getMarkupToDisplayStatusUpdateShowingNamesOfLikers( $idOfStatusUpdate )
   {
      $detailsOfStatusUpdate = retrieveFromDatabaseDetailsOfStatusUpdate( $idOfStatusUpdate );
      storeIntoSESSIONInformationAboutNamesOfLikers( 
         $idOfStatusUpdate, $_GET['offsetForNamesOfLikers'], $_GET['numberOfNamesOfLikersToBeDisplayed'] );

      if ( doesNotExistInDatabase( $detailsOfStatusUpdate ) ) {
         return '
         <section class="whiteContainerWithBorder bigBottomMargin">Can\'t find this status update, it may have been deleted.</section>';
      }
      else {
         return '
         <section class="whiteContainerWithBorder noPadding bigBottomMargin" id="' . $detailsOfStatusUpdate['status_update_id'] . '">
            ' . getMarkupToDisplayHeaderAndBodyOfStatusUpdate( $detailsOfStatusUpdate ) . '

            <footer class="lightBlueContainerWithoutBorder topBorder">
               <section class="lightBlueContainerWithoutBorder noPadding verySmallBottomMargin bottomBorder">' .
                  getMarkupToDisplayLikeButtonOrUnlikeButton( $detailsOfStatusUpdate['status_update_id'] ) . 
                  getMarkupToDisplayLinkForHidingNamesOfLikers(  $detailsOfStatusUpdate['status_update_id']  ) .
                  getMarkupToDisplayGeneralHeadingForNamesOfLikers() .
                  getMarkupToDisplaySomeNamesOfLikersOfTheSpecifiedStatusUpdate( $detailsOfStatusUpdate['status_update_id'], 
                     $_GET['offsetForNamesOfLikers'], $_GET['numberOfNamesOfLikersToBeDisplayed'] ) . 
                  getMarkupToDisplayLinkForViewingPreviousNamesOfLikers( $detailsOfStatusUpdate['status_update_id'] ) . 
                  getMarkupToDisplayLinkForViewingMoreNamesOfLikers( $detailsOfStatusUpdate['status_update_id'] ) . '
               </section>

               <section class="lightBlueContainerWithoutBorder noPadding">' .
                  getMarkupToDisplayLinkForViewingComments( $detailsOfStatusUpdate['status_update_id'] ) . 
                  getMarkupForPostCommentForm( $detailsOfStatusUpdate['status_update_id'] ) . '
               </section>
            </footer>
         </section>
         ';
      }

   }


   function getMarkupToDisplayHeaderAndBodyOfStatusUpdate( $detailsOfStatusUpdate )
   {
      $namesOfPoster = retrieveFromDatabaseFirstNameLastNameAndNickName( $detailsOfStatusUpdate['id_of_poster'] );

      if ( doesNotExistInDatabase( $namesOfPoster ) ) {
         return '<header class="whiteContainerWithoutBorder">There is something wrong with this status update.</header>';
      }
      else {
         return '<header class="whiteContainerWithoutBorder">
               <a href="profileOfUser.php?idOfRequiredUser=' . $detailsOfStatusUpdate['id_of_poster'] . '"><h2 class="moderateSizedText">' . $namesOfPoster['first_name'] . ' ' . $namesOfPoster['last_name'] . '</h2></a>
               <h3 class="smallSizedText darkGreyText">' . 
                  $detailsOfStatusUpdate['month_of_posting'] . ' ' . $detailsOfStatusUpdate['day_of_posting'] .
                  ' at ' . 
                  formatTimeShowingAmOrPm( $detailsOfStatusUpdate['hour_of_posting'], $detailsOfStatusUpdate['minute_of_posting'] ) .
               '</h3>
            </header>

            <div class="whiteContainerWithoutBorder">
               ' . $detailsOfStatusUpdate['status_update_text'] . '
            </div>';
      }

   }


   function getMarkupToDisplayLikeButtonOrUnlikeButton( $idOfStatusUpdate )
   {
      $markup = '
                  <form method="POST" action="processRequestToLikeOrUnlikeStatusUpdate.php">
                     <input type="hidden" name="idOfStatusUpdate" value="' . $idOfStatusUpdate . '" />
                     <input type="hidden" name="urlOfSourcePage" value="' . $_SERVER['PHP_SELF']  . '" />';

      if ( userLikesStatusUpdate( $_SESSION['idOfLoggedInUser'], $idOfStatusUpdate ) ) {
         $markup .= '
                     <input type="submit" name="unlikeButton" value="Unlike" class="blueButton" />';
      }
      else {
         $markup .= '
                     <input type="submit" name="likeButton" value="Like" class="blueButton" />';
      }

      $markup .= '
                  </form>';

      return $markup;
   }


   function getMarkupToDisplayLinkForViewingNamesOfLikers( $numberOfLikes, $idOfStatusUpdate )
   {
      $markup = '
                  <a href="' . $_SERVER['PHP_SELF'] . '?requiredAction=viewNamesOfLikers&idOfRequiredStatusUpdate=' . $idOfStatusUpdate . '&offsetForNamesOfLikers=0&numberOfNamesOfLikersToBeDisplayed=' . DEFAULT_NUMBER_OF_ROWS_FOR_LIKES . '#' . $idOfStatusUpdate . '">';

      if ( $numberOfLikes == 0 ) {
         $markup = '';
      }
      else if ( $numberOfLikes == 1 ) {
         $markup .= getMarkupToShowThatOnePersonLikesThisStatusUpdate( $idOfStatusUpdate ) . '</a>';
      }
      else if ( $numberOfLikes == 2 ) {
         $markup .= getMarkupToShowThatTwoPeopleLikeThisStatusUpdate( $idOfStatusUpdate ) . '</a>';
      }
      else if ( $numberOfLikes == 3 ) {
         $markup .= getMarkupToShowThatThreePeopleLikeThisStatusUpdate( $idOfStatusUpdate ) . '</a>';
      }
      else {
         $markup .= getMarkupToShowThatManyPeopleLikeThisStatusUpdate( $idOfStatusUpdate, $numberOfLikes ) . '</a>';
      }

      return $markup;
   }


   function getMarkupToShowThatOnePersonLikesThisStatusUpdate( $idOfStatusUpdate )
   {

      if ( loggedInUserHasFriendThatLikesThisStatusUpdate( $idOfStatusUpdate ) ) {
         $idOfFriend = getIdOfAnyFriendOfLoggedInUserThatLikesThisStatusUpdate( $idOfStatusUpdate );
         $namesOfLiker = retrieveFromDatabaseFirstNameLastNameAndNickName( $idOfFriend );
         return $namesOfLiker['first_name'] . ' ' . $namesOfLiker['last_name'] . ' likes this post.';
      }
      else {

         if ( userLikesStatusUpdate( $_SESSION['idOfLoggedInUser'], $idOfStatusUpdate ) ) {
            return 'You like this post.';
         }
         else {
            return 'One person likes this post.';
         }

      }

   }


   function getMarkupToShowThatTwoPeopleLikeThisStatusUpdate( $idOfStatusUpdate )
   {

      if ( loggedInUserHasFriendThatLikesThisStatusUpdate( $idOfStatusUpdate ) ) {
         $idOfFriend = getIdOfAnyFriendOfLoggedInUserThatLikesThisStatusUpdate( $idOfStatusUpdate );
         $namesOfLiker = retrieveFromDatabaseFirstNameLastNameAndNickName( $idOfFriend );

         if ( userLikesStatusUpdate( $_SESSION['idOfLoggedInUser'], $idOfStatusUpdate ) ) {
            return 'You and ' . $namesOfLiker['first_name'] . ' ' . $namesOfLiker['last_name'] . ' like this post.';
         }
         else {
            return $namesOfLiker['first_name'] . ' ' . $namesOfLiker['last_name'] . ' and one other person like this post.';
         }

      }
      else {

         if ( userLikesStatusUpdate( $_SESSION['idOfLoggedInUser'], $idOfStatusUpdate ) ) {
            return 'You and one other person like this post.';
         }
         else {
            return '2 people like this post.';
         }

      }

   }


   function getMarkupToShowThatThreePeopleLikeThisStatusUpdate( $idOfStatusUpdate )
   {

      if ( loggedInUserHasFriendThatLikesThisStatusUpdate( $idOfStatusUpdate ) ) {
         $idOfFriend = getIdOfAnyFriendOfLoggedInUserThatLikesThisStatusUpdate( $idOfStatusUpdate );
         $namesOfLiker = retrieveFromDatabaseFirstNameLastNameAndNickName( $idOfFriend );

         if ( userLikesStatusUpdate( $_SESSION['idOfLoggedInUser'], $idOfStatusUpdate ) ) {
            return 'You, ' . $namesOfLiker['first_name'] . ' ' . $namesOfLiker['last_name'] . ' and one other person like this post.';
         }
         else {
            return $namesOfLiker['first_name'] . ' ' . $namesOfLiker['last_name'] . ' and 2 other people like this post.';
         }

      }
      else {

         if ( userLikesStatusUpdate( $_SESSION['idOfLoggedInUser'], $idOfStatusUpdate ) ) {
            return 'You and 2 other people like this post.';
         }
         else {
            return '3 people like this post.';
         }

      }

   }


   function getMarkupToShowThatManyPeopleLikeThisStatusUpdate( $idOfStatusUpdate, $numberOfLikes )
   {

      if ( loggedInUserHasFriendThatLikesThisStatusUpdate( $idOfStatusUpdate ) ) {
         $idOfFriend = getIdOfAnyFriendOfLoggedInUserThatLikesThisStatusUpdate( $idOfStatusUpdate );
         $namesOfLiker = retrieveFromDatabaseFirstNameLastNameAndNickName( $idOfFriend );

         if ( userLikesStatusUpdate( $_SESSION['idOfLoggedInUser'], $idOfStatusUpdate ) ) {
            return 'You, ' . $namesOfLiker['first_name'] . ' ' . $namesOfLiker['last_name'] . ' and ' . ( $numberOfLikes - 2 ) . ' other people like this post.';
         }
         else {
            return $namesOfLiker['first_name'] . ' ' . $namesOfLiker['last_name'] . ' and ' . ( $numberOfLikes - 1 ) . ' other people like this post.';
         }

      }
      else {

         if ( userLikesStatusUpdate( $_SESSION['idOfLoggedInUser'], $idOfStatusUpdate ) ) {
            return 'You and ' . ( $numberOfLikes - 1 ) . ' other people like this post.';
         }
         else {
            return $numberOfLikes . ' people like this post.';
         }

      }

   }


   function getMarkupToDisplayLinkForViewingComments( $idOfStatusUpdate )
   {

      if ( atLeastOneCommentOnThisStatusUpdateExistsInDatabase( $idOfStatusUpdate ) ) {
         return '
                  <a href="' . $_SERVER['PHP_SELF'] . '?requiredAction=viewComments&idOfRequiredStatusUpdate=' . $idOfStatusUpdate . '&offsetForComments=0&numberOfCommentsToBeDisplayed=' . DEFAULT_NUMBER_OF_ROWS_FOR_COMMENTS . '#' . $idOfStatusUpdate .  '">View comments on this post.</a>';
      }
      else {
         return '';
      }

   }


   function getMarkupForPostCommentForm( $idOfStatusUpdate )
   {
      return '
                  <form method="POST" action="processPostNewCommentRequest.php" class="notFloating">
                     <input type="hidden" name="idOfStatusUpdate" value="' . $idOfStatusUpdate . '" />
                     <input type="hidden" name="urlOfSourcePage" value="' . $_SERVER['PHP_SELF'] . '" />
                     <input type="text" name="commentText" placeholder="Write a comment..." class="threeQuartersWidth" />
                     <input type="submit" value="Post" class="blueButton" />
                  </form>';
   }


   function getMarkupToDisplayLinkForHidingComments( $idOfStatusUpdate )
   {
      return '
                  <a href="' . $_SERVER['PHP_SELF'] . '?requiredAction=hideComments#' . $idOfStatusUpdate . '">Hide comments</a>';
   }


   function getMarkupToDisplayGeneralHeadingForComments()
   {
      return '
                  <h1 class="moderateSizedText">Comments on this post:</h1>
      ';
   }


   function getMarkupToDisplaySomeCommentsOnTheSpecifiedStatusUpdate( $idOfStatusUpdate, $offset, $numberOfComments )
   {
      $idOfComments = retrieveFromDatabaseAndReturnInArrayIdOfComments( $idOfStatusUpdate, $offset, $numberOfComments );

      $list = '';

      for ( $index = sizeof( $idOfComments ) - 1; $index >= 0; $index-- ) {
         $list .= getMarkupToDisplayComment( $idOfComments[$index] );
      }

      return $list;
   }


   function getMarkupToDisplayComment( $idOfComment )
   {
      $detailsOfComment = retrieveFromDatabaseDetailsOfComment( $idOfComment );

      if ( doesNotExistInDatabase( $detailsOfComment ) ) {
         return '
                  <section class="lightBlueContainerWithoutBorder">Couldn\'t find this comment, it must have been deleted.</section>';
      }

      $namesOfCommenter = 
         retrieveFromDatabaseFirstNameLastNameAndNickName( $detailsOfComment['id_of_commenter'] );

      if ( doesNotExistInDatabase( $namesOfCommenter ) ) {
         return '
                  <section class="lightBlueContainerWithoutBorder">There is something wrong with this comment.</section>';
      }

      return '
                  <section class="lightBlueContainerWithoutBorder">
                     <header class="smallRightMargin verySmallBottomMargin floatedToLeftOnLargeScreens">
                        <a href="profileOfUser.php?idOfRequiredUser=' . $detailsOfComment['id_of_commenter'] . '"><h2 class="moderateSizedText">' . $namesOfCommenter['first_name'] . ' ' . $namesOfCommenter['last_name'] . '</h2></a>
                        <h3 class="smallSizedText">' . 
                           $detailsOfComment['month_of_commenting'] . ' ' . $detailsOfComment['day_of_commenting'] . 
                           ' at ' . 
                           formatTimeShowingAmOrPm( $detailsOfComment['hour_of_commenting'], $detailsOfComment['minute_of_commenting'] ) . 
                        '</h3>
                     </header>

                     <p>
                        ' . $detailsOfComment['comment_text'] . '
                     </p>
                  </section>
         ';
   }


   function getMarkupToDisplayLinkForViewingOlderComments( $idOfStatusUpdate )
   {

      if ( atLeastOneOlderCommentOnThisStatusUpdateExistsInDatabase( $idOfStatusUpdate ) ) {
         return '
                  <a href="' . $_SERVER['PHP_SELF'] . '?requiredAction=viewComments&idOfRequiredStatusUpdate=' . $idOfStatusUpdate . '&offsetForComments=' . $_SESSION['totalNumberOfCommentsDisplayedSoFar'] . '&numberOfCommentsToBeDisplayed=' . DEFAULT_NUMBER_OF_ROWS_FOR_COMMENTS . '#' . $idOfStatusUpdate . '" class="floatedToLeft">&lt&ltView Older Comments</a>';
      }
      else {
         return '';
      }

   }


   function getMarkupToDisplayLinkForViewingNewerComments( $idOfStatusUpdate )
   {

      if ( $_SESSION['totalNumberOfCommentsDisplayedSoFar'] > DEFAULT_NUMBER_OF_ROWS_FOR_COMMENTS ) {
         return '
                  <a href="' . $_SERVER['PHP_SELF'] . '?requiredAction=viewComments&idOfRequiredStatusUpdate=' . $idOfStatusUpdate . '&offsetForComments=' . ( $_SESSION['totalNumberOfCommentsDisplayedSoFar'] - $_SESSION['totalNumberOfCommentsCurrentlyListed'] - DEFAULT_NUMBER_OF_ROWS_FOR_COMMENTS ) . '&numberOfCommentsToBeDisplayed=' . DEFAULT_NUMBER_OF_ROWS_FOR_COMMENTS . '#' . $idOfStatusUpdate .  '" class="floatedToRight">View Newer Comments&gt;&gt;</a>';
      }
      else {
         return '';
      }

   }


   function getMarkupToDisplayLinkForHidingNamesOfLikers( $idOfStatusUpdate )
   {
      return '
                  <a href="' . $_SERVER['PHP_SELF'] . '?requiredAction=hideNamesOfLikers#' . $idOfStatusUpdate . '">Hide names of likers</a>';
   }


   function getMarkupToDisplayGeneralHeadingForNamesOfLikers()
   {
      return '
                  <h1 class="moderateSizedText">The following people like this post:</h1>
      ';
   }


   function getMarkupToDisplaySomeNamesOfLikersOfTheSpecifiedStatusUpdate( $idOfStatusUpdate, $offset, $numberOfRows )
   {
      $idOfLikers = retrieveFromDatabaseAndReturnInArrayIdOfLikers( $idOfStatusUpdate, $offset, $numberOfRows );

      $list = '
                  <ul>';

      for ( $index = 0; $index < sizeof( $idOfLikers ); $index++ ) {
         $list .= getMarkupToDisplayNameOfLiker( $idOfLikers[$index] );
      }

      $list .= '
                  </ul>
      ';

      return $list;
   }


   function getMarkupToDisplayNameOfLiker( $idOfLiker )
   {
      $nameOfLiker = retrieveFromDatabaseFirstNameLastNameAndNickName( $idOfLiker );

      if ( doesNotExistInDatabase( $idOfLiker ) ) {
         return '
                     <li>Couldn\'t find the name of this liker, something is wrong somewhere</li>';
      }
      else {
         return '
                     <li><a href="profileOfUser.php?idOfRequiredUser=' . $idOfLiker . '">' . $nameOfLiker['first_name'] . ' ' . $nameOfLiker['last_name'] . '</a></li>';
      }

   }


   function getMarkupToDisplayLinkForViewingPreviousNamesOfLikers( $idOfStatusUpdate )
   {

      if ( $_SESSION['totalNumberOfLikersDisplayedSoFar'] > DEFAULT_NUMBER_OF_ROWS_FOR_LIKES ) {
         return '
                  <a href="' . $_SERVER['PHP_SELF'] . '?requiredAction=viewNamesOfLikers&idOfRequiredStatusUpdate=' . $idOfStatusUpdate . '&offsetForNamesOfLikers=' . ( $_SESSION['totalNumberOfLikersDisplayedSoFar'] - $_SESSION['totalNumberOfLikersCurrentlyListed'] - DEFAULT_NUMBER_OF_ROWS_FOR_LIKES ) . '&numberOfNamesOfLikersToBeDisplayed=' . DEFAULT_NUMBER_OF_ROWS_FOR_LIKES . '#' . $idOfStatusUpdate . '" class="floatedToLeft">&lt;&lt;View previous</a>';
      }
      else {
         return '';
      }

   }


   function getMarkupToDisplayLinkForViewingMoreNamesOfLikers( $idOfStatusUpdate )
   {

      if ( atLeastOneMoreLikerOfThisStatusUpdateExistsInDatabase( $idOfStatusUpdate ) ) {
         return '
                  <a href="' . $_SERVER['PHP_SELF'] . '?requiredAction=viewNamesOfLikers&idOfRequiredStatusUpdate=' . $idOfStatusUpdate . '&offsetForNamesOfLikers=' . $_SESSION['totalNumberOfLikersDisplayedSoFar'] . '&numberOfNamesOfLikersToBeDisplayed=' . DEFAULT_NUMBER_OF_ROWS_FOR_LIKES . '#' . $idOfStatusUpdate . '" class="floatedToRight">View more&gt;&gt;</a>';
      }
      else {
         return '';
      }

   }


   function getMarkupToDisplayLinkForViewingMoreStatusUpdatesThatWerePostedByLoggedInUserOrHisFriends()
   {

      if ( atLeastOneMoreStatusUpdateThatWasPostedByLoggedInUserOrHisFriendsExistsInDatabase()) {
         return '
         <a href="' . $_SERVER['PHP_SELF'] . '?requiredAction=viewMoreStatusUpdates&offsetForStatusUpdates=' . $_SESSION['totalNumberOfStatusUpdatesDisplayedSoFar'] . '&numberOfStatusUpdatesToBeDisplayed=' . DEFAULT_NUMBER_OF_ROWS_FOR_STATUS_UPDATES . '">View more posts&gt;&gt;</a>';
      }
      else {
         return '';
      }

   }


   function getMarkupToDisplayLinkForViewingMoreStatusUpdatesThatWerePostedByUser( $idOfUser )
   {
      if ( atLeastOneMoreStatusUpdateThatWasPostedByUserExistsInDatabase( $idOfUser ) ) {
         return '
         <a href="' . $_SERVER['PHP_SELF'] . '?requiredAction=viewMoreStatusUpdates&offsetForStatusUpdates=' . $_SESSION['totalNumberOfStatusUpdatesDisplayedSoFar'] . '&numberOfStatusUpdatesToBeDisplayed=' . DEFAULT_NUMBER_OF_ROWS_FOR_STATUS_UPDATES . '">View more posts&gt;&gt;</a>
         ';
      }
   }


   function getMarkupForTopOfProfilePageOfLoggedInUser( $urlOfCurrentProfilePage )
   {
      return '
         <div style="background-image: url( images/coverPhoto.jpg ); background-size: cover;" class="lightBlueContainerWithBorder disappearsOnSmallScreens whiteText">' .
            getMarkupToDisplayUserNamesOfUser( $_SESSION['idOfLoggedInUser'] )  . '
         </div>

         <div class="disappearsOnLargeScreens blackText">' .
            getMarkupToDisplayUserNamesOfUser( $_SESSION['idOfLoggedInUser'] )  . '
         </div>

         <nav class="blueHorizontalNavigationLinksWithBorders">
            <ul>
               <li><a href="myProfile.php" ' . ( $urlOfCurrentProfilePage == 'myProfile.php' ? 'id="currentPage"' : '' ) . '>Timeline</a></li>
               <li><a href="aboutMe.php" ' . ( $urlOfCurrentProfilePage == 'aboutMe.php' ? 'id="currentPage"' : '' ) . '>About</a></li>
               <li><a href="myFriends.php" ' . ( $urlOfCurrentProfilePage == 'myFriends.php' ? 'id="currentPage"' : '' ) . '>Friends&nbsp;<span class="smallSizedText">' . $_SESSION['totalNumberOfFriends'] . '</span></a></li>
               <li><a href="manageAccount.php" ' . ( $urlOfCurrentProfilePage == 'editAccountInformation.php' ? 'id="currentPage"' : '' ) . '>Manage Account</a></li>
            </ul>
         </nav>
      ';
   }


   function getMarkupForTopOfProfilePageOfRequiredUser( $urlOfCurrentProfilePage )
   {
      return '
         <div style="background-image: url( images/coverPhoto.jpg ); background-size: cover;" class="lightBlueContainerWithBorder disappearsOnSmallScreens whiteText">' .
            getMarkupToDisplayUserNamesOfUser( $_SESSION['idOfRequiredUser'] ) . '
            <div>' .
               getMarkupToIndicateFriendRelationshipBetweenLoggedInUserAndRequiredUser( $_SESSION['idOfRequiredUser'] ) . '
            </div>
         </div>

         <div class="disappearsOnLargeScreens blackText">' .
            getMarkupToDisplayUserNamesOfUser( $_SESSION['idOfRequiredUser'] ) . '
            <div>' .
               getMarkupToIndicateFriendRelationshipBetweenLoggedInUserAndRequiredUser( $_SESSION['idOfRequiredUser'] ) . '
            </div>
         </div>

         <nav class="blueHorizontalNavigationLinksWithBorders">
            <ul>
               <li><a href="profileOfUser.php" ' . ( $urlOfCurrentProfilePage == 'profileOfUser.php' ? 'id="currentPage"' : '' ) . '>Timeline</a></li>
               <li><a href="aboutUser.php" ' . ( $urlOfCurrentProfilePage == 'aboutUser.php' ? 'id="currentPage"' : '' ) . '>About</a></li>
               <li><a href="friendsOfUser.php" ' . ( $urlOfCurrentProfilePage == 'friendsOfUser.php' ? 'id="currentPage"' : '' ) . '>Friends</a></li>
            </ul>
         </nav>
      ';
   }


   function getMarkupToDisplayUserNamesOfUser( $idOfUser )
   {
      $names = retrieveFromDatabaseFirstNameLastNameAndNickName( $idOfUser );

      if ( doesNotExistInDatabase( $names ) ) {
         return '
            <div class="bigLeftMargin massiveTopMargin">Could not find user\'s name in database.</div>';
      }

      $markup = '
            <div class="bigLeftMarginOnLargeScreens massiveTopMarginOnLargeScreens bigBottomMarginOnLargeScreens">
               <h1 class="bigSizedText">'  .  $names['first_name']  .  ' '  .  $names['last_name']  .  '</h1>';

      if ( $names['nick_name'] != NULL ) {
         $markup .= '
               <h2 class="bigSizedText">('  .  $names['nick_name']  .  ')</h2>';
      }

      $markup .= '
            </div>
      ';

      return $markup;
   }


   function getMarkupToDisplayFirstNameAndLastNameOfRequiredUser( $idOfRequiredUser )
   {
      $names = retrieveFromDatabaseFirstNameLastNameAndNickName( $idOfRequiredUser );

      if ( doesNotExistInDatabase( $names ) ) {
         return '';
      }
      else {
         return $names['first_name']  .  ' '  .  $names['last_name'];
      }
   }


   function getMarkupToDisplayBirthdayDetailsOfLoggedInUser()
   {
      $birthdayDetails = retrieveFromDatabaseBirthdayDetails( $_SESSION['idOfLoggedInUser'] );
      $dayOfBirth = $birthdayDetails['day_of_birth'];

      if ( doesNotExistInDatabase( $dayOfBirth ) ) {
         return getMarkupToShowThatProfileDetailsOfLoggedInUserDoNotExist( 'Birthday', 'editBirthdayDetails.php' );
      }
      else {
         $formattedBirthdayDetails = formatBirthdayDetails( $birthdayDetails );

         return getMarkupToDisplayProfileDetailsOfLoggedInUser( 'Birthday', 
            'editBirthdayDetails.php', $formattedBirthdayDetails );
      }

   }


   function getMarkupToDisplayCurrentCityDetailsOfLoggedInUser()
   {
      $rowContainingIdOfCurrentCity = retrieveFromDatabaseIdOfCurrentCity( $_SESSION['idOfLoggedInUser'] );
      $idOfCurrentCity = $rowContainingIdOfCurrentCity['id_of_current_city'];

      if ( doesNotExistInDatabase( $idOfCurrentCity ) ) {
         return getMarkupToShowThatProfileDetailsOfLoggedInUserDoNotExist( 'Current City', 'editCurrentCityDetails.php' );
      }
      else {
         $rowContainingCurrentCityDetails = retrieveFromDatabaseCityDetails( $idOfCurrentCity );
         $formattedCurrentCityDetails = formatCityDetails( $rowContainingCurrentCityDetails );

         return getMarkupToDisplayProfileDetailsOfLoggedInUser( 'Current City',
            'editCurrentCityDetails.php', $formattedCurrentCityDetails );
      }

   }


   function getMarkupToDisplayHometownDetailsOfLoggedInUser()
   {
      $rowContainingIdOfHometown = retrieveFromDatabaseIdOfHometown( $_SESSION['idOfLoggedInUser'] );
      $idOfHometown = $rowContainingIdOfHometown['id_of_hometown'];

      if ( doesNotExistInDatabase( $idOfHometown ) ) {
         return getMarkupToShowThatProfileDetailsOfLoggedInUserDoNotExist( 'Hometown', 'editHometownDetails.php' );
      }
      else {
         $rowContainingHometownDetails = retrieveFromDatabaseCityDetails( $idOfHometown );
         $formattedHometownDetails = formatCityDetails( $rowContainingHometownDetails );

         return getMarkupToDisplayProfileDetailsOfLoggedInUser( 'Hometown',
            'editHometownDetails.php', $formattedHometownDetails );
      } 

   }


   function getMarkupToDisplayGenderDetailsOfLoggedInUser()
   {
      $rowContainingIdOfGender = retrieveFromDatabaseIdOfGender( $_SESSION['idOfLoggedInUser'] );
      $idOfGender = $rowContainingIdOfGender['id_of_gender'];

      if ( doesNotExistInDatabase( $idOfGender ) ) {
         return getMarkupToShowThatProfileDetailsOfLoggedInUserDoNotExist( 'Gender', 'editGenderDetails.php' );
      }
      else {
         $rowContainingGenderDetails = retrieveFromDatabaseGenderDetails( $idOfGender );
         $formattedGenderDetails = formatGenderDetails( $rowContainingGenderDetails );

         return getMarkupToDisplayProfileDetailsOfLoggedInUser( 'Gender', 
            'editGenderDetails.php', $formattedGenderDetails );
      }

   }


   function getMarkupToDisplayLanguageDetailsOfLoggedInUser()
   {
      $idOfAllLanguagesSpoken = 
         retrieveFromDatabaseAndReturnInArrayIdOfAllLanguagesSpoken( $_SESSION['idOfLoggedInUser'] );

      if ( doesNotExistInDatabase( $idOfAllLanguagesSpoken ) ) {
         return getMarkupToShowThatProfileDetailsOfLoggedInUserDoNotExist( 'Languages Spoken', 'editLanguagesSpokenDetails.php' );
      }
      else {
         $namesOfAllLanguagesSpoken = 
            retrieveFromDatabaseAndReturnInArrayNamesOfAllLanguagesSpoken( $idOfAllLanguagesSpoken );
         $formattedLanguageDetails = formatLanguageDetails( $namesOfAllLanguagesSpoken );

         return getMarkupToDisplayProfileDetailsOfLoggedInUser( 'Languages Spoken', 
            'editLanguagesSpokenDetails.php', $formattedLanguageDetails );
      }

   }


   function getMarkupToDisplayFavouriteQuoteDetailsOfLoggedInUser()
   {
      $rowContainingFavouriteQuoteDetails = 
         retrieveFromDatabaseFavouriteQuoteDetails( $_SESSION['idOfLoggedInUser'] );
      $favouriteQuoteDetails = $rowContainingFavouriteQuoteDetails['favourite_quotes'];

      if ( doesNotExistInDatabase( $favouriteQuoteDetails ) ) {
         return getMarkupToShowThatProfileDetailsOfLoggedInUserDoNotExist( 'Favourite Quotes',
            'editFavouriteQuoteDetails.php' );
      }
      else {
         $formattedFavouriteQuoteDetails = formatFavouriteQuoteDetails( $rowContainingFavouriteQuoteDetails );

         return getMarkupToDisplayProfileDetailsOfLoggedInUser( 'Favourite Quotes', 
            'editFavouriteQuoteDetails.php', $formattedFavouriteQuoteDetails );
      }

   }


   function getMarkupToDisplayAboutMeDetailsOfLoggedInUser()
   {
      $rowContainingAboutMeDetails = retrieveFromDatabaseAboutMeDetails( $_SESSION['idOfLoggedInUser'] );
      $aboutMeDetails = $rowContainingAboutMeDetails['about_me'];

      if ( doesNotExistInDatabase( $aboutMeDetails ) ) {
         return getMarkupToShowThatProfileDetailsOfLoggedInUserDoNotExist( 'About Me', 'editAboutMeDetails.php' );
      }
      else {
         $formattedAboutMeDetails = formatAboutMeDetails( $rowContainingAboutMeDetails );

         return getMarkupToDisplayProfileDetailsOfLoggedInUser( 'About Me', 
            'editAboutMeDetails.php', $formattedAboutMeDetails );
      }

   }


   function getMarkupToDisplayPhoneNumberDetailsOfLoggedInUser()
   {
      $rowContainingPhoneNumberDetails = retrieveFromDatabasePhoneNumberDetails( $_SESSION['idOfLoggedInUser'] );
      $phoneNumberDetails = $rowContainingPhoneNumberDetails['phone_number'];

      if ( doesNotExistInDatabase( $phoneNumberDetails ) ) {
         return getMarkupToShowThatProfileDetailsOfLoggedInUserDoNotExist( 'Phone Number', 'editPhoneNumberDetails.php' );
      }
      else {
         $formattedPhoneNumberDetails = formatPhoneNumberDetails( $rowContainingPhoneNumberDetails );
         return getMarkupToDisplayProfileDetailsOfLoggedInUser( 'Phone Number', 
            'editPhoneNumberDetails.php', $formattedPhoneNumberDetails );
      }

   }


   function getMarkupToDisplayEmailAddressDetailsOfLoggedInUser()
   {
      $rowContainingEmailAddressDetails = retrieveFromDatabaseEmailAddressDetails( $_SESSION['idOfLoggedInUser'] );
      $emailAddressDetails = $rowContainingEmailAddressDetails['email_address'];

      if ( doesNotExistInDatabase( $emailAddressDetails ) ) {
         return getMarkupToShowThatProfileDetailsOfLoggedInUserDoNotExist( 'Email Address', 'editEmailAddressDetails.php' );
      }
      else {
         $formattedEmailAddressDetails = formatEmailAddressDetails( $rowContainingEmailAddressDetails );
         return getMarkupToDisplayProfileDetailsOfLoggedInUser( 'Email Address', 
            'editEmailAddressDetails.php', $formattedEmailAddressDetails );
      }

   }


   function getMarkupToShowThatProfileDetailsOfLoggedInUserDoNotExist( $title, $urlOfEditLink )
   {
      return '

         <section class="smallTopMargin" id="' . $title . '">
            <header class="lightBlueContainerWithBorder">
               <h2 class="moderateSizedText">' . $title . '</h2>
            </header>

            <p class="whiteContainerWithBorder bigTopPadding bigBottomPadding">
               No ' . strtolower( $title ) . ' details existing. 
               <a href="' . $urlOfEditLink . '">Click here to add ' . strtolower( $title ) . ' details.</a>
            </p>
         </section>';
   }


   function getMarkupToDisplayProfileDetailsOfLoggedInUser( $title, $urlOfEditPage, $details )
   {
      return '

         <section class="smallTopMargin" id="' . $title . '">
            <header class="lightBlueContainerWithBorder">
               <h2 class="moderateSizedText floatedToLeft">' . $title . '</h2>
               <p class="floatedToRight"><a href="' . $urlOfEditPage . '">Edit</a></p>
            </header>

            <p class="whiteContainerWithBorder bigTopPadding bigBottomPadding">
               ' .  $details . '
            </p>
         </section>';
   }


   function getMarkupToDisplayBirthdayDetailsOfRequiredUser( $idOfRequiredUser )
   {
      $birthdayDetails = retrieveFromDatabaseBirthdayDetails( $idOfRequiredUser );
      $dayOfBirth = $birthdayDetails['day_of_birth'];

      if ( doesNotExistInDatabase( $dayOfBirth ) ) {
         return '';
      }
      else {
         $formattedBirthdayDetails = formatBirthdayDetails( $birthdayDetails );
         return getMarkupToDisplayProfileDetailsOfUserThatIsNotLoggedIn( 'Birthday', $formattedBirthdayDetails );
      }
   }


   function getMarkupToDisplayCurrentCityDetailsOfRequiredUser( $idOfRequiredUser )
   {
      $rowContainingIdOfCurrentCity = retrieveFromDatabaseIdOfCurrentCity( $idOfRequiredUser );
      $idOfCurrentCity = $rowContainingIdOfCurrentCity['id_of_current_city'];

      if ( doesNotExistInDatabase( $idOfCurrentCity ) ) {
         return '';
      }
      else {
         $rowContainingCurrentCityDetails = retrieveFromDatabaseCityDetails( $idOfCurrentCity );
         $formattedCurrentCityDetails = formatCityDetails( $rowContainingCurrentCityDetails );
         return 
            getMarkupToDisplayProfileDetailsOfUserThatIsNotLoggedIn( 'Current City', $formattedCurrentCityDetails );
      }

   }


   function getMarkupToDisplayHometownDetailsOfRequiredUser( $idOfRequiredUser )
   {
      $rowContainingIdOfHometown = retrieveFromDatabaseIdOfHometown( $idOfRequiredUser );
      $idOfHometown = $rowContainingIdOfHometown['id_of_hometown'];

      if ( doesNotExistInDatabase( $idOfHometown ) ) {
         return '';
      }
      else {
         $rowContainingHometownDetails = retrieveFromDatabaseCityDetails( $idOfHometown );
         $formattedHometownDetails = formatCityDetails( $rowContainingHometownDetails );
         return getMarkupToDisplayProfileDetailsOfUserThatIsNotLoggedIn( 'Hometown', $formattedHometownDetails );
      } 

   }


   function getMarkupToDisplayGenderDetailsOfRequiredUser( $idOfRequiredUser )
   {
      $rowContainingIdOfGender = retrieveFromDatabaseIdOfGender( $idOfRequiredUser );
      $idOfGender = $rowContainingIdOfGender['id_of_gender'];

      if ( doesNotExistInDatabase( $idOfGender ) ) {
         return '';
      }
      else {
         $rowContainingGenderDetails = retrieveFromDatabaseGenderDetails( $idOfGender );
         $formattedGenderDetails = formatGenderDetails( $rowContainingGenderDetails );
         return getMarkupToDisplayProfileDetailsOfUserThatIsNotLoggedIn( 'Gender', $formattedGenderDetails );
      }
   }


   function getMarkupToDisplayLanguageDetailsOfRequiredUser( $idOfRequiredUser )
   {
      $idOfAllLanguagesSpoken = 
         retrieveFromDatabaseAndReturnInArrayIdOfAllLanguagesSpoken( $idOfRequiredUser );

      if ( doesNotExistInDatabase( $idOfAllLanguagesSpoken ) ) {
         return '';
      }
      else {
         $namesOfAllLanguagesSpoken = 
            retrieveFromDatabaseAndReturnInArrayNamesOfAllLanguagesSpoken( $idOfAllLanguagesSpoken );
         $formattedLanguageDetails = formatLanguageDetails( $namesOfAllLanguagesSpoken );
         return
            getMarkupToDisplayProfileDetailsOfUserThatIsNotLoggedIn( 'Languages Spoken', $formattedLanguageDetails );
      }
   }


   function getMarkupToDisplayFavouriteQuoteDetailsOfRequiredUser( $idOfRequiredUser )
   {
      $rowContainingFavouriteQuoteDetails = retrieveFromDatabaseFavouriteQuoteDetails( $idOfRequiredUser );
      $favouriteQuoteDetails = $rowContainingFavouriteQuoteDetails['favourite_quotes'];

      if ( doesNotExistInDatabase( $favouriteQuoteDetails ) ) {
         return '';
      }
      else {
         $formattedFavouriteQuoteDetails = formatFavouriteQuoteDetails( $rowContainingFavouriteQuoteDetails );
         return getMarkupToDisplayProfileDetailsOfUserThatIsNotLoggedIn( 
            'Favourite Quotes', $formattedFavouriteQuoteDetails );
      }
   }


   function getMarkupToDisplayAboutMeDetailsOfRequiredUser( $idOfRequiredUser )
   {
      $rowContainingAboutMeDetails = retrieveFromDatabaseAboutMeDetails( $idOfRequiredUser );
      $aboutMeDetails = $rowContainingAboutMeDetails['about_me'];

      if ( doesNotExistInDatabase( $aboutMeDetails ) ) {
         return '';
      }
      else {
         $formattedAboutMeDetails = formatAboutMeDetails( $rowContainingAboutMeDetails );

         return getMarkupToDisplayProfileDetailsOfUserThatIsNotLoggedIn( 'About Me', $formattedAboutMeDetails );
      }
   }


   function getMarkupToDisplayProfileDetailsOfUserThatIsNotLoggedIn( $title, $details )
   {
      return '

         <section class="smallTopMargin">
            <header class="lightBlueContainerWithBorder">
               <h2 class="moderateSizedText">' . $title . '</h2>
            </header>

            <p class="whiteContainerWithBorder bigTopPadding bigBottomPadding">
               ' .  $details . '
            </p>
         </section>';
   }


   function getMarkupForEditBirthdayDetailsFormAndSetValuesRetrievedFromDatabaseAsDefaultValues()
   {
      $birthdayDetails = retrieveFromDatabaseBirthdayDetails( $_SESSION['idOfLoggedInUser'] );

      return
         getMarkupForTheOpeningTagOfFormElement() .
            getMarkupForTheOpeningTagOfNestedDivElement() .
               getMarkupForTheOpeningTagOfLabelElement( 'monthOfBirth' ) .
                  'Month of birth:' .
               getMarkupForTheClosingTagOfLabelElement() .
               getMarkupForSelectElementForSelectingMonthOfBirth( $birthdayDetails['month_of_birth'] ) .
            getMarkupForTheClosingTagOfNestedDivElement() .

            getMarkupForTheOpeningTagOfNestedDivElement() .
               getMarkupForTheOpeningTagOfLabelElement( 'dayOfBirth' ) .
                  'Day of birth:' .
               getMarkupForTheClosingTagOfLabelElement() .
               getMarkupForSelectElementForSelectingDayOfBirth( $birthdayDetails['day_of_birth'] ) .
            getMarkupForTheClosingTagOfNestedDivElement() .

            getMarkupForTheOpeningTagOfNestedDivElement() .
               getMarkupForTheOpeningTagOfLabelElement( 'yearOfBirth' ) .
                  'Year of birth:' .
               getMarkupForTheClosingTagOfLabelElement() .
               getMarkupForSelectElementForSelectingYearOfBirth( $birthdayDetails['year_of_birth'] ) .
            getMarkupForTheClosingTagOfNestedDivElement() .

            getMarkupForSaveButtonAndCancelButton() .
         getMarkupForTheClosingTagOfFormElement();
   }


   function getMarkupForEditBirthdayDetailsFormAndAppropriateErrorMessages()
   {

      if ( userSelectedInvalidDayOfBirth() || userSelectedInvalidMonthOfBirth() || userSelectedInvalidYearOfBirth() ) {
         return getMarkupForEditBirthdayDetailsFormAndShowThatUserSelectedInvalidDetails();
      }
      else if ( theDateSelectedByTheUserIsNotACalenderDate() ) {
         return getMarkupForEditBirthdayDetailsFormAndShowThatTheDateSelectedByUserIsNotCalenderDate();
      }

   }


   function getMarkupForEditBirthdayDetailsFormAndShowThatUserSelectedInvalidDetails()
   {
      return
         getMarkupForTheOpeningTagOfFormElement() .
            getMarkupForTheOpeningTagOfNestedDivElement() .
               getMarkupForTheOpeningTagOfLabelElement( 'monthOfBirth' ) .
                  'Month of birth:' .
               getMarkupForTheClosingTagOfLabelElement() .
               getMarkupForSelectElementForSelectingMonthOfBirth( $_POST['monthOfBirth'] ) .
               getMarkupForErrorMessageIfValueIsInvalid( $_POST['monthOfBirth'], 'Invalid&nbsp;month.' ) .
            getMarkupForTheClosingTagOfNestedDivElement() .

            getMarkupForTheOpeningTagOfNestedDivElement() .
               getMarkupForTheOpeningTagOfLabelElement( 'dayOfBirth' ) .
                  'Day of birth:' .
               getMarkupForTheClosingTagOfLabelElement() .
               getMarkupForSelectElementForSelectingDayOfBirth( $_POST['dayOfBirth'] ) .
               getMarkupForErrorMessageIfValueIsInvalid( $_POST['dayOfBirth'], 'Invalid&nbsp;day.' ) .
            getMarkupForTheClosingTagOfNestedDivElement() .

            getMarkupForTheOpeningTagOfNestedDivElement() .
               getMarkupForTheOpeningTagOfLabelElement( 'yearOfBirth' ) .
                  'Year of birth:' .
               getMarkupForTheClosingTagOfLabelElement() .
               getMarkupForSelectElementForSelectingYearOfBirth( $_POST['yearOfBirth'] ) .
               getMarkupForErrorMessageIfValueIsInvalid( $_POST['yearOfBirth'], 'Invalid&nbsp;year.' ) .
            getMarkupForTheClosingTagOfNestedDivElement() .

            getMarkupForSaveButtonAndCancelButton() .
         getMarkupForTheClosingTagOfFormElement();
   }


   function getMarkupForEditBirthdayDetailsFormAndShowThatTheDateSelectedByUserIsNotCalenderDate()
   {
      return
         getMarkupForTheOpeningTagOfFormElement() .
            getMarkupForTheOpeningTagOfNestedDivElement() .
               getMarkupForTheOpeningTagOfLabelElement( 'monthOfBirth' ) .
                  'Month of birth:' .
               getMarkupForTheClosingTagOfLabelElement() .
               getMarkupForSelectElementForSelectingMonthOfBirth( $_POST['monthOfBirth'] ) .
            getMarkupForTheClosingTagOfNestedDivElement() .

            getMarkupForTheOpeningTagOfNestedDivElement() .
               getMarkupForTheOpeningTagOfLabelElement( 'dayOfBirth' ) .
                  'Day of birth:' .
               getMarkupForTheClosingTagOfLabelElement() .
               getMarkupForSelectElementForSelectingDayOfBirth( $_POST['dayOfBirth'] ) .
            getMarkupForTheClosingTagOfNestedDivElement() .

            getMarkupForTheOpeningTagOfNestedDivElement() .
               getMarkupForTheOpeningTagOfLabelElement( 'yearOfBirth' ) .
                  'Year of birth:' .
               getMarkupForTheClosingTagOfLabelElement() .
               getMarkupForSelectElementForSelectingYearOfBirth( $_POST['yearOfBirth'] ) .
            getMarkupForTheClosingTagOfNestedDivElement() . '
            <div class="errorMessage">
               <p>Invalid Date:</p>
               <p>In ' . $_POST['yearOfBirth'] . ', there was no ' . convertToNameOfMonth( $_POST['monthOfBirth'] ) . ' ' . $_POST['dayOfBirth'] . '.</p>
               <p>Please select a valid date.</p>
            </div>
            ' .
            getMarkupForSaveButtonAndCancelButton() .
         getMarkupForTheClosingTagOfFormElement();
   }


   function getMarkupForSelectElementForSelectingMonthOfBirth( $defaultMonthOfBirth )
   {
      $selectElement = '
               <select id="monthOfBirth" name="monthOfBirth">
                  <option value="' . INVALID . '">----</option>';

      for ( $month = JANUARY; $month <= DECEMBER; $month++ ) {

         if ( $month == $defaultMonthOfBirth ) {
            $selectElement .= '
                  <option value="' . $month . '" selected>' . convertToNameOfMonth( $month ) . '</option>';
         }
         else {
            $selectElement .= '
                  <option value="' . $month . '">' . convertToNameOfMonth( $month ) . '</option>';
         }

      }

      $selectElement .= '
               </select>';

      return $selectElement;
   }


   function getMarkupForSelectElementForSelectingDayOfBirth( $defaultDayOfBirth )
   {
      $selectElement = '
               <select id="dayOfBirth" name="dayOfBirth">
                  <option value="' . INVALID . '">----</option>';

      for ( $day = 1; $day <= 31; $day++ ) {

         if ( $day == $defaultDayOfBirth ) {
            $selectElement .= '
                  <option value="' . $day . '" selected>' . $day . '</option>';
         }
         else {
            $selectElement .= '
                  <option value="' . $day . '">' . $day . '</option>';
         }

      }

      $selectElement .= '
               </select>';

      return $selectElement;
   }


   function getMarkupForSelectElementForSelectingYearOfBirth( $defaultYearOfBirth )
   {
      $selectElement = '
               <select id="yearOfBirth" name="yearOfBirth">
                  <option value="' . INVALID . '">----</option>';

      for ( $year = EARLIEST_YEAR; $year <= CURRENT_YEAR; $year++ ) {

         if ( $year == $defaultYearOfBirth ) {
            $selectElement .= '
                  <option value="' . $year . '" selected>' . $year . '</option>';
         }
         else {
            $selectElement .= '
                  <option value="' . $year . '">' . $year . '</option>';
         }

      }

      $selectElement .= '
               </select>';

      return $selectElement;
   }



   function getMarkupForEditCityDetailsFormAndSetCurrentCityValuesRetrievedFromDatabaseAsDefaultValues()
   {
      $rowContainingIdOfCity = retrieveFromDatabaseIdOfCurrentCity( $_SESSION['idOfLoggedInUser'] );

      if ( existsInDatabase( $rowContainingIdOfCity['id_of_current_city'] ) ) {
         $rowContainingCityDetails = retrieveFromDatabaseCityDetails( $rowContainingIdOfCity['id_of_current_city'] );
         $defaultNameOfCity = capitalizeWordsThatShouldBeCapitalized( $rowContainingCityDetails['name_of_city'] );
         $defaultNameOfCountry = capitalizeWordsThatShouldBeCapitalized( $rowContainingCityDetails['name_of_country'] );
      }
      else {
         $defaultNameOfCity = '';
         $defaultNameOfCountry = '';
      }

      return
         getMarkupForTheOpeningTagOfFormElement() .
            getMarkupForTheOpeningTagOfNestedDivElement() .
               getMarkupForTheOpeningTagOfLabelElement( 'nameOfCity' ) .
                  'Name of city:' .
               getMarkupForTheClosingTagOfLabelElement() .
               getMarkupForInputElementForEnteringNameOfCity( $defaultNameOfCity ) .
            getMarkupForTheClosingTagOfNestedDivElement() .

            getMarkupForTheOpeningTagOfNestedDivElement() .
               getMarkupForTheOpeningTagOfLabelElement( 'nameOfCountry' ) .
                  'Name of country:' .
               getMarkupForTheClosingTagOfLabelElement() .
               getMarkupForInputElementForEnteringNameOfCountry( $defaultNameOfCountry ) .
            getMarkupForTheClosingTagOfNestedDivElement() .

            getMarkupForSaveButtonAndCancelButton() .
         getMarkupForTheClosingTagOfFormElement();
   }


   function getMarkupForEditCityDetailsFormAndSetHometownValuesRetrievedFromDatabaseAsDefaultValues()
   {
      $row = retrieveFromDatabaseIdOfHometown( $_SESSION['idOfLoggedInUser'] );

      if ( existsInDatabase( $row['id_of_hometown'] ) ) {
         $row = retrieveFromDatabaseCityDetails( $row['id_of_hometown'] );
         $defaultNameOfCity = capitalizeWordsThatShouldBeCapitalized( $row['name_of_city'] );
         $defaultNameOfCountry = capitalizeWordsThatShouldBeCapitalized( $row['name_of_country'] );
      }
      else {
         $defaultNameOfCity = '';
         $defaultNameOfCountry = '';
      }

      return
         getMarkupForTheOpeningTagOfFormElement() .
            getMarkupForTheOpeningTagOfNestedDivElement() .
               getMarkupForTheOpeningTagOfLabelElement( 'nameOfCity' ) .
                  'Name of city:' .
               getMarkupForTheClosingTagOfLabelElement() .
               getMarkupForInputElementForEnteringNameOfCity( $defaultNameOfCity ) .
            getMarkupForTheClosingTagOfNestedDivElement() .

            getMarkupForTheOpeningTagOfNestedDivElement() .
               getMarkupForTheOpeningTagOfLabelElement( 'nameOfCountry' ) .
                  'Name of country:' .
               getMarkupForTheClosingTagOfLabelElement() .
               getMarkupForInputElementForEnteringNameOfCountry( $defaultNameOfCountry ) .
            getMarkupForTheClosingTagOfNestedDivElement() .

            getMarkupForSaveButtonAndCancelButton() .
         getMarkupForTheClosingTagOfFormElement();
   }


   function getMarkupForEditCityDetailsFormAndAppropriateErrorMessages()
   {
      return getMarkupForEditCityDetailsFormAndShowThatUserInputtedInvalidDetails();
   }


   function getMarkupForEditCityDetailsFormAndShowThatUserInputtedInvalidDetails()
   {

      return
         getMarkupForTheOpeningTagOfFormElement() .
            getMarkupForTheOpeningTagOfNestedDivElement() .
               getMarkupForTheOpeningTagOfLabelElement( 'nameOfCity' ) .
                  'Name of city:' .
               getMarkupForTheClosingTagOfLabelElement() .
               getMarkupForInputElementForEnteringNameOfCity( $_POST['nameOfCity'] ) .
               getMarkupForErrorMessageIfValueIsEmpty( $_POST['nameOfCity'], 'Enter the name of your city.' ) .
               getMarkupForErrorMessageIfValueConsistsOfSpacesOnly( $_POST['nameOfCity'], 'Invalid name of city' ) .
            getMarkupForTheClosingTagOfNestedDivElement() .

            getMarkupForTheOpeningTagOfNestedDivElement() .
               getMarkupForTheOpeningTagOfLabelElement( 'nameOfCountry' ) .
                  'Name of country:' .
               getMarkupForTheClosingTagOfLabelElement() .
               getMarkupForInputElementForEnteringNameOfCountry( $_POST['nameOfCountry'] ) .
               getMarkupForErrorMessageIfValueIsEmpty( $_POST['nameOfCountry'], 'Enter the name of your country.' ) .
               getMarkupForErrorMessageIfValueConsistsOfSpacesOnly( $_POST['nameOfCountry'], 'Invalid name of country' ) .
            getMarkupForTheClosingTagOfNestedDivElement() .

            getMarkupForSaveButtonAndCancelButton() .
         getMarkupForTheClosingTagOfFormElement();
   }


   function getMarkupForInputElementForEnteringNameOfCity( $defaultNameOfCity )
   {
      return '
               <input type="text" id="nameOfCity" name="nameOfCity" value="' . $defaultNameOfCity . '" />';
   }


   function getMarkupForInputElementForEnteringNameOfCountry( $defaultNameOfCountry )
   {
      return '
               <input type="text" id="nameOfCountry" name="nameOfCountry" value="' . $defaultNameOfCountry . '" />';
   }


   function getMarkupForEditGenderDetailsFormAndSetValueRetrievedFromDatabaseAsDefaultValue()
   {
      $row = retrieveFromDatabaseIdOfGender( $_SESSION['idOfLoggedInUser'] );

      if ( existsInDatabase( $row['id_of_gender'] ) ) {
         $row = retrieveFromDatabaseGenderDetails( $row['id_of_gender'] );
         $defaultGender = $row['name_of_gender'];
      }
      else {
         $defaultGender = NULL;
      }

      return
         getMarkupForTheOpeningTagOfFormElement() . '
            <p>Please, select your gender:</p>
            ' .

            getMarkupForTheOpeningTagOfNestedDivElement() .
               getMarkupForRadioButtonRepresentingMaleGender( $defaultGender ) .
               getMarkupForTheOpeningTagOfLabelElement( 'maleGender' ) .
                  'Male' .
               getMarkupForTheClosingTagOfLabelElement() .
            getMarkupForTheClosingTagOfNestedDivElement() .

            getMarkupForTheOpeningTagOfNestedDivElement() .
               getMarkupForRadioButtonRepresentingFemaleGender( $defaultGender ) .
               getMarkupForTheOpeningTagOfLabelElement( 'femaleGender' ) .
                  'Female' .
               getMarkupForTheClosingTagOfLabelElement() .
            getMarkupForTheClosingTagOfNestedDivElement() .

            getMarkupForSaveButtonAndCancelButton() .
         getMarkupForTheClosingTagOfFormElement();
   }


   function getMarkupForEditGenderDetailsFormAndAppropriateErrorMessage()
   {
      return getMarkupForEditGenderDetailsFormAndShowThatUserDidNotSelectAnyGender();
   }


   function getMarkupForEditGenderDetailsFormAndShowThatUserDidNotSelectAnyGender()
   {
      return
         getMarkupForTheOpeningTagOfFormElement() . '
            <p>Please, select your gender:</p>
            ' .

            getMarkupForTheOpeningTagOfNestedDivElement() .
               getMarkupForRadioButtonRepresentingMaleGender( NULL ) .
               getMarkupForTheOpeningTagOfLabelElement( 'maleGender' ) .
                  'Male' .
               getMarkupForTheClosingTagOfLabelElement() .
            getMarkupForTheClosingTagOfNestedDivElement() .

            getMarkupForTheOpeningTagOfNestedDivElement() .
               getMarkupForRadioButtonRepresentingFemaleGender( NULL ) .
               getMarkupForTheOpeningTagOfLabelElement( 'femaleGender' ) .
                  'Female' .
               getMarkupForTheClosingTagOfLabelElement() .
            getMarkupForTheClosingTagOfNestedDivElement() . '
            <span class="errorMessage">You did not select any gender.</span>
            ' .

            getMarkupForSaveButtonAndCancelButton() .
         getMarkupForTheClosingTagOfFormElement();
   }


   function getMarkupForRadioButtonRepresentingMaleGender( $defaultGender )
   {

      if ( $defaultGender == 'male' ) {
         return '
               <input type="radio" id="maleGender" name="genderDetails" value="male" checked/>';
      }
      else {
         return '
               <input type="radio" id="maleGender" name="genderDetails" value="male"/>';
      }

   }


   function getMarkupForRadioButtonRepresentingFemaleGender( $defaultGender )
   {

      if ( $defaultGender == 'female' ) {
         return '
               <input type="radio" id="femaleGender" name="genderDetails" value="female" checked/>';
      }
      else {
         return '
               <input type="radio" id="femaleGender" name="genderDetails" value="female"/>';
      }

   }


   function getMarkupForAddNewLanguageForm()
   {
      $languageNumber = getLanguageNumberToBeAssociatedWithNewLanguage();
      return getMarkupForEditLanguageForm( NEW_LANGUAGE, $languageNumber );
   }


   function getMarkupThatShowsAppropriateErrorMessagesInEditLanguageForm()
   {
      if ( userSelectedTheInvalidOption() ) {
         return getMarkupThatAllowsUserToEditTheRequiredLanguage();
      }
      else if ( userSelectedTheNoneOfTheAboveOption() && userDidNotSpecifyTheNameOfHisLanguage() ) {
         return getMarkupThatDisplaysTextFieldForSpecifyingNameOfLanguage();
      }
      else if ( userSelectedTheNoneOfTheAboveOption() && userSpecifiedInvalidNameOfLanguage() ) {
         return getMarkupThatDisplaysTextFieldForSpecifyingNameOfLanguage();
      }
      else if ( theSelectedLanguageAlreadyExistsInDatabaseAsLanguageSpokenByTheUser() &&
         userSpecifiedNameOfLanguageInATextBox() )
      {
         $row = retrieveFromDatabaseIdOfLanguageAssociatedWithNameOfLanguage( $_POST['nameOfNewLanguage'] );
         return 
               getMarkupThatDisplaysTextFieldForSpecifyingNameOfLanguage() .
               getMarkupToIndicateThatLanguageWasRepeated( $row['language_id'] );
      }
      else if ( theSelectedLanguageAlreadyExistsInDatabaseAsLanguageSpokenByTheUser() &&
         userDidNotSpecifyNameOfLanguageInATextBox() )
      {
         return 
            getMarkupThatAllowsUserToEditTheRequiredLanguage() .
            getMarkupToIndicateThatLanguageWasRepeated( $_POST['idOfSelectedLanguage'] );
      }
   }


   function getMarkupThatDisplaysAListOfAllLanguagesSpokenByUser()
   {
      $idOfLanguages = retrieveFromDatabaseAndReturnInArrayIdOfAllLanguagesSpoken( $_SESSION['idOfLoggedInUser'] );
      $list = '';

      for ( $index = 0; $index < sizeof( $idOfLanguages ); $index++ ) {
         $languageNumber = $index + 1;
         $list .= 
            getMarkupThatDisplaysNameOfLanguageWithEditButtonAndDeleteButton( $idOfLanguages[$index], $languageNumber );
      }

      return $list;
   }


   function getMarkupThatAllowsUserToEditTheRequiredLanguage()
   {
      $idOfLanguages = retrieveFromDatabaseAndReturnInArrayIdOfAllLanguagesSpoken( $_SESSION['idOfLoggedInUser'] );
      $list = '';

      for ( $index = 0; $index < sizeof( $idOfLanguages ); $index++ ) {
         $languageNumber = $index + 1;

         if ( $idOfLanguages[$index] ==  $_POST['idOfLanguageToBeEdited'] ) {
            $list .= getMarkupForEditLanguageForm( $_POST['idOfLanguageToBeEdited'], $languageNumber );
         }
         else {
            $list .= 
               getMarkupThatDisplaysNameOfLanguageWithEditButtonAndDeleteButton( $idOfLanguages[$index], $languageNumber );
         }
      }

      if ( $_POST['idOfLanguageToBeEdited'] == NEW_LANGUAGE ) {
         $languageNumber = sizeof( $idOfLanguages ) + 1;
         $list .= getMarkupForEditLanguageForm( NEW_LANGUAGE, $languageNumber );
      }

      return $list;
   }


   function getMarkupThatDisplaysTextFieldForSpecifyingNameOfLanguage()
   {
      $idOfLanguages = retrieveFromDatabaseAndReturnInArrayIdOfAllLanguagesSpoken( $_SESSION['idOfLoggedInUser'] );
      $list = '';

      for ( $index = 0; $index < sizeof( $idOfLanguages ); $index++ ) {
         $languageNumber = $index + 1;

         if ( $idOfLanguages[$index] ==  $_POST['idOfLanguageToBeEdited'] ) {
            $list .= getMarkupForEditLanguageFormWithTextFieldForSpecifyingNameOfLanguage( 
               $_POST['idOfLanguageToBeEdited'], $languageNumber );
         }
         else {
            $list .= getMarkupThatDisplaysNameOfLanguageWithEditButtonAndDeleteButton( 
               $idOfLanguages[$index], $languageNumber );
         }
      }

      if ( $_POST['idOfLanguageToBeEdited'] == NEW_LANGUAGE ) {
         $languageNumber = sizeof( $idOfLanguages ) + 1;
         $list .= getMarkupForEditLanguageFormWithTextFieldForSpecifyingNameOfLanguage(
            NEW_LANGUAGE, $languageNumber );
      }

      return $list;
   }


   function getMarkupThatDisplaysNameOfLanguageWithEditButtonAndDeleteButton( $idOfLanguage, $languageNumber )
   {
      $rowContainingNameOfLanguage = retrieveFromDatabaseNameOfLanguage( $idOfLanguage );

      if ( doesNotExistInDatabase( $rowContainingNameOfLanguage ) ) {
         return '';
      }

      $nameOfLanguage = $rowContainingNameOfLanguage['name_of_language'];
      return 
         getMarkupForTheOpeningTagOfSectionElementForLanguageEntry( $languageNumber ) .
            getMarkupForParagraphElementContainingLanguageNumber( $languageNumber ) .

            getMarkupForTheOpeningTagOfNestedFormElement( 'POST', 'editLanguagesSpokenDetails.php#' . $languageNumber ) .
               getMarkupForHiddenInputElementContainingLanguageNumber( $languageNumber ) .
               getMarkupForHiddenInputElementContainingIdOfLanguageToBeEdited( $idOfLanguage ) . '

               <p>' . capitalizeWordsThatShouldBeCapitalized( $nameOfLanguage ) . '</p>' .

               getMarkupForEditButtonAndDeleteButton() .
            getMarkupForTheClosingTagOfNestedFormElement() .
         getMarkupForTheClosingTagOfSectionElement();
   }


   function getMarkupForEditLanguageForm( $idOfLanguageToBeEdited, $languageNumber )
   {
      $idOfLanguageToBePreSelected =
         ( isset( $_POST['idOfSelectedLanguage'] ) ? $_POST['idOfSelectedLanguage'] : $idOfLanguageToBeEdited );

      return 
         getMarkupForTheOpeningTagOfSectionElementForLanguageEntry( $languageNumber ) .
            getMarkupForParagraphElementContainingLanguageNumber( $languageNumber ) .

            getMarkupForTheOpeningTagOfNestedFormElement( 'POST', 'editLanguagesSpokenDetails.php#' . $languageNumber ) .
               getMarkupForHiddenInputElementContainingLanguageNumber( $languageNumber ) .
               getMarkupForHiddenInputElementContainingIdOfLanguageToBeEdited( $idOfLanguageToBeEdited ) .
               getMarkupForSelectElementForSelectingLanguage( $idOfLanguageToBePreSelected ) .
               getMarkupForErrorMessageIfValueIsInvalid( $idOfLanguageToBePreSelected, 'Please, select a valid language' ) .
               getMarkupForSaveButtonAndCancelButton() .
            getMarkupForTheClosingTagOfNestedFormElement() .
         getMarkupForTheClosingTagOfSectionElement();
   }


   function getMarkupForEditLanguageFormWithTextFieldForSpecifyingNameOfLanguage( 
      $idOfLanguageToBeEdited, $languageNumber )
   {
      $idOfLanguageToBePreSelected = $_POST['idOfSelectedLanguage'];
      $nameOfNewLanguage = ( isset( $_POST['nameOfNewLanguage'] ) ? $_POST['nameOfNewLanguage'] : NULL );

      return 
         getMarkupForTheOpeningTagOfSectionElementForLanguageEntry( $languageNumber ) .
            getMarkupForParagraphElementContainingLanguageNumber( $languageNumber ) .

               getMarkupForTheOpeningTagOfFormElement( 'POST' , 'editLanguagesSpokenDetails.php#' . $languageNumber ) .
                  getMarkupForHiddenInputElementContainingLanguageNumber( $languageNumber ) .
                  getMarkupForHiddenInputElementContainingIdOfLanguageToBeEdited( $idOfLanguageToBeEdited ) .
                  getMarkupForSelectElementForSelectingLanguage( $idOfLanguageToBePreSelected ) .
                  getMarkupForTextFieldForSpecifyingNameOfLanguage( $nameOfNewLanguage ) .
                  getMarkupForErrorMessageIfValueIsEmpty( $nameOfNewLanguage, 'Please, specify the name of your language' ) .
                  getMarkupForErrorMessageIfValueIsAnInvalidNameOfLanguage( $nameOfNewLanguage, 'Invalid name of language' ) .
                  getMarkupForSaveButtonAndCancelButton() .
               getMarkupForTheClosingTagOfFormElement() .
         getMarkupForTheClosingTagOfSectionElement();
   }


   function getMarkupForTheOpeningTagOfSectionElementForLanguageEntry( $idValue )
   {
      return '
         <section class="whiteContainerWithBorder fortyFivePercentWidthOnLargeScreens boxShadowEffect smallTopPadding smallBottomPadding smallRightMargin smallBottomMargin floatedToLeft" id="' . $idValue . '">';
   }


   function getMarkupForTheClosingTagOfSectionElement()
   {
      return '
         </section>
      ';
   }


   function getMarkupForParagraphElementContainingLanguageNumber( $languageNumber )
   {
      return '
            <p class="floatedToLeft blueText smallRightMargin">LANGUAGE ' . $languageNumber . ': </p>
      ';
   }


   function getMarkupForHiddenInputElementContainingLanguageNumber( $languageNumber )
   {
      return '
               <input type="hidden" name="languageNumber" value="' . $languageNumber . '" />';
   }


   function getMarkupForHiddenInputElementContainingIdOfLanguageToBeEdited( $idOfLanguageToBeEdited )
   {
      return '
               <input type="hidden" name="idOfLanguageToBeEdited" value="' . $idOfLanguageToBeEdited . '" />';
   }


   function getMarkupForSelectElementForSelectingLanguage( $idOfDefaultLanguage = NULL )
   {
      $selectElement = '

               <select name="idOfSelectedLanguage">
                  <option value="' . INVALID . '">----</option>';

      if ( $idOfDefaultLanguage == NONE_OF_THE_ABOVE ) {
         $selectElement .= '
                  <option value="' . NONE_OF_THE_ABOVE . '" selected>My language is not listed</option>';
      }
      else {
         $selectElement .= '
                  <option value="' . NONE_OF_THE_ABOVE . '">My language is not listed</option>';
      }

      $idOfLanguages = retrieveFromDatabaseAndReturnInArrayIdOfAllLanguagesExistingInDatabase();
      $namesOfLanguages = retrieveFromDatabaseAndReturnInArrayNamesOfAllLanguagesExistingInDatabase();
      for ( $index = 0; $index < sizeof( $idOfLanguages ); $index++ ) {

         if ( $idOfLanguages[$index] == $idOfDefaultLanguage ) {
            $selectElement .= '
                  <option value="' . $idOfLanguages[$index] . '" selected>' . capitalizeWordsThatShouldBeCapitalized( $namesOfLanguages[$index] ) . '</option>';
         }
         else {
            $selectElement .= '
                  <option value="' . $idOfLanguages[$index] . '">' . capitalizeWordsThatShouldBeCapitalized( $namesOfLanguages[$index] ) . '</option>';
         }

      }

      $selectElement .= '
               </select>
      ';

      return $selectElement;
   }


   function getMarkupForTextFieldForSpecifyingNameOfLanguage( $defaultNameOfLanguage = NULL )
   {
      return '
               <div>
                  <label for="nameOfNewLanguage">What is the name of your language?</label>
                  <input type="text" id="nameOfNewLanguage" name="nameOfNewLanguage" value="' . $defaultNameOfLanguage . '"/>
               </div>
      ';
   }


   function getMarkupForEditButtonAndDeleteButton()
   {
      return '

               <div>
                  <input type="submit" name="editLanguageButton" value="Edit" class="blueButton" />
                  <input type="submit" name="deleteLanguageButton" value="Delete" class="blueButton" />
               </div>';
   }


   function getMarkupForEditFavouriteQuotesFormAndSetValueRetrievedFromDatabaseAsDefaultValue()
   {
      $row = retrieveFromDatabaseFavouriteQuoteDetails( $_SESSION['idOfLoggedInUser'] );
      return getMarkupForEditFavouriteQuotesForm( $row['favourite_quotes'] );
   }


   function getMarkupForEditFavouriteQuotesFormAndAppropriateErrorMessage()
   {
      return getMarkupForEditFavouriteQuotesForm( INVALID );
   }


   function getMarkupForEditFavouriteQuotesForm( $defaultFavouriteQuotes )
   {
      $form = '
         <form method="POST" action="' . $_SERVER['PHP_SELF'] . '">
            <label for="favouriteQuotes">Enter your favourite quotes:</label>';

      if ( $defaultFavouriteQuotes == INVALID ) {
         $form .= '
            <textarea id="favouriteQuotes" name="favouriteQuotes"></textarea>
            <span class="errorMessage">Please enter your favourite quotes</span>
         ';
      }
      else {
         $form .= '
            <textarea id="favouriteQuotes" name="favouriteQuotes">' . $defaultFavouriteQuotes . '</textarea>
         ';
      }

      $form .=
            getMarkupForSaveButtonAndCancelButton() . '
         </form>';

      return $form;
   }


   function getMarkupForEditAboutMeDetailsFormAndSetValueRetrievedFromDatabaseAsDefaultValue()
   {
      $rowContainingAboutMeDetails = retrieveFromDatabaseAboutMeDetails( $_SESSION['idOfLoggedInUser'] );
      $aboutMeDetails = $rowContainingAboutMeDetails['about_me'];
      return getMarkupForEditAboutMeDetailsForm( $aboutMeDetails );
   }


   function getMarkupForEditAboutMeDetailsFormAndAppropriateErrorMessage()
   {
      return getMarkupForEditAboutMeDetailsForm( INVALID );
   }


   function getMarkupForEditAboutMeDetailsForm( $defaultAboutMeDetails )
   {
      $form = '
         <form method="POST" action="' . $_SERVER['PHP_SELF'] . '">
            <label for="aboutMe">What are some things about you which you want your friends to know?</label>';

      if ( $defaultAboutMeDetails == INVALID ) {
         $form .= '
            <textarea id="aboutMe" name="aboutMe"></textarea>
            <span class="errorMessage">Please fill this field</span>
         ';
      }
      else {
         $form .= '
            <textarea id="aboutMe" name="aboutMe">' . $defaultAboutMeDetails . '</textarea>
         ';
      }

      $form .= 
            getMarkupForSaveButtonAndCancelButton() . '
         </form>';

      return $form;
   }


   function getMarkupForEditPhoneNumberFormAndSetValuesRetrievedFromDatabaseAsDefaultValues()
   {
      $phoneNumberDetails = retrieveFromDatabasePhoneNumberDetails( $_SESSION['idOfLoggedInUser'] );
      return getMarkupForFormForEditingPhoneNumberDetails( $phoneNumberDetails['phone_number'] );
   }


   function getMarkupForEditPhoneNumberFormAndAppropriateErrorMessages()
   {

      if ( userDidNotInputHisPhoneNumber() ) {
         return getMarkupForFormForEditingPhoneNumberDetails( $_POST['phoneNumber'] );
      }
      else if ( thePhoneNumberInputtedByUserIsInvalid() ) {
         return getMarkupForFormForEditingPhoneNumberDetails( $_POST['phoneNumber'], INVALID_PHONE_NUMBER );
      }
      else if ( userInputtedThePhoneNumberOfAnotherIfeFacebookUser() ) {
         return getMarkupForFormForEditingPhoneNumberDetails( 
            $_POST['phoneNumber'], ANOTHER_USER_HAS_THE_SAME_PHONE_NUMBER );
      }

   }


   function getMarkupForFormForEditingPhoneNumberDetails( $defaultPhoneNumber, $status = NULL )
   {
      $form = '
         <form method="POST" action="' . $_SERVER['PHP_SELF'] . '">
            <label for="phoneNumber">Phone number:</label>
            <input type="text" id="phoneNumber" name="phoneNumber" value="' . $defaultPhoneNumber . '" />
      ';

      if ( $defaultPhoneNumber === '' ) {
         $form .= '
            <span class="errorMessage">Please, enter your phone number.</span>
         ';
      }

      if ( $status == INVALID_PHONE_NUMBER ) {
         $form .= '
            <span class="errorMessage">Invalid phone number.</span>
         ';
      }

      if ( $status == ANOTHER_USER_HAS_THE_SAME_PHONE_NUMBER ) {
         $form .= '
            <span class="errorMessage">Another ife_facebook user already uses this phone number.</span>
         ';
      }

      $form .=
            getMarkupForSaveButtonAndCancelButton() . '
         </form>';

      return $form;
   }


   function getMarkupForEditEmailAddressFormAndSetValueRetrievedFromDatabaseAsDefaultValue()
   {
      $row = retrieveFromDatabaseEmailAddressDetails( $_SESSION['idOfLoggedInUser'] );
      $emailAddressDetails = $row['email_address'];
      return getMarkupForFormForEditingEmailAddressDetails( $emailAddressDetails );
   }


   function getMarkupForEditEmailAddressFormAndAppropriateErrorMessage()
   {
      if ( userDidNotInputEmailAddress() ) {
         return getMarkupForFormForEditingEmailAddressDetails( $_POST['emailAddress'] );
      }

      if ( isNotValidEmailAddress( $_POST['emailAddress'] ) ) {
         return getMarkupForFormForEditingEmailAddressDetails( $_POST['emailAddress'], INVALID_EMAIL_ADDRESS );
      }

      $anotherUserWithTheSameEmailAddress = 
         retrieveFromDatabaseUserIdOfAnotherUserAssociatedWithEmailAddress( $_POST['emailAddress'] );

      if ( existsInDatabase( $anotherUserWithTheSameEmailAddress ) ) {
         return getMarkupForFormForEditingEmailAddressDetails( 
            $_POST['emailAddress'], ANOTHER_USER_HAS_THE_SAME_EMAIL_ADDRESS );
      }

   }


   function getMarkupForFormForEditingEmailAddressDetails( $defaultEmailAddress, $status = NULL )
   {
      $form = '
         <form method="POST" action="' . $_SERVER['PHP_SELF'] . '">
            <label for="emailAddress">Email Address:</label>
            <input type="text" id="emailAddress" name="emailAddress" value="' . $defaultEmailAddress . '" />
         ';

      if ( $defaultEmailAddress === '' ) {
         $form .= '
            <span class="errorMessage">Please, enter your email address.</span>
         ';
      }

      if ( $status == INVALID_EMAIL_ADDRESS ) {
         $form .= '
            <span class="errorMessage">Invalid email address.</span>
         ';
      }

      if ( $status == ANOTHER_USER_HAS_THE_SAME_EMAIL_ADDRESS ) {
         $form .= '
            <span class="errorMessage">Another ife_facebook user already uses this email address.</span>
         ';
      }

      $form .= 
            getMarkupForSaveButtonAndCancelButton() . '
         </form>';

      return $form;
   }


   function getMarkupToIndicateThatLanguageWasRepeated( $idOfRepeatedLanguage )
   {
      return '
         <div class="errorMessage notFloating">
            <p>Repeated Language!</p>
            <p>The language which you selected as "LANGUAGE ' . getIndexOfLanguage( $_POST['idOfLanguageToBeEdited'] ) . '" is exactly the same as "LANGUAGE ' . getIndexOfLanguage( $idOfRepeatedLanguage ) . '".</p>
            <p>Please, select another language.</p>
         </div>
      ';
   }


   function getMarkupToIndicateThatNameOfNewLanguageIsInvalid()
   {
      return '
         <div class="containerForErrorMessageInEditForm">
            <span class="errorMessageInEditForm">
               The specified name of language is not valid.
               Please, provide a valid name of language.
            </span>
         </div>
      ';
   }


   function getMarkupForEditUserNamesFormAndSetValuesRetrievedFromDatabaseAsDefaultValues()
   {
      $names = retrieveFromDatabaseFirstNameLastNameAndNickName( $_SESSION['idOfLoggedInUser'] );
      return getMarkupForFormForEditingUserNames( $names['first_name'], $names['last_name'], $names['nick_name'] );
   }


   function getMarkupForEditUserNamesFormAndAppropriateErrorMessages()
   {

      if ( userDidNotInputFirstName() || userDidnotInputLastName() ) {
         return getMarkupForFormForEditingUserNames( $_POST['firstName'], $_POST['lastName'], $_POST['nickName'] );

      }
      else if ( oneOfTheUserNamesInputtedByUserIsInvalid() ) {
         return getMarkupForFormForEditingUserNames( 
            $_POST['firstName'], $_POST['lastName'], $_POST['nickName'], INVALID );
      }


   }


   function getMarkupForFormForEditingUserNames( $defaultFirstName, $defaultLastName, 
      $defaultNickName, $status = NULL )
   {
      $form = '
         <form method="POST" action="' . $_SERVER['PHP_SELF'] . '">
            <div class="whiteContainerWithoutBorder">
               <label for="firstName" class="thirtyPercentWidth">First name:</label>
               <input type="text" id="firstName" name="firstName" value="' . $defaultFirstName . '" maxlength="50"/>';

      if ( $defaultFirstName === '' ) {
         $form .= '
               <span class="errorMessage">Please, enter your first name</span>';
      }

      if ( $status == INVALID && isNotValidUserName( $defaultFirstName ) ) {
         $form .= '
               <span class="errorMessage">Invalid first name</span>';
      }

      $form .= '
            </div>

            <div class="whiteContainerWithoutBorder">
               <label for="lastName" class="thirtyPercentWidth">Last name:</label>
               <input type="text" id="lastName" name="lastName" value="' . $defaultLastName . '" maxlength="50"/>';

      if ( $defaultLastName === '' ) {
         $form .= '
               <span class="errorMessage">Please, enter your last name</span>';
      }

      if ( $status == INVALID && isNotValidUserName( $defaultLastName ) ) {
         $form .= '
               <span class="errorMessage">Invalid last name</span>';
      }

      $form .= '
            </div>

            <div class="whiteContainerWithoutBorder">
               <label for="nickName" class="thirtyPercentWidth">Nick name (optional):</label>
               <input type="text" id="nickName" name="nickName" value="' . $defaultNickName . '" maxlength="50"/>';


      if ( $status == INVALID && isNotValidUserName( $defaultNickName ) ) {
         $form .= '
               <span class="errorMessage">Invalid nick name</span>';
      }

      $form .= '
            </div>
            ' .
         getMarkupForSaveButtonAndCancelButton() . '
         </form>';

      return $form;
   }


   function getMarkupForEditPasswordFormAndAppropriateErrorMessages()
   {

      if ( userDidNotFillAllFieldsInTheEditPasswordForm() ) {
         return getMarkupForFormForEditingPassword( $_POST['currentPassword'], 
            $_POST['newPassword'], $_POST['confirmationOfNewPassword'] );
      }
      else if ( userInputtedIncorrectCurrentPassword() ) {
         return getMarkupForFormForEditingPassword( $_POST['currentPassword'], 
            $_POST['newPassword'], $_POST['confirmationOfNewPassword'], CURRENT_PASSWORD_IS_INCORRECT );
      }
      else if ( userInputtedDifferentValuesForNewPasswordAndConfirmationOfNewPassword() ) {
         return getMarkupForFormForEditingPassword( $_POST['currentPassword'], 
            $_POST['newPassword'], $_POST['confirmationOfNewPassword'], PASSWORDS_DO_NOT_MATCH );
      }

   }


   function getMarkupForFormForEditingPassword( $defaultCurrentPassword = NULL,
      $defaultNewPassword = NULL, $defaultConfirmationOfNewPassword = NULL, $status = NULL )
   {
      $form = '
         <form method="POST" action="' . $_SERVER['PHP_SELF'] . '">
            <div  class="whiteContainerWithoutBorder">
               <label for="currentPassword" class="thirtyPercentWidth">Current password:</label>
               <input type="password" id="currentPassword" name="currentPassword" maxlength="50" />';

      if ( $defaultCurrentPassword === '' ) {
         $form .= '
               <span class="errorMessage">Please, enter your current password</span>';
      }

      if ( $status == CURRENT_PASSWORD_IS_INCORRECT ) {
         $form .= '
               <span class="errorMessage">This password is not correct</span>';
      }

      $form .= '
            </div>

            <div class="whiteContainerWithoutBorder">
               <label for="newPassword" class="thirtyPercentWidth">New password:</label>
               <input type="password" id="newPassword" name="newPassword" maxlength="50" />';

      if ( $defaultNewPassword === '' ) {
         $form .= '
               <span class="errorMessage">Please, enter your new password</span>';
      }

      $form .= '
            </div>

            <div class="whiteContainerWithoutBorder">
               <label for="confirmationOfNewPassword" class="thirtyPercentWidth">Re-enter new password:</label>
               <input type="password" id="confirmationOfNewPassword" name="confirmationOfNewPassword" maxlength="50" />';

      if ( $defaultConfirmationOfNewPassword === '' ) {
         $form .= '
               <span class="errorMessage">Please, re-enter your new password</span>';
      }


      $form .= '
            </div>
      ';

      if ( $status == PASSWORDS_DO_NOT_MATCH ) {
         $form .= '
            <span class="errorMessage">The new passwords you entered do not match</span>
         ';
      }

      $form .=
            getMarkupForSaveButtonAndCancelButton() . '
         </form>';

      return $form;
   }


   function getMarkupToConfirmThatUserReallyWantsToDeactivateAccount()
   {
      return '<div class="mainBody whiteContainerWithBorder">
         <h1 class="blueText">Do you really want to deactivate your account?</h1>
         <p class="smallSizedText darkGreyText">Note: If you deactivate your account, you will no longer have access to ife_facebook services.</p>

         <form method="POST" action="' . $_SERVER['PHP_SELF'] . '">
            <input type="submit" name="yesButton" value="Yes" class="bigBlueButton"/>
            <input type="submit" name="cancelButton" value="No" class="bigBlueButton"/>
         </form>
      </div>';
   }


   function getMarkupToTellUserThatHisAccountHasBeenDeactivated()
   {
      return '<div class="mainBody whiteContainerWithBorder">
         <h1 class="blueText centralizedText smallBottomMargin">Account Deactivated</h1>
         <p class="centralizedText smallBottomMargin">Your account has been deactivated. We are very sad to loose you.</p>
         <p class="centralizedText" >If you wish to sign up to ife_facebook at any time, you can easily visit our sign up page at: <a href="signUpPage.php">ife_facebook.com/signUpPage.php</a></p>
      </div>';
   }


   function getMarkupToTellUserThatHisPasswordHasBeenChangedSuccessfully()
   {
      return '<div class="mainBody whiteContainerWithBorder centralizedText">
         <h1 class="blueText smallBottomMargin">Password Successfully Changed</h1>
         <p class="smallBottomMargin">Your password has been changed successfully.</p>
         <p class="smallBottomMargin">Click on the link below to login with your new password:</p>
         <p><a href="index.php">Log in to ife_facebook</a></p>
      </div>';
   }


   function getMarkupToDisplayFriendsOfLoggedInUser()
   {
      if ( $_SESSION['totalNumberOfFriends'] == 0 ) {
         return '
         <p>Sorry, you have no friends</p>
         <p>Why not <a href="findFriends.php">search for new friends</a>?</p>';
      }
      else {
         $markup = '
         <h1 class="bigSizedText">Your Friends:</h1>';

         for ( $index = 0; $index < $_SESSION['totalNumberOfFriends']; $index++ ) {
            $markup .= '

         <div class="whiteContainerWithBorder smallTopMargin bigTopPadding bigBottomPadding">' . 
            getMarkupToDisplayDetailsOfUser( $_SESSION['idOfFriend' . $index] ) . '
         </div>';
         }

         return $markup;
      }
   }


   function getMarkupToDisplayFriendsOfRequiredUser( $idOfRequiredUser )
   {
      $friends = retrieveFromDatabaseAndReturnInArrayIdOfFirstSetOfFriends( $idOfRequiredUser );

      $markup = '';

      for ( $index = 0; $index < sizeof( $friends ); $index++ ) {
         $markup .= '

         <div class="whiteContainerWithBorder smallTopMargin bigTopPadding bigBottomPadding">' . 
            getMarkupToDisplayDetailsOfUser( $friends[$index] ) . '
         </div>';
      }

      $friends = retrieveFromDatabaseAndReturnInArrayIdOfSecondSetOfFriends( $idOfRequiredUser );

      for ( $index = 0; $index < sizeof( $friends ); $index++ ) {
         $markup .= '

         <div class="whiteContainerWithBorder smallTopMargin bigTopPadding bigBottomPadding">' . 
            getMarkupToDisplayDetailsOfUser( $friends[$index] ) . '
         </div>';
      }

      return ( $markup == '' ? '   <p>No Friends</p>' : $markup );
   }


   function getMarkupForFormContainingSearchBarForSearchingForIfeFacebookUsers( $defaultValueForSearchField = NULL )
   {
      return '
         <form method="GET" action="' . $_SERVER['PHP_SELF'] . '">
            <input type="hidden" name="offsetForSearchResults" value="0" />
            <input type="hidden" name="numberOfSearchResultsToBeDisplayed" value="' . DEFAULT_NUMBER_OF_ROWS_FOR_SEARCH_RESULTS . '" />

            <input type="text" name="searchQuery" placeholder="Type the person\'s name here..." value="' . $defaultValueForSearchField . '" class="threeQuartersWidth" />
            <input type="submit" name="searchButton" value="Search" class="blueButton" />
         </form>
      ';
   }


   function getMarkupToDisplayPendingFriendRequests()
   {
      $idOfPendingUsers =
         retrieveFromDatabaseAndReturnInArrayIdOfAllUsersWhoseFriendRequestsHaveNotBeenAcceptedByLoggedInUser();

      $markup = '
         <div class="whiteContainerWithBorder smallTopMargin boxShadowEffect">
            <h2 class="moderateSizedText">Pending Friend Requests</h2>
      ';

      for ( $index = 0; $index < sizeof( $idOfPendingUsers ); $index++ ) {
         $markup .= '
            <section class="whiteContainerWithBorder">
               <div class="floatedToLeft">' .
                  getMarkupToDisplayDetailsOfUser( $idOfPendingUsers[$index] ) . '
               </div>

               <div class="floatedToRight">' .
                  getMarkupToIndicateFriendRelationshipBetweenLoggedInUserAndRequiredUser( $idOfPendingUsers[$index] ) . '
               </div>
            </section>';
      }

      $markup .= '
         </div>';

      return $markup;
   }


   function getMarkupToDisplayAListOfUsersRecommendedForFriendship()
   {
      $list = getMarkupToDisplayRecommendedUsersFromTheSameHometownAsLoggedInUser( MAX_NUMBER_OF_USERS_TO_RECOMMEND );

      if ( moreUsersAreToBeRecommendedForFriendship() ) {
         $numberOfUsersAlreadyDisplayed = getNumberOfRecommendedUsersFromTheSameHometownAsLoggedInUser();
         $maximumNumberOfUsersYetToBeDisplayed = MAX_NUMBER_OF_USERS_TO_RECOMMEND - $numberOfUsersAlreadyDisplayed;
         $list .=
            getMarkupToDisplayRecommendedUsersLivingInTheSameCityAsLoggedInUser( $maximumNumberOfUsersYetToBeDisplayed );
      }

      return '
         <div class="whiteContainerWithBorder smallTopMargin boxShadowEffect">
            <h2 class="moderateSizedText">People You May Know:</h2>
            ' . ( $list == '' ? '<p>No recommended person.</p>' : $list ) . '
         </div>';
   }


   function getMarkupToDisplayRecommendedUsersFromTheSameHometownAsLoggedInUser( $maximumNumberOfUsersToBeDisplayed )
   {
      $row = retrieveFromDatabaseIdOfHometown( $_SESSION['idOfLoggedInUser'] );

      if ( doesNotExistInDatabase( $row['id_of_hometown'] ) ) {
         return '';
      }

      $idOfUsers = retrieveFromDatabaseAndReturnInArrayIdOfUsersAssociatedWithHometown( $row['id_of_hometown'] );

      $markup = '';
      $counter = 0;
      for ( $index = 0; $index < sizeof( $idOfUsers ) && $counter < $maximumNumberOfUsersToBeDisplayed; $index++ ) {
         if ( userShouldBeRecommendedForFriendship( $idOfUsers[$index] ) ) {
            $markup .= '

            <section class="transparentContainerWithBorder">
               <div class="floatedToLeft">' .
                  getMarkupToDisplayDetailsOfUser( $idOfUsers[$index] ) . '
               </div>

               <div class="floatedToRight">' .
                  getMarkupToIndicateFriendRelationshipBetweenLoggedInUserAndRequiredUser( $idOfUsers[$index] ) . '
               </div>
            </section>';
            $counter++;
         }
      }

      return $markup;
   }


   function getMarkupToDisplayRecommendedUsersLivingInTheSameCityAsLoggedInUser( $maximumNumberOfUsersToBeDisplayed )
   {
      $row = retrieveFromDatabaseIdOfCurrentCity( $_SESSION['idOfLoggedInUser'] );

      if ( doesNotExistInDatabase( $row['id_of_current_city'] ) ) {
         return '';
      }

      $idOfUsers = retrieveFromDatabaseAndReturnInArrayIdOfUsersAssociatedWithCurrentCity( $row['id_of_current_city'] );

      $markup = '';
      $counter = 0;
      for ( $index = 0; $index < sizeof( $idOfUsers ) && $counter < $maximumNumberOfUsersToBeDisplayed; $index++ ) {
         if ( userIsNotFromTheSameHometownAsLoggedInUser( $idOfUsers[$index] ) &&
            userShouldBeRecommendedForFriendship( $idOfUsers[$index] ) )
         {
            $markup .= '

            <section class="transparentContainerWithBorder">
               <div class="floatedToLeft">' .
                  getMarkupToDisplayDetailsOfUser( $idOfUsers[$index] ) . '
               </div>

               <div class="floatedToRight">' .
                  getMarkupToIndicateFriendRelationshipBetweenLoggedInUserAndRequiredUser( $idOfUsers[$index] ) . '
               </div>
            </section>';
            $counter++;
         }
      }

      return $markup;
   }


   function getMarkupForErrorMessageToIndicateThatSearchQueryIsNotValid()
   {
      return '
        <span class="errorMessageInEditForm">Invalid search query</span>';
   }


   function getMarkupToDisplaySearchResultsContainingUsersWhoseNamesMatchSearchQuery( 
      $searchQuery, $offset, $numberOfRows )
   {
      $idOfMatchingUsers = 
         rerieveFromDatabaseAndReturnInArrayIdOfUsersWhoseNamesMatchSearchQuery( $searchQuery, $offset, $numberOfRows );

      if ( doesNotExistInDatabase( $idOfMatchingUsers ) ) {
         $_SESSION['totalNumberOfSearchResultsCurrentlyListed'] = 0;
         $_SESSION['totalNumberOfSearchResultsDisplayedSoFar'] = $offset + 0;
         return '
         <p>No results found.</p>';
      }

      $markupContainingSearchResults = '
         <h2 class="moderateSizedText">Search Results:</h2>';

      for ( $index = 0; $index < sizeof( $idOfMatchingUsers ); $index++ ) {
         $markupContainingSearchResults .= '

         <section class="whiteContainerWithBorder smallTopMargin bigTopPadding bigBottomPadding">
            <div class="floatedToLeft">'.
               getMarkupToDisplayDetailsOfUser( $idOfMatchingUsers[$index] ) . '
            </div>

            <div class="floatedToRight">' .
               getMarkupToIndicateFriendRelationshipBetweenLoggedInUserAndRequiredUser( $idOfMatchingUsers[$index] ) . '
            </div>
         </section>';
      }

      $_SESSION['totalNumberOfSearchResultsCurrentlyListed'] = sizeof( $idOfMatchingUsers );
      $_SESSION['totalNumberOfSearchResultsDisplayedSoFar'] = $offset + sizeof( $idOfMatchingUsers );

      return $markupContainingSearchResults;
   }


   function getMarkupToDisplayDetailsOfUser( $idOfUser )
   {
      $names = retrieveFromDatabaseFirstNameLastNameAndNickName( $idOfUser );

      $markup = '
                  <h2 class="moderateSizedText"><a href="profileOfUser.php?idOfRequiredUser=' . $idOfUser . '">' . 
                     $names['first_name'] . ' ' . $names['last_name'];

      if ( $names['nick_name'] != NULL ) {
         $markup .= ' (' . $names['nick_name'] . ')';
      }

      $markup .= 
                  '</a></h2>' .
                  getMarkupContainingAnyInterestingInformationAboutUser( $idOfUser );

      return $markup;
   }


   function getMarkupToIndicateFriendRelationshipBetweenLoggedInUserAndRequiredUser( $idOfRequiredUser )
   {
      if ( $idOfRequiredUser == $_SESSION['idOfLoggedInUser'] ) {
         return '';
      }
      else if ( areFriendsOfEachOther( $_SESSION['idOfLoggedInUser'], $idOfRequiredUser ) ) {
         return getMarkupForUnfriendButton( $idOfRequiredUser );
      }
      else if ( friendRequestSentByLoggedInUserHasNotYetBeenAcceptedByRequiredUser( $idOfRequiredUser ) ) {
         return '
                  <p>Friend request sent</p>';
      }
      else if ( loggedInUserHasNotYetAcceptedFriendRequestByRequiredUser( $idOfRequiredUser ) ) {
         return '
                  <p>This person sent you a friend request</p>' .
                  getMarkupForAcceptFriendRequestButton( $idOfRequiredUser ) .
                  getMarkupForRejectFriendRequestButton( $idOfRequiredUser );
      }
      else {
         return getMarkupForSendFriendRequestButton( $idOfRequiredUser );
      }
   }


   function getMarkupForUnfriendButton( $idOfRequiredUser )
   {
      return '
                  <form method="POST" action="processRequestToUnfriendUser.php">
                     <input type="hidden" name="idOfRequiredUser" value="' . $idOfRequiredUser . '" />
                     <input type="hidden" name="urlOfSourcePage" value="' . getMarkupContainingUrlOfCurrentPageAsWellAsGETParameters() . '" />
                     <input type="submit" value="Unfriend This Person" class="blueButton" />
                  </form>';
   }


   function getMarkupForAcceptFriendRequestButton( $idOfRequiredUser )
   {
      return '

                  <form method="POST" action="processRequestToAcceptFriendRequest.php" class="displayAsInline verySmallBottomMargin">
                     <input type="hidden" name="idOfRequiredUser" value="' . $idOfRequiredUser . '" />
                     <input type="hidden" name="urlOfSourcePage" value="' . getMarkupContainingUrlOfCurrentPageAsWellAsGETParameters() . '" />
                     <input type="submit" value="Accept Request" class="blueButton" />
                  </form>';
   }


   function getMarkupForRejectFriendRequestButton( $idOfRequiredUser )
   {
      return '

                  <form method="POST" action="processRequestToRejectFriendRequest.php" class="displayAsInline">
                     <input type="hidden" name="idOfRequiredUser" value="' . $idOfRequiredUser . '" />
                     <input type="hidden" name="urlOfSourcePage" value="' . getMarkupContainingUrlOfCurrentPageAsWellAsGETParameters() . '" />
                     <input type="submit" value="Reject Request" class="blueButton" />
                  </form>';
   }


   function getMarkupForSendFriendRequestButton( $idOfRequiredUser )
   {
      return '
                  <form method="POST" action="processRequestToSendFriendRequest.php">
                     <input type="hidden" name="idOfRequiredUser" value="' . $idOfRequiredUser . '" />
                     <input type="hidden" name="urlOfSourcePage" value="' . getMarkupContainingUrlOfCurrentPageAsWellAsGETParameters() . '" />
                     <input type="submit" value="Send Friend Request" class="blueButton" />
                  </form>';
   }


   function getMarkupContainingUrlOfCurrentPageAsWellAsGETParameters()
   {
      if ( isset( $_GET['offsetForSearchResults'] ) && isset( $_GET['numberOfSearchResultsToBeDisplayed'] ) && 
         isset( $_GET['searchQuery'] ) )
      {
         return $_SERVER['PHP_SELF'] . '?offsetForSearchResults=' . $_GET['offsetForSearchResults'] . '&numberOfSearchResultsToBeDisplayed=' . $_GET['numberOfSearchResultsToBeDisplayed'] . '&searchQuery=' . $_GET['searchQuery'] . '&searchButton=Search';
      }
      else {
         return $_SERVER['PHP_SELF'];
      }
   }


   function getMarkupContainingAnyInterestingInformationAboutUser( $idOfUser )
   {
      $row = retrieveFromDatabaseIdOfHometown( $idOfUser );

      if ( existsInDatabase( $row['id_of_hometown'] ) ) {
         $hometownDetails = retrieveFromDatabaseCityDetails( $row['id_of_hometown'] );
         return '
                  <p>Hails from ' . capitalizeWordsThatShouldBeCapitalized( $hometownDetails['name_of_city'] ) . ', ' . capitalizeWordsThatShouldBeCapitalized( $hometownDetails['name_of_country'] ) . '</p>';
      }

      $row = retrieveFromDatabaseIdOfCurrentCity( $idOfUser );

      if ( existsInDatabase( $row['id_of_current_city'] ) ) {
         $currentCityDetails = retrieveFromDatabaseCityDetails( $row['id_of_current_city'] );
         return '
                  <p>Lives in ' . capitalizeWordsThatShouldBeCapitalized( $currentCityDetails['name_of_city'] ) . ', ' . capitalizeWordsThatShouldBeCapitalized( $currentCityDetails['name_of_country'] ) . '</p>';
      }

      $idOfLanguages = retrieveFromDatabaseAndReturnInArrayIdOfAllLanguagesSpoken( $idOfUser );

      for ( $index = 0; $index < sizeof( $idOfLanguages ); $index++ ) {

         if ( alreadyExistsInDatabaseAsLanguageSpokenByLoggedInUser( $idOfLanguages[$index] ) ) {
            $row = retrieveFromDatabaseNameOfLanguage( $idOfLanguages[$index] );
            return '
                  <p>Also speaks ' . capitalizeWordsThatShouldBeCapitalized( $row['name_of_language'] ) . '</p>';
         }
      }

      return '';
   }


   function getMarkupForLinkForViewingPreviousSearchResults()
   {
      if ( $_SESSION['totalNumberOfSearchResultsDisplayedSoFar'] > DEFAULT_NUMBER_OF_ROWS_FOR_SEARCH_RESULTS ) {
         return '

         <a href="' . $_SERVER['PHP_SELF'] . '?requiredAction=viewPreviousSearchResults&offsetForSearchResults=' . ( $_SESSION['totalNumberOfSearchResultsDisplayedSoFar'] - $_SESSION['totalNumberOfSearchResultsCurrentlyListed'] - DEFAULT_NUMBER_OF_ROWS_FOR_SEARCH_RESULTS ) . '&numberOfSearchResultsToBeDisplayed=' . DEFAULT_NUMBER_OF_ROWS_FOR_SEARCH_RESULTS . '&searchQuery=' . $_GET['searchQuery'] . '" class="floatedToLeft">&lt;&lt;View Previous</a>';
      }
      else {
         return '';
      }
   }


   function getMarkupForLinkForViewingMoreSearchResults()
   {
      if ( atLeastOneMoreSearchResultExistsInDatabase() ) {
         return '

         <a href="' . $_SERVER['PHP_SELF'] . '?requiredAction=viewMoreSearchResults&offsetForSearchResults=' . $_SESSION['totalNumberOfSearchResultsDisplayedSoFar'] . '&numberOfSearchResultsToBeDisplayed=' . DEFAULT_NUMBER_OF_ROWS_FOR_SEARCH_RESULTS . '&searchQuery=' . $_GET['searchQuery'] . '" class="floatedToRight">View More&gt;&gt;</a>';
      }
      else {
         return '';
      }
   }


   function getMarkupForClearNotificationsButton()
   {
      return '
         <form method="POST" action="processRequestToClearNotifications.php">
            <input type="submit" name="clearNotificationsButton" value="Clear Notifications" class="blueButton verySmallTopMargin" />
         </form>
      ';
   }


   function getMarkupForErrorMessage( $errorMessage )
   {
      return '
               <span class="errorMessage">' . $errorMessage . '</span>';
   }


   function getMarkupForErrorMessageIfValueIsEmpty( $value, $errorMessage )
   {

      if ( $value === '' ) {
         return '
               <span class="errorMessage">' . $errorMessage . '</span>';
      }
      else {
         return '';
      }

   }


   function getMarkupForErrorMessageIfValueConsistsOfSpacesOnly( $value, $errorMessage )
   {
      if ( $value != '' && consistsOfSpacesOnly( $value ) ) {
         return '
               <span class="errorMessage">' . $errorMessage . '</span>';
      }
      else {
         return '';
      }
   }


   function getMarkupForErrorMessageIfValueIsAnInvalidNameOfLanguage( $value, $errorMessage )
   {
      if ( $value != '' && doesNotConsistOfAlphabetsAndSpacesOnly( $value ) ) {
         return '
               <span class="errorMessage">' . $errorMessage . '</span>';
      }
      else {
         return '';
      }
   }


   function getMarkupForErrorMessageIfValueIsAnInvalidName( $value, $errorMessage )
   {

      if ( isNotValidUserName( $value ) ) {
         return '
               <span class="errorMessage">' . $errorMessage . '</span>';
      }
      else {
         return '';
      }

   }


   function getMarkupForErrorMessageIfValueIsAnInvalidEmailAndInvalidPhone( $value, $errorMessage )
   {

      if ( isNotValidEmailAddress( $value ) && isNotValidPhoneNumber( $value ) ) {
         return '
               <span class="errorMessage">' . $errorMessage . '</span>';
      }
      else {
         return '';
      }

   }


   function getMarkupForErrorMessageIfPasswordWasNotPreviouslyFilledByUser( $errorMessage )
   {
      if ( isset( $_GET['userPasswordOrConfirmationOfUserPasswordHaveNotBeenProvided'] ) ) {
         return '
               <span class="errorMessage">' . $errorMessage . '</span>';
      }
      else {
         return '';
      }
   }


   function getMarkupForErrorMessageIfValueIsInvalid( $value, $errorMessage )
   {

      if ( $value == INVALID ) {
         return '
               <span class="errorMessage">' . $errorMessage . '</span>';
      }
      else {
         return '';
      }

   }


   function getMarkupForTheOpeningTagOfNestedDivElement()
   {
      return '
            <div class="whiteContainerWithoutBorder">';
   }


   function getMarkupForTheClosingTagOfNestedDivElement()
   {
      return '
            </div>
      ';
   }


   function getMarkupForTheOpeningTagOfFormElement( $method = 'POST', $action = NULL )
   {
      return '
         <form method="' . $method . '" action="' . ( $action == NULL ? $_SERVER['PHP_SELF'] : $action ) . '">';
   }


   function getMarkupForTheClosingTagOfFormElement()
   {
      return '
         </form>';
   }


   function getMarkupForTheOpeningTagOfNestedFormElement( $method = 'POST', $action = NULL )
   {
      return '
            <form method="' . $method . '" action="' . ( $action == NULL ? $_SERVER['PHP_SELF'] : $action ) . '">';
   }


   function getMarkupForTheClosingTagOfNestedFormElement()
   {
      return '
            </form>';
   }


   function getMarkupForTheOpeningTagOfLabelElement( $idOfAssociatedInputElement = NULL )
   {
      return '
               <label' . ( $idOfAssociatedInputElement == NULL ? '' : ' for="' . $idOfAssociatedInputElement . '"' ) . ' class="thirtyPercentWidth">';
   }


   function getMarkupForTheClosingTagOfLabelElement()
   {
      return '</label>';
   }


   function getMarkupForSaveButtonAndCancelButton()
   {
      return '
               <div>
                  <input type="submit" name="saveButton" value="Save" class="blueButton"/>
                  <input type="submit" name="cancelButton" value="Cancel" class="blueButton" />
               </div>';
   }


   function getMarkupToDisplaySomeImportantNotifications()
   {
      $markup = '';

      if ( userHasAtLeastOnePendingFriendRequest() ) {
         $markup .= '
            <li>You have some pending friend requests. <a href="findFriends.php">Click here to view them</a>.</li>
         ';
      }

      $notifications = 
         retrieveFromDatabaseAndReturnInArrayIdOfAllNotificationsThatAreMeantForLoggedInUserButHaveNotBeenRead();

      if ( existsInDatabase( $notifications ) ) {
         $markup .='
            <li>' . 
               getMarkupToDisplayDetailsAboutNotification( $notifications[0] ) . '
            </li>';
      }

      if ( $markup != '' ) {
         $markup = '
         <ul>' . 
            $markup . '
         </ul>
         ' . 
         ( sizeof( $notifications ) > 1 ? '<a href="notifications.php">View more notifications</a>' : '' );
      }

      return $markup;
   }


   function getMarkupToDisplayDetailsAboutNotification( $idOfNotification )
   {
      $detailsAboutNotification = retrieveFromDatabaseDetailsAboutNotification( $idOfNotification );

      return '
               <p>' .
                  $detailsAboutNotification['notification_text'] .
               '</p>
               <p>' . 
                  '(On ' . $detailsAboutNotification['month'] . ' ' . $detailsAboutNotification['day'] . ', ' .
                  'by ' . formatTimeShowingAmOrPm( $detailsAboutNotification['hour'], $detailsAboutNotification['minute'] ) . ')' . 
               '</p>';
   }


   function getMarkupToConfirmThatLoggedInUserReallyWantsToUnfriendRequiredUser( $idOfRequiredUser )
   {
      $names = retrieveFromDatabaseFirstNameLastNameAndNickName( $idOfRequiredUser );

      return '<div class="mainBody whiteContainerWithBorder">
         <h1 class="blueText">Are you sure you want to unfriend <span class="boldText">' . $names['first_name'] . ' ' . $names['last_name'] . '</span>?</h1>
         <p class="smallSizedText darkGreyText">Warning: If you unfriend a person, that person\'s status updates will no longer appear on your wall.</p>

         <form method="POST" action="' . $_SERVER['PHP_SELF'] . '">
            <input type="hidden"  name="idOfRequiredUser" value="' . $idOfRequiredUser . '" />
            <input type="hidden"  name="urlOfSourcePage" value="' . $_POST['urlOfSourcePage'] . '" />
            <input type="submit" name="yesButton" value="Yes" class="bigBlueButton"/>
            <input type="submit" name="cancelButton" value="No" class="bigBlueButton"/>
         </form>
      </div>';
   }
?>