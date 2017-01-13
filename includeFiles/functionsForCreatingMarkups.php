<?php
   include_once 'includeFiles/functionsForRetrievingDataFromDatabase.php';
   include_once 'includeFiles/functionsForStoringDataIntoSESSION.php';
   include_once 'includeFiles/functionsToBeUsedAsTestConditions.php';
   include_once 'includeFiles/miscellaneousFunctions.php';
   include_once 'includeFiles/usefulConstants.php';


   function getMarkupForHeader()
   {
      return '
      <header class="loggedInHeader">
         <a href="index.php" class="linkContainingLoggedInLogo"><h1 class="loggedInLogo">f</h1></a>

         <form class="searchBar">
            <input type="text" name="searchQuery" placeholder="Search ife_facebook" 
               class="inputFieldForSearchBar" />
            <input type="submit" value="Search" class="searchButton" />
         </form>

         <nav class="importantLinks">
            <ul>
               <li><a href="myProfile.php" class="importantLink">' . $_SESSION['firstName'] . '</a></li>
               <li><a href="index.php" class="importantLink">Home</a></li>
               <li><a href="findFriends.php" class="importantLink">Find Friends</a></li>
               <li><a href="messages.php" class="importantLink">Messages</a></li>
               <li><a href="notifications.php" class="importantLink">Notification</a></li>
            </ul>
         </nav>

         <!-- log out button -->
         <form method="POST" action="processLogoutRequest.php">
            <input type="submit" value="Log Out" name="logOutButton" class="logOutButton" />
         </form>
      </header>

      <pre class="spaceBelowLoggedInHeader">
      </pre>
      ';
   }


   function getMarkupForLoggedOutVersionOfIfeFacebookHomepage()
   {
      return '
      <header class="homepageHeader">
         <a href="index.php"><h1 class="homepageLogo">ife_facebook</h1></a>' .
         getMarkupForLoginFormWithoutDefaultValues() . '
      </header>

      <div class="homepageBody">
         <div class="shortDescription" >
            <img src="images/connectWithPeople.jpg" width="200px" height="200px"
               class="shortDescriptionImage" alt="connect with people that matter to you"/>

            <h2 class="shortDescriptionText">
               ife_facebook is an online community where you can connect 
               with those that matter to you
            </h2>
         </div>

         <div class="signUpFormContainer" >
            <h2>Sign Up</h2>
            <p>It\'s free and always will be.</p>
         ' . getMarkupForSignUpForm() . '
         </div>

         <div class="linkToSignUpPage">
            <p>Don\'t have an ife_facebook account?</p>
            <p>Just click on the link below to sign up for free.</p>

            <a href="signUpPage.php" class="signUpButton">Sign Up</a>
         </div>
      </div>
      ';
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
         getMarkupForTheOpeningTagOfFormElement( 'POST', 'processSignUpRequest.php' ) .
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
         getMarkupForTheClosingTagOfFormElement();
   }


   function getMarkupForSignUpFormAndShowThatUserNameIsDifferentFromConfirmationOfUserName()
   {
      return
         getMarkupForTheOpeningTagOfFormElement( 'POST', 'processSignUpRequest.php' ) .
            getMarkupForHiddenInputElementContainingUrlOfTheCurrentPage() .
            getMarkupForInputElementsForEnteringFirstNameAndSurname( $_GET['firstName'], $_GET['surname'] ) .

            getMarkupForInputElementForEnteringEmailOrPhone( $_GET['userName'] ) .
            getMarkupForInputElementForReEnteringEmailOrPhone( $_GET['confirmationOfUserName'] ) .
            getMarkupForErrorMessage( 'The email addresses (or phone numbers) you entered do not match' ) .

            getMarkupForInputElementsForEnteringPasswordAndConfirmationOfPassword() .
            getMarkupForSignUpButton() .
         getMarkupForTheClosingTagOfFormElement();
   }


   function getMarkupForSignUpFormAndShowThatUserPasswordIsDifferentFromConfirmationOfUserPassword()
   {
      return
         getMarkupForTheOpeningTagOfFormElement( 'POST', 'processSignUpRequest.php' ) .
            getMarkupForHiddenInputElementContainingUrlOfTheCurrentPage() .
            getMarkupForInputElementsForEnteringFirstNameAndSurname( $_GET['firstName'], $_GET['surname'] ) .
            getMarkupForInputElementForEnteringEmailOrPhone( $_GET['userName'] ) .
            getMarkupForInputElementForReEnteringEmailOrPhone( $_GET['confirmationOfUserName'] ) .

            getMarkupForInputElementsForEnteringPasswordAndConfirmationOfPassword() .
            getMarkupForErrorMessage( 'The passwords you entered do not match' ) .

            getMarkupForSignUpButton() .
         getMarkupForTheClosingTagOfFormElement();
   }


   function getMarkupForSignUpFormAndShowThatUserNameAlreadyExists()
   {
      return
         getMarkupForTheOpeningTagOfFormElement( 'POST', 'processSignUpRequest.php' ) .
            getMarkupForHiddenInputElementContainingUrlOfTheCurrentPage() .
            getMarkupForInputElementsForEnteringFirstNameAndSurname( $_GET['firstName'], $_GET['surname'] ) .

            getMarkupForInputElementForEnteringEmailOrPhone( $_GET['userName'] ) .
            getMarkupForInputElementForReEnteringEmailOrPhone( $_GET['confirmationOfUserName'] ) .
            getMarkupForErrorMessage( 'The email address (or phone number) you entered is already used by another ife_facebook user' ) .

            getMarkupForInputElementsForEnteringPasswordAndConfirmationOfPassword() .
            getMarkupForSignUpButton() .
         getMarkupForTheClosingTagOfFormElement();
   }


   function getMarkupForSignUpFormAndShowThatUserInputtedInvalidSignUpDetails()
   {
      return
         getMarkupForTheOpeningTagOfFormElement( 'POST', 'processSignUpRequest.php' ) .
            getMarkupForHiddenInputElementContainingUrlOfTheCurrentPage() .

            getMarkupForInputElementsForEnteringFirstNameAndSurname( $_GET['firstName'], $_GET['surname'] ) .
            getMarkupForErrorMessageIfValueIsAnInvalidName( $_GET['firstName'], 'Invalid first name' ) .
            getMarkupForErrorMessageIfValueIsAnInvalidName( $_GET['surname'], 'Invalid surname' ) .

            getMarkupForInputElementForEnteringEmailOrPhone( $_GET['userName'] ) .
            getMarkupForInputElementForReEnteringEmailOrPhone( $_GET['confirmationOfUserName'] ) .
            getMarkupForErrorMessageIfValueIsAnInvalidEmailAndInvalidPhone( $_GET['userName'], 'Invalid email address (or phone number)' ) .

            getMarkupForInputElementsForEnteringPasswordAndConfirmationOfPassword() .
            getMarkupForSignUpButton() .
         getMarkupForTheClosingTagOfFormElement();
   }


   function getMarkupForSignUpFormWithoutErrorMessages()
   {
      return
         getMarkupForTheOpeningTagOfFormElement( 'POST', 'processSignUpRequest.php' ) .
            getMarkupForHiddenInputElementContainingUrlOfTheCurrentPage() .
            getMarkupForInputElementsForEnteringFirstNameAndSurname() .
            getMarkupForInputElementForEnteringEmailOrPhone() .
            getMarkupForInputElementForReEnteringEmailOrPhone() .
            getMarkupForInputElementsForEnteringPasswordAndConfirmationOfPassword() .
            getMarkupForSignUpButton() .
         getMarkupForTheClosingTagOfFormElement();
   }


   function getMarkupForHiddenInputElementContainingUrlOfTheCurrentPage()
   {
      return '
               <input type="hidden" name="urlOfSourcePage" value="' . $_SERVER['PHP_SELF'] . '" />';
   }


   function getMarkupForInputElementsForEnteringFirstNameAndSurname( $defaultFirstName = NULL, $defaultSurname = NULL )
   {
      return '
               <div>
                  <input type="text" name="firstName" placeholder="First name" value="' . $defaultFirstName . '" class="smallInputFieldForSignUpForm" />
                  <input type="text" name="surname" placeholder="Surname" value="' . $defaultSurname . '" class="smallInputFieldForSignUpForm" />
               </div>';
   }


   function getMarkupForInputElementForEnteringEmailOrPhone( $defaultUserName = NULL )
   {
      return '
               <div>
                  <input type="text" name="userName" placeholder="Email address or phone number" value="' . $defaultUserName . '" class="inputFieldForSignUpForm" />
               </div>';
   }


   function getMarkupForInputElementForReEnteringEmailOrPhone( $defaultConfirmationOfUserName = NULL )
   {
      return '
               <div>
                  <input type="text" name="confirmationOfUserName" placeholder="Re-enter email address or phone number" value="' . $defaultConfirmationOfUserName . '" class="inputFieldForSignUpForm" />
               </div>';
   }


   function getMarkupForInputElementsForEnteringPasswordAndConfirmationOfPassword()
   {
      return '
               <div>
                  <input type="password" name="userPassword" placeholder="Password you will like to use for ife_facebook" class="inputFieldForSignUpForm" />
               </div>

               <div>
                  <input type="password" name="confirmationOfUserPassword" placeholder="Confirm password" class="inputFieldForSignUpForm" />
               </div>';
   }


   function getMarkupForSignUpButton()
   {
      return '
               <div>
                  <input type="submit" name="signUpButton" value="Sign Up" class="signUpButton">
               </div>';
   }


   function getMarkupForTheClosingTagOfFormElement()
   {
      return '
            </form>';
   }


   function getMarkupToCongratulateUserForSuccessfullySigningUp()
   {
      return '
      <h1 class="mainHeading">Congratulations! You\'ve successfully signed up with <a href="index.php" class="ifeFacebookLogo">ife_facebook</a>.</h1>

      <section class="mainSection">
         <div class="loginDetails">
            <p>Your username is: ' . $_POST['userName'] . '</p>
            <p>Your password is: ' . $_POST['userPassword'] . '</p>
         </div>

         <p>Keep these details safe. You will always need them whenever you want to log in to ife_facebook.</p>
         <p>If you want to log in immediately, click on the link below:</p>
         <p><a href="index.php">Log in to ife_facebook</a></p>
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
      return '
      <div class="containerForEditForm">
         <h3>The email address or phone number you entered is not correct. Why not try to login again?</h3>
      '  . 
         getMarkupForLoginFormWithDefaultValues( NULL, NULL ) . '
      </div> 
      ';
   }


   function getMarkupToTellUserToReEnterLoginDetailsBecausePasswordIsNotCorrect()
   {
      return '
      <div class="containerForEditForm">
         <h3>The password you entered is not correct. Why not try to login again?</h3>
      '  . 
         getMarkupForLoginFormWithDefaultValues( $_POST['userName'], NULL ) . '
      </div>
      ';
   }


   function getMarkupForLoginFormWithoutDefaultValues()
   {
      return '
         <h2 class="loginMessage">Log In</h2>

         <form method="POST" action="processLoginRequest.php" class="loginForm">
            ' . getMarkupForHiddenInputElementThatKeepsTrackOfTheSourcePage() . '

            <label class="loginFormEntry">
               <span class="descriptionInLoginForm">Email or Phone</span>
               <input type="text" name="userName" class="inputFieldForLoginForm" />
            </label>

            <label class="loginFormEntry">
               <span class="descriptionInLoginForm">Password</span>
               <input type="password" name="userPassword" class="inputFieldForLoginForm" />
            </label>

            <label class="loginFormEntry">
               <input type="submit" name="loginButton" value="Log In" class="loginButton" />
            </label>
         </form> <!-- end login form -->
      ';
   }


   function getMarkupForLoginFormWithDefaultValues( $defaultValueOfUserName, $defaultValueOfUserPassword )
   {
      return '
         <form method="POST" action="processLoginRequest.php" >
            ' . getMarkupForHiddenInputElementThatKeepsTrackOfTheSourcePage() . '

            <label class="fieldInEditForm">
               Email or Phone: 
               <input type="text" name="userName" value="' . $defaultValueOfUserName . '" />
            </label>

            <label class="fieldInEditForm">
               Password: 
               <input type="password" name="userPassword" value="' . $defaultValueOfUserPassword . '" />
            </label>

            <label class="fieldInEditForm">
               <input type="submit" name="loginButton" value="Login" class="buttonInEditForm" />
            </label>
         </form>

         <p><a href="forgotPassword.php">Forgot Password? Click here</a></p>';
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


   function getMarkupToTellUserToLogIn( $urlOfSourcePage = NULL )
   {
      return '
      <div>
         <h1>ife_facebook</h1>
         <p>You must login to continue</p>

         <form method="POST" action="index.php">
            <input type="hidden" name="urlOfSourcePage" value="' . ( $urlOfSourcePage == NULL ? $_SERVER['PHP_SELF'] : $urlOfSourcePage ) . '" />
            <input type="submit" value="To log in, click here" />
         </form>
      </div>
      ';
   }


   function getMarkupToDisplayTextAreaForPostingStatusUpdate()
   {
      return '
         <form method="POST" action="processPostNewStatusUpdateRequest.php" class="formForPostingStatusUpdate">
            <label class="containerForStatusUpdateTextArea">
               <p class="statusUpdateDescription">What\'s on your mind? Post it.</p>
               <textarea name="statusUpdateText" class="statusUpdateTextArea"></textarea>
            </label>

            <label class="containerForStatusUpdateButton">
               <input type="submit" value="Post" class="statusUpdateButton" />
            </label>
         </form>
      ';
   }


   function getMarkupToDisplayLinkForRefreshingThisPage()
   {
      return '
         <h3>News Feed (<a href="' . $_SERVER['PHP_SELF'] . '">refresh</a>)</h3>
      ';
   }


   function getMarkupToDisplaySomeStatusUpdatesFromDatabase( $offset, $numberOfStatusUpdates )
   {
      $idOfStatusUpdates = retrieveFromDatabaseAndReturnInArrayIdOfStatusUpdates( $offset, $numberOfStatusUpdates );

      if ( doesNotExistInDatabase( $idOfStatusUpdates ) ) {
         return '
         <p>Sorry, No relevant status update exists.</p>
         ';
      }

      $list = '';

      for ( $index = 0; $index < sizeof( $idOfStatusUpdates ); $index++ ) {
         $list .= getMarkupToDisplayStatusUpdateInDefaultFormat( $idOfStatusUpdates[$index] );
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
         <section class="statusUpdate">Can\'t find this status update, it may have been deleted.</section>';
      }
      else {
         return '

         <section class="statusUpdate" id="' . $detailsOfStatusUpdate['status_update_id'] . '">
            ' . getMarkupToDisplayHeaderAndBodyOfStatusUpdate( $detailsOfStatusUpdate ) . '

            <footer class="statusUpdateFooter">
               <div class="infoAboutLikes">' .
                  getMarkupToDisplayLikeButtonOrUnlikeButton( $detailsOfStatusUpdate['status_update_id'] ) . 
                  getMarkupToDisplayLinkForViewingNamesOfLikers( $detailsOfStatusUpdate['number_of_likes'], $detailsOfStatusUpdate['status_update_id'] ) . '
               </div>

               <div class="infoAboutComments">' .
                  getMarkupToDisplayLinkForViewingComments( $detailsOfStatusUpdate['status_update_id'] ) . '
               </div>
               ' . 
               getMarkupForPostCommentForm( $detailsOfStatusUpdate['status_update_id'] ) . '
            </footer>
         </section> <!-- end section.statusUpdate -->
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
         <section class="statusUpdate">Can\'t find this status update, it may have been deleted.</section>';
      }
      else {
         return '

         <section class="statusUpdate" id="' . $detailsOfStatusUpdate['status_update_id'] . '">
            ' . getMarkupToDisplayHeaderAndBodyOfStatusUpdate( $detailsOfStatusUpdate ) . '

            <footer class="statusUpdateFooter">
               <div class="infoAboutLikes">' .
                  getMarkupToDisplayLikeButtonOrUnlikeButton( $detailsOfStatusUpdate['status_update_id'] ) . 
                  getMarkupToDisplayLinkForViewingNamesOfLikers( $detailsOfStatusUpdate['number_of_likes'], $detailsOfStatusUpdate['status_update_id'] ) . '
               </div>

               <div class="infoAboutComments">' .
                  getMarkupToDisplayLinkForHidingComments( $detailsOfStatusUpdate['status_update_id'] ) .
                  getMarkupToDisplayGeneralHeadingForComments() .
                  getMarkupToDisplaySomeCommentsOnTheSpecifiedStatusUpdate( $detailsOfStatusUpdate['status_update_id'], 
                     $_GET['offsetForComments'], $_GET['numberOfCommentsToBeDisplayed'] ) .  
                  getMarkupToDisplayLinkForViewingOlderComments( $detailsOfStatusUpdate['status_update_id'] ) .
                  getMarkupToDisplayLinkForViewingNewerComments( $detailsOfStatusUpdate['status_update_id'] ) . '
               </div>
               ' . 
               getMarkupForPostCommentForm( $detailsOfStatusUpdate['status_update_id'] ) . '
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
         <section class="statusUpdate">Can\'t find this status update, it may have been deleted.</section>';
      }
      else {
         return '

         <section class="statusUpdate" id="' . $detailsOfStatusUpdate['status_update_id'] . '">
            ' . getMarkupToDisplayHeaderAndBodyOfStatusUpdate( $detailsOfStatusUpdate ) . '

            <footer class="statusUpdateFooter">
               <div class="infoAboutLikes">' .
                  getMarkupToDisplayLikeButtonOrUnlikeButton( $detailsOfStatusUpdate['status_update_id'] ) . 
                  getMarkupToDisplayLinkForHidingNamesOfLikers(  $detailsOfStatusUpdate['status_update_id']  ) .
                  getMarkupToDisplayGeneralHeadingForNamesOfLikers() .
                  getMarkupToDisplaySomeNamesOfLikersOfTheSpecifiedStatusUpdate( $detailsOfStatusUpdate['status_update_id'], 
                     $_GET['offsetForNamesOfLikers'], $_GET['numberOfNamesOfLikersToBeDisplayed'] ) . 
                  getMarkupToDisplayLinkForViewingPreviousNamesOfLikers( $detailsOfStatusUpdate['status_update_id'] ) . 
                  getMarkupToDisplayLinkForViewingMoreNamesOfLikers( $detailsOfStatusUpdate['status_update_id'] ) . '
               </div>

               <div class="infoAboutComments">' .
                  getMarkupToDisplayLinkForViewingComments( $detailsOfStatusUpdate['status_update_id'] ) . '
               </div>
               ' . 
               getMarkupForPostCommentForm( $detailsOfStatusUpdate['status_update_id'] ) . '
            </footer>
         </section> <!-- end section.statusUpdate -->
         ';
      }

   }


   function getMarkupToDisplayHeaderAndBodyOfStatusUpdate( $detailsOfStatusUpdate )
   {
      $namesOfPoster = retrieveFromDatabaseFirstNameLastNameAndNickName( $detailsOfStatusUpdate['id_of_poster'] );

      if ( doesNotExistInDatabase( $namesOfPoster ) ) {
         return '
            <header class="statusUpdateHeader">There is something wrong with this status update.</header>';
      }
      else {
         return '
            <header class="statusUpdateHeader">
               <h2 class="nameOfPoster">' . $namesOfPoster['first_name'] . ' ' . $namesOfPoster['last_name'] . '</h2> 
               <h3 class="timeOfPosting">' . 
                  $detailsOfStatusUpdate['month_of_posting'] . ' ' . $detailsOfStatusUpdate['day_of_posting'] .
                  ' at ' . 
                  formatTimeShowingAmOrPm( $detailsOfStatusUpdate['hour_of_posting'], $detailsOfStatusUpdate['minute_of_posting'] ) .
               '</h3>
            </header>

            <div class="statusUpdateText">
               ' . $detailsOfStatusUpdate['status_update_text'] . '
            </div>';
      }

   }


   function getMarkupToDisplayLikeButtonOrUnlikeButton( $idOfStatusUpdate )
   {
      $markup = '
                  <form method="POST" action="processLikeOrUnlikeStatusUpdateRequest.php" class="containerForLikeButtonOrUnlikeButton">
                     <input type="hidden" name="idOfStatusUpdate" value="' . $idOfStatusUpdate . '" />';

      if ( userLikesStatusUpdate( $_SESSION['idOfLoggedInUser'], $idOfStatusUpdate ) ) {
         $markup .= '
                     <input type="submit" name="unlikeButton" value="Unlike" class="likeButtonOrUnlikeButton" />';
      }
      else {
         $markup .= '
                     <input type="submit" name="likeButton" value="Like" class="likeButtonOrUnlikeButton" />';
      }

      $markup .= '
                  </form>
      ';

      return $markup;
   }


   function getMarkupToDisplayLinkForViewingNamesOfLikers( $numberOfLikes, $idOfStatusUpdate )
   {
      $markup = '
                  <a href="' . $_SERVER['PHP_SELF'] . '?requiredAction=viewNamesOfLikers&idOfRequiredStatusUpdate=' . $idOfStatusUpdate . '&offsetForNamesOfLikers=0&numberOfNamesOfLikersToBeDisplayed=' . DEFAULT_NUMBER_OF_ROWS_FOR_LIKES . '#' . $idOfStatusUpdate . '" class="linkWithinStatusUpdate">';

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
                  <a href="index.php?requiredAction=viewComments&idOfRequiredStatusUpdate=' . $idOfStatusUpdate . '&offsetForComments=0&numberOfCommentsToBeDisplayed=' . DEFAULT_NUMBER_OF_ROWS_FOR_COMMENTS . '#' . $idOfStatusUpdate .  '" class="linkWithinStatusUpdate">View comments on this post.</a>';
      }
      else {
         return '';
      }

   }


   function getMarkupForPostCommentForm( $idOfStatusUpdate )
   {
      return '
               <form method="POST" action="processPostNewCommentRequest.php" class="containerForCommentField">
                  <input type="hidden" name="idOfStatusUpdate" value="' . $idOfStatusUpdate . '" />
                  <input type="text" name="commentText" placeholder="Write a comment..." class="commentField" />
                  <input type="submit" value="Post" class="commentButton" />
               </form>';
   }


   function getMarkupToDisplayLinkForHidingComments( $idOfStatusUpdate )
   {
      return '
                  <a href="index.php?requiredAction=hideComments#' . $idOfStatusUpdate . '" class="linkWithinStatusUpdate" id="linkForHidingComments">Hide comments</a>';
   }


   function getMarkupToDisplayGeneralHeadingForComments()
   {
      return '
                  <h1 class="headingForComments">Comments on this post:</h1>
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
                  <section class="comment">Couldn\'t find this comment, it must have been deleted.</section>';
      }

      $namesOfCommenter = 
         retrieveFromDatabaseFirstNameLastNameAndNickName( $detailsOfComment['id_of_commenter'] );

      if ( doesNotExistInDatabase( $namesOfCommenter ) ) {
         return '
                  <section class="comment">There is something wrong with this comment.</section>';
      }

      return '
                  <section class="comment">
                     <header class="commentHeader">
                        <h2 class="nameOfCommenter">' . $namesOfCommenter['first_name'] . ' ' . $namesOfCommenter['last_name'] . '</h2>
                        <h3 class="timeOfCommenting">' . 
                           $detailsOfComment['month_of_commenting'] . ' ' . $detailsOfComment['day_of_commenting'] . 
                           ' at ' . 
                           formatTimeShowingAmOrPm( $detailsOfComment['hour_of_commenting'], $detailsOfComment['minute_of_commenting'] ) . 
                        '</h3>
                     </header>

                     <p class="commentText">
                        ' . $detailsOfComment['comment_text'] . '
                     </p>
                  </section>
         ';
   }


   function getMarkupToDisplayLinkForViewingOlderComments( $idOfStatusUpdate )
   {

      if ( atLeastOneOlderCommentOnThisStatusUpdateExistsInDatabase( $idOfStatusUpdate ) ) {
         return '
                  <a href="index.php?requiredAction=viewComments&idOfRequiredStatusUpdate=' . $idOfStatusUpdate . '&offsetForComments=' . $_SESSION['totalNumberOfCommentsDisplayedSoFar'] . '&numberOfCommentsToBeDisplayed=' . DEFAULT_NUMBER_OF_ROWS_FOR_COMMENTS . '#' . $idOfStatusUpdate . '" class="linkWithinStatusUpdate" id="linkForViewingOlderComments">&lt&ltView Older Comments</a>';
      }
      else {
         return '';
      }

   }


   function getMarkupToDisplayLinkForViewingNewerComments( $idOfStatusUpdate )
   {

      if ( $_SESSION['totalNumberOfCommentsDisplayedSoFar'] > DEFAULT_NUMBER_OF_ROWS_FOR_COMMENTS ) {
         return '
                  <a href="index.php?requiredAction=viewComments&idOfRequiredStatusUpdate=' . $idOfStatusUpdate . '&offsetForComments=' . ( $_SESSION['totalNumberOfCommentsDisplayedSoFar'] - $_SESSION['totalNumberOfCommentsCurrentlyListed'] - DEFAULT_NUMBER_OF_ROWS_FOR_COMMENTS ) . '&numberOfCommentsToBeDisplayed=' . DEFAULT_NUMBER_OF_ROWS_FOR_COMMENTS . '#' . $idOfStatusUpdate .  '" class="linkWithinStatusUpdate" id="linkForViewingNewerComments">View Newer Comments&gt;&gt;</a>';
      }
      else {
         return '';
      }

   }


   function getMarkupToDisplayLinkForHidingNamesOfLikers( $idOfStatusUpdate )
   {
      return '
                  <a href="index.php?requiredAction=hideNamesOfLikers#' . $idOfStatusUpdate . '" class="linkWithinStatusUpdate" id="linkForHidingNamesOfLikers">Hide names of likers</a>';
   }


   function getMarkupToDisplayGeneralHeadingForNamesOfLikers()
   {
      return '
                  <h1 class="headingForNamesOfLikers">The following people like this post:</h1>
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
                     <li class="nameOfLiker">Couldn\'t find the name of this liker, something is wrong somewhere</li>';
      }
      else {
         return '
                     <li class="nameOfLiker">' . $nameOfLiker['first_name'] . ' ' . $nameOfLiker['last_name'] . '</li>';
      }

   }


   function getMarkupToDisplayLinkForViewingPreviousNamesOfLikers( $idOfStatusUpdate )
   {

      if ( $_SESSION['totalNumberOfLikersDisplayedSoFar'] > DEFAULT_NUMBER_OF_ROWS_FOR_LIKES ) {
         return '
                  <a href="index.php?requiredAction=viewNamesOfLikers&idOfRequiredStatusUpdate=' . $idOfStatusUpdate . '&offsetForNamesOfLikers=' . ( $_SESSION['totalNumberOfLikersDisplayedSoFar'] - $_SESSION['totalNumberOfLikersCurrentlyListed'] - DEFAULT_NUMBER_OF_ROWS_FOR_LIKES ) . '&numberOfNamesOfLikersToBeDisplayed=' . DEFAULT_NUMBER_OF_ROWS_FOR_LIKES . '#' . $idOfStatusUpdate . '" class="linkWithinStatusUpdate" id="linkForViewingPreviousNamesOfLikers">&lt;&lt;View previous</a>';
      }
      else {
         return '';
      }

   }


   function getMarkupToDisplayLinkForViewingMoreNamesOfLikers( $idOfStatusUpdate )
   {

      if ( atLeastOneMoreLikerOfThisStatusUpdateExistsInDatabase( $idOfStatusUpdate ) ) {
         return '
                  <a href="index.php?requiredAction=viewNamesOfLikers&idOfRequiredStatusUpdate=' . $idOfStatusUpdate . '&offsetForNamesOfLikers=' . $_SESSION['totalNumberOfLikersDisplayedSoFar'] . '&numberOfNamesOfLikersToBeDisplayed=' . DEFAULT_NUMBER_OF_ROWS_FOR_LIKES . '#' . $idOfStatusUpdate . '" class="linkWithinStatusUpdate" id="linkForViewingMoreNamesOfLikers">View more&gt;&gt;</a>';
      }
      else {
         return '';
      }

   }


   function getMarkupToDisplayLinkForViewingMoreStatusUpdates()
   {

      if ( atLeastOneMoreStatusUpdateExistsInDatabase()) {
         return '
         <a href="index.php?requiredAction=viewMoreStatusUpdates&offsetForStatusUpdates=' . $_SESSION['totalNumberOfStatusUpdatesDisplayedSoFar'] . '&numberOfStatusUpdatesToBeDisplayed=' . DEFAULT_NUMBER_OF_ROWS_FOR_STATUS_UPDATES . '">View more posts</a>
         ';
      }
      else {
         return '';
      }

   }


   function getMarkupForTopOfProfilePage( $urlOfCurrentProfilePage )
   {
      return '
         <div class="topOfProfilePage">
            <img src="images/coverPhoto.jpg" height="260px" width="100%" name="coverPhoto" class="coverPhoto"/>' .

            getMarkupToDisplayUserNames()  . '
            <nav class="otherImportantLinks">
               <ul>
                  <li><a href="myProfile.php" class="otherImportantLink" ' . ( $urlOfCurrentProfilePage == 'myProfile.php' ? 'id="currentPage"' : '' ) . '>Timeline</a></li>
                  <li><a href="aboutMe.php" class="otherImportantLink" ' . ( $urlOfCurrentProfilePage == 'aboutMe.php' ? 'id="currentPage"' : '' ) . '>About</a></li>
                  <li><a href="myFriends.php" class="otherImportantLink" ' . ( $urlOfCurrentProfilePage == 'myFriends.php' ? 'id="currentPage"' : '' ) . '>Friends&nbsp;<span class="numberOfFriends">' . $_SESSION['totalNumberOfFriends'] . '</span></a></li>
                  <li><a href="manageAccount.php" class="otherImportantLink" ' . ( $urlOfCurrentProfilePage == 'editAccountInformation.php' ? 'id="currentPage"' : '' ) . '>Manage Account</a></li>
                  <li><a class="otherImportantLink"></a></li>
               </ul>
            </nav>
         </div>  <!-- end div.topOfProfilePage -->
      ';
   }


   function getMarkupToDisplayUserNames()
   {
      $names = retrieveFromDatabaseFirstNameLastNameAndNickName( $_SESSION['idOfLoggedInUser'] );

      if ( doesNotExistInDatabase( $names ) ) {
         return '
            <div class="userNames">Could not find user\'s name in database.</div>';
      }

      $markup = '
            <div class="userNames">
               <h1 class="properNames">'  .  $names['first_name']  .  ' '  .  $names['last_name']  .  '</h1>
      ';

      if ( $names['nick_name'] != NULL ) {
         $markup .= '
               <h2 class="nickName">('  .  $names['nick_name']  .  ')</h2>
         ';
      }

      $markup .= '
            </div>  <!-- end div.userNames -->
      ';

      return $markup;
   }


   function getMarkupToDisplayBirthdayDetailsOfLoggedInUser()
   {
      $birthdayDetails = retrieveFromDatabaseBirthdayDetails( $_SESSION['idOfLoggedInUser'] );
      $dayOfBirth = $birthdayDetails['day_of_birth'];

      if ( doesNotExistInDatabase( $dayOfBirth ) ) {
         return getMarkupToShowThatProfileDetailsDoNotExist( 'Birthday', 'editBirthdayDetails.php' );
      }
      else {
         $formattedBirthdayDetails = formatBirthdayDetails( $birthdayDetails );

         return getMarkupToDisplayProfileDetails( 'Birthday', 
            'editBirthdayDetails.php', $formattedBirthdayDetails );
      }

   }


   function getMarkupToDisplayCurrentCityDetailsOfLoggedInUser()
   {
      $rowContainingIdOfCurrentCity = retrieveFromDatabaseIdOfCurrentCity( $_SESSION['idOfLoggedInUser'] );
      $idOfCurrentCity = $rowContainingIdOfCurrentCity['id_of_current_city'];

      if ( doesNotExistInDatabase( $idOfCurrentCity ) ) {
         return getMarkupToShowThatProfileDetailsDoNotExist( 'Current City', 'editCurrentCityDetails.php' );
      }
      else {
         $rowContainingCurrentCityDetails = retrieveFromDatabaseCityDetails( $idOfCurrentCity );
         $formattedCurrentCityDetails = formatCityDetails( $rowContainingCurrentCityDetails );

         return getMarkupToDisplayProfileDetails( 'Current City',
            'editCurrentCityDetails.php', $formattedCurrentCityDetails );
      }

   }


   function getMarkupToDisplayHometownDetailsOfLoggedInUser()
   {
      $rowContainingIdOfHometown = retrieveFromDatabaseIdOfHometown( $_SESSION['idOfLoggedInUser'] );
      $idOfHometown = $rowContainingIdOfHometown['id_of_hometown'];

      if ( doesNotExistInDatabase( $idOfHometown ) ) {
         return getMarkupToShowThatProfileDetailsDoNotExist( 'Hometown', 'editHometownDetails.php' );
      }
      else {
         $rowContainingHometownDetails = retrieveFromDatabaseCityDetails( $idOfHometown );
         $formattedHometownDetails = formatCityDetails( $rowContainingHometownDetails );

         return getMarkupToDisplayProfileDetails( 'Hometown',
            'editHometownDetails.php', $formattedHometownDetails );
      } 

   }


   function getMarkupToDisplayGenderDetailsOfLoggedInUser()
   {
      $rowContainingIdOfGender = retrieveFromDatabaseIdOfGender( $_SESSION['idOfLoggedInUser'] );
      $idOfGender = $rowContainingIdOfGender['id_of_gender'];

      if ( doesNotExistInDatabase( $idOfGender ) ) {
         return getMarkupToShowThatProfileDetailsDoNotExist( 'Gender', 'editGenderDetails.php' );
      }
      else {
         $rowContainingGenderDetails = retrieveFromDatabaseGenderDetails( $idOfGender );
         $formattedGenderDetails = formatGenderDetails( $rowContainingGenderDetails );

         return getMarkupToDisplayProfileDetails( 'Gender', 
            'editGenderDetails.php', $formattedGenderDetails );
      }

   }


   function getMarkupToDisplayLanguageDetailsOfLoggedInUser()
   {
      $idOfAllLanguagesSpoken = 
         retrieveFromDatabaseAndReturnInArrayIdOfAllLanguagesSpoken( $_SESSION['idOfLoggedInUser'] );

      if ( doesNotExistInDatabase( $idOfAllLanguagesSpoken ) ) {
         return getMarkupToShowThatProfileDetailsDoNotExist( 'Languages Spoken', 'editLanguagesSpokenDetails.php' );
      }
      else {
         $namesOfAllLanguagesSpoken = 
            retrieveFromDatabaseAndReturnInArrayNamesOfAllLanguagesSpoken( $idOfAllLanguagesSpoken );
         $formattedLanguageDetails = formatLanguageDetails( $namesOfAllLanguagesSpoken );

         return getMarkupToDisplayProfileDetails( 'Languages Spoken', 
            'editLanguagesSpokenDetails.php', $formattedLanguageDetails );
      }

   }


   function getMarkupToDisplayFavouriteQuoteDetailsOfLoggedInUser()
   {
      $rowContainingFavouriteQuoteDetails = 
         retrieveFromDatabaseFavouriteQuoteDetails( $_SESSION['idOfLoggedInUser'] );
      $favouriteQuoteDetails = $rowContainingFavouriteQuoteDetails['favourite_quotes'];

      if ( doesNotExistInDatabase( $favouriteQuoteDetails ) ) {
         return getMarkupToShowThatProfileDetailsDoNotExist( 'Favourite Quotes',
            'editFavouriteQuoteDetails.php' );
      }
      else {
         $formattedFavouriteQuoteDetails = formatFavouriteQuoteDetails( $rowContainingFavouriteQuoteDetails );

         return getMarkupToDisplayProfileDetails( 'Favourite Quotes', 
            'editFavouriteQuoteDetails.php', $formattedFavouriteQuoteDetails );
      }

   }


   function getMarkupToDisplayAboutMeDetailsOfLoggedInUser()
   {
      $rowContainingAboutMeDetails = retrieveFromDatabaseAboutMeDetails( $_SESSION['idOfLoggedInUser'] );
      $aboutMeDetails = $rowContainingAboutMeDetails['about_me'];

      if ( doesNotExistInDatabase( $aboutMeDetails ) ) {
         return getMarkupToShowThatProfileDetailsDoNotExist( 'About Me', 'editAboutMeDetails.php' );
      }
      else {
         $formattedAboutMeDetails = formatAboutMeDetails( $rowContainingAboutMeDetails );

         return getMarkupToDisplayProfileDetails( 'About Me', 
            'editAboutMeDetails.php', $formattedAboutMeDetails );
      }

   }


   function getMarkupToDisplayPhoneNumberDetailsOfLoggedInUser()
   {
      $rowContainingPhoneNumberDetails = retrieveFromDatabasePhoneNumberDetails( $_SESSION['idOfLoggedInUser'] );
      $phoneNumberDetails = $rowContainingPhoneNumberDetails['phone_number'];

      if ( doesNotExistInDatabase( $phoneNumberDetails ) ) {
         return getMarkupToShowThatProfileDetailsDoNotExist( 'Phone Number', 'editPhoneNumberDetails.php' );
      }
      else {
         $formattedPhoneNumberDetails = formatPhoneNumberDetails( $rowContainingPhoneNumberDetails );
         return getMarkupToDisplayProfileDetails( 'Phone Number', 
            'editPhoneNumberDetails.php', $formattedPhoneNumberDetails );
      }

   }


   function getMarkupToDisplayEmailAddressDetailsOfLoggedInUser()
   {
      $rowContainingEmailAddressDetails = retrieveFromDatabaseEmailAddressDetails( $_SESSION['idOfLoggedInUser'] );
      $emailAddressDetails = $rowContainingEmailAddressDetails['email_address'];

      if ( doesNotExistInDatabase( $emailAddressDetails ) ) {
         return getMarkupToShowThatProfileDetailsDoNotExist( 'Email Address', 'editEmailAddressDetails.php' );
      }
      else {
         $formattedEmailAddressDetails = formatEmailAddressDetails( $rowContainingEmailAddressDetails );
         return getMarkupToDisplayProfileDetails( 'Email Address', 
            'editEmailAddressDetails.php', $formattedEmailAddressDetails );
      }

   }


   function getMarkupToShowThatProfileDetailsDoNotExist( $title, $urlOfEditLink )
   {
      return '
         <section class="userDetail" id="' . $title . '">
            <header class="headerForUserDetail">
               <h2 class="headingForUserDetail">' . $title . '</h2>
            </header>

            <p class="bodyForUserDetail">
               No ' . strtolower( $title ) . ' details existing. 
               <a href="' . $urlOfEditLink . '">Click here to add ' . strtolower( $title ) . ' details.</a>
            </p>
         </section>
      ';
   }


   function getMarkupToDisplayProfileDetails( $title, $urlOfEditPage, $details )
   {
      return '
         <section class="userDetail" id="' . $title . '">
            <header class="headerForUserDetail">
               <h2 class="headingForUserDetail">' . $title . '</h2>
               <p class="editLinkForUserDetail"><a href="' . $urlOfEditPage . '">Edit</a></p>
            </header>

            <p class="bodyForUserDetail">
               ' .  $details . '
            </p>
         </section>
      ';
   }


   function getMarkupForEditBirthdayDetailsFormAndSetValuesRetrievedFromDatabaseAsDefaultValues()
   {
      $birthdayDetails = retrieveFromDatabaseBirthdayDetails( $_SESSION['idOfLoggedInUser'] );

      return
         getMarkupForTheOpeningTagOfFormElement() .

         getMarkupForTheOpeningTagOfLabelElementInEditForms() . '
               Month of birth:' .
         getMarkupForSelectElementForSelectingMonthOfBirth( $birthdayDetails['month_of_birth'] ) .
         getMarkupForTheClosingTagOfLabelElementInEditForms() .

         getMarkupForTheOpeningTagOfLabelElementInEditForms() . '
               Day of birth:' .
         getMarkupForSelectElementForSelectingDayOfBirth( $birthdayDetails['day_of_birth'] ) .
         getMarkupForTheClosingTagOfLabelElementInEditForms() .

         getMarkupForTheOpeningTagOfLabelElementInEditForms() . '
               Year of birth:' .
         getMarkupForSelectElementForSelectingYearOfBirth( $birthdayDetails['year_of_birth'] ) .
         getMarkupForTheClosingTagOfLabelElementInEditForms() .

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
            getMarkupForTheOpeningTagOfLabelElementInEditForms() . '
               Month of birth:' .
               getMarkupForSelectElementForSelectingMonthOfBirth( $_POST['monthOfBirth'] ) .
               getMarkupForErrorMessageIfValueIsInvalid( $_POST['monthOfBirth'], 'Invalid&nbsp;month.' ) .
            getMarkupForTheClosingTagOfLabelElementInEditForms() .

            getMarkupForTheOpeningTagOfLabelElementInEditForms() . '
               Day of brth:' .
               getMarkupForSelectElementForSelectingDayOfBirth( $_POST['dayOfBirth'] ) .
               getMarkupForErrorMessageIfValueIsInvalid( $_POST['dayOfBirth'], 'Invalid&nbsp;day.' ) .
            getMarkupForTheClosingTagOfLabelElementInEditForms() .

            getMarkupForTheOpeningTagOfLabelElementInEditForms() . '
               Year of birth:' .
               getMarkupForSelectElementForSelectingYearOfBirth( $_POST['yearOfBirth'] ) .
               getMarkupForErrorMessageIfValueIsInvalid( $_POST['yearOfBirth'], 'Invalid&nbsp;year.' ) .
            getMarkupForTheClosingTagOfLabelElementInEditForms() .

            getMarkupForSaveButtonAndCancelButton() .
         getMarkupForTheClosingTagOfFormElement();
   }


   function getMarkupForEditBirthdayDetailsFormAndShowThatTheDateSelectedByUserIsNotCalenderDate()
   {
      return
         getMarkupForTheOpeningTagOfFormElement() .
            getMarkupForTheOpeningTagOfLabelElementInEditForms() . '
               Month of birth:' .
               getMarkupForSelectElementForSelectingMonthOfBirth( $_POST['monthOfBirth'] ) .
            getMarkupForTheClosingTagOfLabelElementInEditForms() .

            getMarkupForTheOpeningTagOfLabelElementInEditForms() . '
               Day of birth:' .
               getMarkupForSelectElementForSelectingDayOfBirth( $_POST['dayOfBirth'] ) .
            getMarkupForTheClosingTagOfLabelElementInEditForms() .

            getMarkupForTheOpeningTagOfLabelElementInEditForms() . '
               Year of birth:' .
               getMarkupForSelectElementForSelectingYearOfBirth( $_POST['yearOfBirth'] ) .
            getMarkupForTheClosingTagOfLabelElementInEditForms() . 

            '
            <span class="errorMessageInEditForm">
               Invalid Date: <br />
               In ' . $year . ', there was no ' . convertToNameOfMonth( $month ) . ' ' . $day . '.<br />
               Please select a valid date.
            </span>
            ' .

            getMarkupForSaveButtonAndCancelButton() .
         getMarkupForTheClosingTagOfFormElement();
   }


   function getMarkupForSelectElementForSelectingMonthOfBirth( $defaultMonthOfBirth )
   {
      $selectElement = '
               <select name="monthOfBirth">
                  <option value="' . INVALID . '">----</option>';

      for ( $month = 1; $month <= 12; $month++ ) {

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
               <select name="dayOfBirth">
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
               <select name="yearOfBirth">
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
            getMarkupForTheOpeningTagOfLabelElementInEditForms() . '
               Name of city:' .
               getMarkupForInputElementForEnteringNameOfCity( $defaultNameOfCity ) .
            getMarkupForTheClosingTagOfLabelElementInEditForms() .

            getMarkupForTheOpeningTagOfLabelElementInEditForms() . '
               Name of country:' .
               getMarkupForInputElementForEnteringNameOfCountry( $defaultNameOfCountry ) .
            getMarkupForTheClosingTagOfLabelElementInEditForms() .

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
            getMarkupForTheOpeningTagOfLabelElementInEditForms() . '
               Name of city:' .
               getMarkupForInputElementForEnteringNameOfCity( $defaultNameOfCity ) .
            getMarkupForTheClosingTagOfLabelElementInEditForms() .

            getMarkupForTheOpeningTagOfLabelElementInEditForms() . '
               Name of country:' .
               getMarkupForInputElementForEnteringNameOfCountry( $defaultNameOfCountry ) .
            getMarkupForTheClosingTagOfLabelElementInEditForms() .

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
            getMarkupForTheOpeningTagOfLabelElementInEditForms() . '
               Name of city:' .
               getMarkupForInputElementForEnteringNameOfCity( $_POST['nameOfCity'] ) .
               getMarkupForErrorMessageIfValueIsEmpty( $_POST['nameOfCity'], 'Enter the name of your city.' ) .
            getMarkupForTheClosingTagOfLabelElementInEditForms() .

            getMarkupForTheOpeningTagOfLabelElementInEditForms() . '
               Name of country:' .
               getMarkupForInputElementForEnteringNameOfCountry( $_POST['nameOfCountry'] ) .
               getMarkupForErrorMessageIfValueIsEmpty( $_POST['nameOfCountry'], 'Enter the name of your country.' ) .
            getMarkupForTheClosingTagOfLabelElementInEditForms() .

            getMarkupForSaveButtonAndCancelButton() .
         getMarkupForTheClosingTagOfFormElement();
   }


   function getMarkupForInputElementForEnteringNameOfCity( $defaultNameOfCity )
   {
      return '
               <input type="text" name="nameOfCity" value="' . $defaultNameOfCity . '" />
      ';
   }


   function getMarkupForInputElementForEnteringNameOfCountry( $defaultNameOfCountry )
   {
      return '
               <input type="text" name="nameOfCountry" value="' . $defaultNameOfCountry . '" />
      ';
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
            <p>Please, select your gender:</p>' .

            getMarkupForTheOpeningTagOfLabelElementInEditForms() .
               getMarkupForRadioButtonRepresentingMaleGender( $defaultGender ) .
            getMarkupForTheClosingTagOfLabelElementInEditForms() .

            getMarkupForTheOpeningTagOfLabelElementInEditForms() .
               getMarkupForRadioButtonRepresentingFemaleGender( $defaultGender ) .
            getMarkupForTheClosingTagOfLabelElementInEditForms() .

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
            <p>Please, select your gender:</p>' .

            getMarkupForTheOpeningTagOfLabelElementInEditForms() .
               getMarkupForRadioButtonRepresentingMaleGender( $defaultGender ) .
            getMarkupForTheClosingTagOfLabelElementInEditForms() .

            getMarkupForTheOpeningTagOfLabelElementInEditForms() .
               getMarkupForRadioButtonRepresentingFemaleGender( $defaultGender ) .
            getMarkupForTheClosingTagOfLabelElementInEditForms() .

            '
            <span class="errorMessageInEditForm">Please select your gender</span>
            <br/>' .

            getMarkupForSaveButtonAndCancelButton() .
         getMarkupForTheClosingTagOfFormElement();
   }


   function getMarkupForRadioButtonRepresentingMaleGender( $defaultGender )
   {

      if ( $defaultGender == 'male' ) {
         return '
               <input type="radio" name="genderDetails" value="male" checked/> Male';
      }
      else {
         return '
               <input type="radio" name="genderDetails" value="male"/> Male';
      }

   }


   function getMarkupForRadioButtonRepresentingFemaleGender( $defaultGender )
   {

      if ( $defaultGender == 'female' ) {
         return '
               <input type="radio" name="genderDetails" value="female" checked/> Female';
      }
      else {
         return '
               <input type="radio" name="genderDetails" value="female"/> Female';
      }

   }


   function getMarkupForAddNewLanguageForm()
   {
      $allLanguagesSpokenByLoggedInUser = 
         retrieveFromDatabaseAndReturnInArrayIdOfAllLanguagesSpoken( $_SESSION['idOfLoggedInUser'] );
      $languageNumber = sizeof( $allLanguagesSpokenByLoggedInUser ) + 1;

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
         $languageNumber = sizeof( $idOfLanguages );
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
         $languageNumber = sizeof( $idOfLanguages );
         $list .= getMarkupForEditLanguageFormWithTextFieldForSpecifyingNameOfLanguage(
            NEW_LANGUAGE, $languageNumber );
      }

      return $list;
   }


   function getMarkupThatDisplaysNameOfLanguageWithEditButtonAndDeleteButton( $idOfLanguage, $languageNumber )
   {
      if ( detailsOfLanguageIsNotStoredInSESSION( $idOfLanguage ) ) {
         return '';
      }
      else {
         $index = getIndexOfPositionWhereLanguageIsStoredInSESSION( $idOfLanguage );
         $nameOfLanguage = $_SESSION['nameOfLanguage' . $index];

         return 
            getMarkupForTheOpeningTagOfSectionElementForLanguageEntry() .
               getMarkupForParagraphElementContainingLanguageNumber( $languageNumber ) .

               getMarkupForTheOpeningTagOfFormElement() .
                  getMarkupForHiddenInputElementContainingIdOfLanguageToBeEdited( $idOfLanguage ) . '
                  <span>' . capitalizeWordsThatShouldBeCapitalized( $nameOfLanguage ) . '</span>' .
                  getMarkupForEditButtonAndDeleteButton() .
               getMarkupForTheClosingTagOfFormElement() .
            getMarkupForTheClosingTagOfSectionElement();
      }

   }


   function getMarkupForEditLanguageForm( $idOfLanguageToBeEdited, $languageNumber )
   {
      $idOfLanguageToBePreSelected =
         ( isset( $_POST['idOfSelectedLanguage'] ) ? $_POST['idOfSelectedLanguage'] : $idOfLanguageToBeEdited );

      return 
         getMarkupForTheOpeningTagOfSectionElementForLanguageEntry() .
            getMarkupForParagraphElementContainingLanguageNumber( $languageNumber ) .

            getMarkupForTheOpeningTagOfFormElement() .
               getMarkupForHiddenInputElementContainingIdOfLanguageToBeEdited( $idOfLanguageToBeEdited ) .
               getMarkupForSelectElementForSelectingLanguage( $idOfLanguageToBePreSelected ) .
               getMarkupForErrorMessageIfValueIsInvalid( $idOfLanguageToBePreSelected, 'Please, select a valid language' ) .
               getMarkupForSaveButtonAndCancelButton() .
            getMarkupForTheClosingTagOfFormElement() .
         getMarkupForTheClosingTagOfSectionElement();
   }


   function getMarkupForEditLanguageFormWithTextFieldForSpecifyingNameOfLanguage( 
      $idOfLanguageToBeEdited, $languageNumber )
   {
      $idOfLanguageToBePreSelected = $_POST['idOfSelectedLanguage'];
      $nameOfNewLanguage = ( isset( $_POST['nameOfNewLanguage'] ) ? $_POST['nameOfNewLanguage'] : NULL );

      return 
         getMarkupForTheOpeningTagOfSectionElementForLanguageEntry() .
            getMarkupForParagraphElementContainingLanguageNumber( $languageNumber ) .

               getMarkupForTheOpeningTagOfFormElement() .
                  getMarkupForHiddenInputElementContainingIdOfLanguageToBeEdited( $idOfLanguageToBeEdited ) .
                  getMarkupForSelectElementForSelectingLanguage( $idOfLanguageToBePreSelected ) .
                  getMarkupForTextFieldForSpecifyingNameOfLanguage( $nameOfNewLanguage ) .
                  getMarkupForErrorMessageIfValueIsEmpty( $nameOfNewLanguage, 'Please, specify the name of your language' ) .
                  getMarkupForErrorMessageIfValueIsAnInvalidNameOfLanguage( $nameOfNewLanguage, 'Invalid name of language' ) .
                  getMarkupForSaveButtonAndCancelButton() .
               getMarkupForTheClosingTagOfFormElement() .
         getMarkupForTheClosingTagOfSectionElement();
   }


   function getMarkupForTheOpeningTagOfSectionElementForLanguageEntry()
   {
      return '
         <section class="languageEntry">';
   }


   function getMarkupForTheClosingTagOfSectionElement()
   {
      return '
         </section>';
   }


   function getMarkupForParagraphElementContainingLanguageNumber( $languageNumber )
   {
      return '
            <p class="languageNumber">LANGUAGE ' . $languageNumber . ': </p>';
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

      for ( $index = 0; $index < $_SESSION['totalNumberOfLanguages']; $index++ ) {

         if ( $_SESSION['idOfLanguage' . $index] == $idOfDefaultLanguage ) {
            $selectElement .= '
                        <option value="' . $_SESSION['idOfLanguage' . $index] . '" selected>' . $_SESSION['nameOfLanguage' . $index] . '</option>';
         }
         else {
            $selectElement .= '
                        <option value="' . $_SESSION['idOfLanguage' . $index] . '">' . $_SESSION['nameOfLanguage' . $index] . '</option>';
         }

      }

      $selectElement .= '
                     </select>';

      return $selectElement;
   }


   function getMarkupForTextFieldForSpecifyingNameOfLanguage( $defaultNameOfLanguage = NULL )
   {
      return '
                  <label class="fieldInEditForm">
                     What is the name of your language? 
                     <input type="text" name="nameOfNewLanguage" value="' . $defaultNameOfLanguage . '"/>
                  </label>';
   }


   function getMarkupForEditButtonAndDeleteButton()
   {
      return '
                  <input type="submit" name="editLanguageButton" value="Edit" class="buttonInEditForm" />
                  <input type="submit" name="deleteLanguageButton" value="Delete" class="buttonInEditForm" />';
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
            <label class="fieldInEditForm">
               Enter your favourite quotes: <br />
      ';

      if ( $defaultFavouriteQuotes == INVALID ) {
         $form .= '
               <textarea name="favouriteQuotes" class="textAreaInEditForm"></textarea>
               <br />
               <span class="errorMessageInEditForm">Please enter your favourite quotes</span>';
      }
      else {
         $form .= '
               <textarea name="favouriteQuotes" class="textAreaInEditForm">' . $defaultFavouriteQuotes . '</textarea>';
      }

      $form .= '
            </label>

            <input type="submit" name="cancelButton" value="Cancel" class="buttonInEditForm" />
            <input type="submit" name="saveButton" value="Save" class="buttonInEditForm" />
         </form>
      ';

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
            <label class="fieldInEditForm">
               What are some things about you which you want your friends to know? <br />
      ';

      if ( $defaultAboutMeDetails == INVALID ) {
         $form .= '
               <textarea name="aboutMe" class="textAreaInEditForm"></textarea>
               <br />
               <span class="errorMessageInEditForm">Please fill this field</span>';
      }
      else {
         $form .= '
               <textarea name="aboutMe" class="textAreaInEditForm">' . $defaultAboutMeDetails . '</textarea>';
      }

      $form .= '
            </label>

            <input type="submit" name="cancelButton" value="Cancel" class="buttonInEditForm" />
            <input type="submit" name="saveButton" value="Save" class="buttonInEditForm" />
         </form>
      ';

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
            <label class="fieldInEditForm">
               Phone number:
               <input type="text" name="phoneNumber" value="' . $defaultPhoneNumber . '" />';

      if ( $defaultPhoneNumber === '' ) {
         $form .= '
               <span class="errorMessageInEditForm">Please, enter your phone number.</span>';
      }

      if ( $status == INVALID_PHONE_NUMBER ) {
         $form .= '
               <span class="errorMessageInEditForm">Invalid phone number.</span>';
      }

      if ( $status == ANOTHER_USER_HAS_THE_SAME_PHONE_NUMBER ) {
         $form .= '
               <span class="errorMessageInEditForm">Another ife_facebook user already uses this phone number.</span>';
      }

      $form .= '
            </label>

            <input type="submit" name="saveButton" value="Save" class="buttonInEditForm" />
            <input type="submit" name="cancelButton" value="Cancel" class="buttonInEditForm" />
         </form>
      ';

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
            <label class="fieldInEditForm">
               Email Address:
               <input type="text" name="emailAddress" value="' . $defaultEmailAddress . '" />';

      if ( $defaultEmailAddress === '' ) {
         $form .= '
               <span class="errorMessageInEditForm">Please, enter your email address.</span>';
      }

      if ( $status == INVALID_EMAIL_ADDRESS ) {
         $form .= '
               <span class="errorMessageInEditForm">Invalid email address.</span>';
      }

      if ( $status == ANOTHER_USER_HAS_THE_SAME_EMAIL_ADDRESS ) {
         $form .= '
               <span class="errorMessageInEditForm">Another ife_facebook user already uses this email address.</span>';
      }

      $form .= '
            </label>

            <input type="submit" name="saveButton" value="Save" class="buttonInEditForm" />
            <input type="submit" name="cancelButton" value="Cancel" class="buttonInEditForm" />
         </form>
      ';

      return $form;
   }


   function getMarkupToIndicateThatLanguageWasRepeated( $idOfRepeatedLanguage )
   {
      return '
         <div class="containerForErrorMessageInEditForm">
            <span class="errorMessageInEditForm">
               Repeated Language!<br /> 
               The language which you selected as "LANGUAGE ' . getIndexOfLanguage( $_POST['idOfLanguageToBeEdited'] ) . '" 
               is exactly the same as "LANGUAGE ' . getIndexOfLanguage( $idOfRepeatedLanguage ) . '". 
               Why not select another language?
            </span>
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
            <label class="fieldInEditForm">
               First name:
               <input type="text" name="firstName" value="' . $defaultFirstName . '" maxlength="50"/>';

      if ( $defaultFirstName === '' ) {
         $form .= '
               <span class="errorMessageInEditForm">Please, enter your first name</span>';
      }

      if ( $status == INVALID && isNotValidUserName( $defaultFirstName ) ) {
         $form .= '
               <span class="errorMessageInEditForm">Invalid first name</span>';
      }

      $form .= '
            </label>

            <label class="fieldInEditForm">
               Last name:
               <input type="text" name="lastName" value="' . $defaultLastName . '" maxlength="50"/>';

      if ( $defaultLastName === '' ) {
         $form .= '
               <span class="errorMessageInEditForm">Please, enter your last name</span>';
      }

      if ( $status == INVALID && isNotValidUserName( $defaultLastName ) ) {
         $form .= '
               <span class="errorMessageInEditForm">Invalid last name</span>';
      }

      $form .= '
            </label>

            <label class="fieldInEditForm">
               Nick name (optional):
               <input type="text" name="nickName" value="' . $defaultNickName . '" maxlength="50"/>';


      if ( $status == INVALID && isNotValidUserName( $defaultNickName ) ) {
         $form .= '
               <span class="errorMessageInEditForm">Invalid nick name</span>';
      }

      $form .= '
            </label>

            <input type="submit" name="saveButton" value="Save" class="buttonInEditForm" />
            <input type="submit" name="cancelButton" value="Cancel" class="buttonInEditForm" />
         </form>
      ';

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
            <label  class="fieldInEditForm">
               Current password:
               <input type="password" name="currentPassword" maxlength="50" />';

      if ( $defaultCurrentPassword === '' ) {
         $form .= '
               <span class="errorMessageInEditForm">Please, enter your current password</span>';
      }

      if ( $status == CURRENT_PASSWORD_IS_INCORRECT ) {
         $form .= '
               <span class="errorMessageInEditForm">This password is not correct</span>';
      }

      $form .= '
            </label>

            <label class="fieldInEditForm">
               New password:
               <input type="password" name="newPassword" maxlength="50" />';

      if ( $defaultNewPassword === '' ) {
         $form .= '
               <span class="errorMessageInEditForm">Please, enter your new password</span>';
      }

      $form .= '
            </label>

            <label class="fieldInEditForm">
               Re-enter new password:
               <input type="password" name="confirmationOfNewPassword" maxlength="50" />';

      if ( $defaultConfirmationOfNewPassword === '' ) {
         $form .= '
               <span class="errorMessageInEditForm">Please, re-enter your new password</span>';
      }


      $form .= '
            </label>
      ';

      if ( $status == PASSWORDS_DO_NOT_MATCH ) {
         $form .= '
            <span class="errorMessageInEditForm">The new passwords you entered do not match</span>
            <br />';
      }

      $form .= '
            <input type="submit" name="saveButton" value="Save" class="buttonInEditForm" />
            <input type="submit" name="cancelButton" value="Cancel" class="buttonInEditForm" />
         </form>
      ';

      return $form;
   }


   function getMarkupToConfirmThatUserReallyWantsToDeactivateAccount()
   {
      return '
      <h1>ife_facebook</h1>
      <p>If you deactivate your account, you will no longer have access to ife_facebook services.</p>
      <p>Do you really want to deactivate your account?</p>

      <form method="POST" action="' . $_SERVER['PHP_SELF'] . '">
         <input type="submit" name="yesButton" value="Yes" />
         <input type="submit" name="cancelButton" value="No" />
      </form>
      ';
   }


   function getMarkupToTellUserThatHisAccountHasBeenDeactivated()
   {
      return '
      <h1>ife_facebook</h1>
      <p>Your account has been deactivated. We are very sad to loose you.</p>
      <p>If you wish to sign up to ife_facebook at any time, you can easily visit our sign up page at: <a href="signUpPage.php">ife_facebook.com/signUpPage.php</a></p>
      ';
   }


   function getMarkupForErrorMessageIfValueIsEmpty( $value, $errorMessage )
   {

      if ( $value === '' ) {
         return '
               <span class="errorMessageInEditForm">' . $errorMessage . '</span>
         ';
      }
      else {
         return '';
      }

   }


   function getMarkupForErrorMessageIfValueIsAnInvalidNameOfLanguage( $value, $errorMessage )
   {
      if ( $value != '' && doesNotConsistOfAlphabetsAndSpacesOnly( $value ) ) {
         return '
               <span class="errorMessageInEditForm">' . $errorMessage . '</span>
         ';
      }
      else {
         return '';
      }
   }


   function getMarkupForErrorMessageIfValueIsAnInvalidName( $value, $errorMessage )
   {

      if ( isNotValidUserName( $value ) ) {
         return '
               <span class="errorMessageInSignUpForm">' . $errorMessage . '</span>
         ';
      }
      else {
         return '';
      }

   }


   function getMarkupForErrorMessageIfValueIsAnInvalidEmailAndInvalidPhone( $value, $errorMessage )
   {

      if ( isNotValidEmailAddress( $value ) && isNotValidPhoneNumber( $value ) ) {
         return '
               <span class="errorMessageInSignUpForm">' . $errorMessage . '</span>
         ';
      }
      else {
         return '';
      }

   }


   function getMarkupForErrorMessageIfPasswordWasNotPreviouslyFilledByUser( $errorMessage )
   {
      if ( isset( $_GET['userPasswordOrConfirmationOfUserPasswordHaveNotBeenProvided'] ) ) {
         return '
               <span class="errorMessageInSignUpForm">' . $errorMessage . '</span>
         ';
      }
      else {
         return '';
      }
   }


   function getMarkupForErrorMessageIfValueIsInvalid( $value, $errorMessage )
   {

      if ( $value == INVALID ) {
         return '
               <span class="errorMessageInEditForm">' . $errorMessage . '</span>';
      }
      else {
         return '';
      }

   }


   function getMarkupForTheOpeningTagOfFormElement( $method = 'POST', $action = NULL )
   {
      return '
         <form method="' . $method . '" action="' . ( $action == NULL ? $_SERVER['PHP_SELF'] : $action ) . '">';
   }


   function getMarkupForTheOpeningTagOfLabelElementInEditForms()
   {
      return '
            <label class="fieldInEditForm">';
   }


   function getMarkupForTheClosingTagOfLabelElementInEditForms()
   {
      return '
            </label>';
   }


   function getMarkupForSaveButtonAndCancelButton()
   {
      return '
            <input type="submit" name="saveButton" value="Save" class="buttonInEditForm"/>
            <input type="submit" name="cancelButton" value="Cancel" class="buttonInEditForm" />';
   }
?>