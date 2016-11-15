<?php
   include_once 'includeFiles/functionsForRetrievingDataFromDatabase.php';
   include_once 'includeFiles/functionsForFormattingProfileDetails.php';
   include_once 'includeFiles/functionsForStoringDataIntoSESSION.php';
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
         </nav> <!-- end nav.importantLinks -->

         <!-- log out button -->
         <form method="POST" action="' . $_SERVER['PHP_SELF'] . '">
            <input type="submit" value="Log Out" name="logOutButton" class="logOutButton" />
         </form>
      </header> <!-- end header.loggedInHeader -->

      <pre class="spaceBelowLoggedInHeader">
      </pre>
      ';
   }


   function getMarkupForIfeFacebookLogo()
   {
      return '
         <a href="index.php"><h1 class="homepageLogo">ife_facebook</h1></a>
      ';
   }


   function getMarkupForShortDescriptionOfIfeFacebook()
   {
      return '
         <div class="shortDescription" >
            <img src="images/connectWithPeople.jpg" width="200px" height="200px"
               class="shortDescriptionImage" alt="connect with people that matter to you"/>

            <h2 class="shortDescriptionText">
               ife_facebook is an online community where you can connect 
               with those that matter to you
            </h2>
         </div>  <!-- end div.shortDescription -->
      ';
   }


   function getMarkupForSignUpForm()
   {
      $defaultFirstName = ( isset( $_GET['firstName'] ) ? $_GET['firstName'] : NULL );
      $defaultSurname = ( isset( $_GET['surname'] ) ? $_GET['surname'] : NULL );
      $defaultUserName = ( isset( $_GET['userName'] ) ? $_GET['userName'] : NULL );
      $defaultConfirmationOfUserName = 
         ( isset( $_GET['confirmationOfUserName'] ) ? $_GET['confirmationOfUserName'] : NULL );

      $signUpForm = '
         <div class="signUpFormContainer" >
            <h2>Sign Up</h2>
            <p>It\'s free and always will be.</p>

            <form method="POST" action="processSignUpRequest.php">
               <input type="hidden" name="urlOfSourcePage" value="' . $_SERVER['PHP_SELF'] . '" />

               <div>
                  <input type="text" name="firstName" placeholder="First name" value="' . $defaultFirstName . '" class="smallInputFieldForSignUpForm" />
                  <input type="text" name="surname" placeholder="Surname" value="' . $defaultSurname . '" class="smallInputFieldForSignUpForm" />
               </div>
      ';

      if ( $defaultFirstName === '' ) {
         $signUpForm .= '
               <span class="errorMessageInSignUpForm">Please enter your first name;</span>
         ';
      }

      if ( $defaultSurname === '' ) {
         $signUpForm .= '
               <span class="errorMessageInSignUpForm">Please enter your surname</span>
         ';
      }

      if ( isset( $_GET['requiredAction'] ) && $_GET['requiredAction'] == 'showThatFirstNameIsInvalid' ) {
         $signUpForm .= '
               <span class="errorMessageInSignUpForm">Invalid first name</span>
         ';
      }

      if ( isset( $_GET['requiredAction'] ) && $_GET['requiredAction'] == 'showThatSurnameIsInvalid' ) {
         $signUpForm .= '
               <span class="errorMessageInSignUpForm">Invalid surname</span>
         ';
      }

      $signUpForm .= '
               <div>
                  <input type="text" name="userName" placeholder="Email address or phone number" value="' . $defaultUserName . '" class="inputFieldForSignUpForm" />
               </div>
      ';

      if ( $defaultUserName === '' ) {
         $signUpForm .= '
               <span class="errorMessageInSignUpForm">Please enter your email address or phone number</span>
         ';
      }

      $signUpForm .= '
               <div>
                  <input type="text" name="confirmationOfUserName" placeholder="Re-enter email address or phone number" value="' . $defaultConfirmationOfUserName . '" class="inputFieldForSignUpForm" />
               </div>
      ';

      if ( $defaultConfirmationOfUserName === '' ) {
         $signUpForm .= '
               <span class="errorMessageInSignUpForm">Please re-enter your email address or phone number</span>
         ';
      }

      if ( isset( $_GET['requiredAction'] ) && $_GET['requiredAction'] == 'showThatUserNameIsDifferentFromConfirmationOfUserName' ) {
         $signUpForm .= '
               <span class="errorMessageInSignUpForm">The email addresses (or phone numbers) you entered do not match</span>
         ';
      }

      if ( isset( $_GET['requiredAction'] ) && $_GET['requiredAction'] == 'showThatUserNameIsInvalid' ) {
         $signUpForm .= '
               <span class="errorMessageInSignUpForm">Invalid usernames</span>
         ';
      }

      if ( isset( $_GET['requiredAction'] ) && $_GET['requiredAction'] == 'showThatUserNameAlreadyExists' ) {
         $signUpForm .= '
               <span class="errorMessageInSignUpForm">
                  Another ife_facebook user already uses this email address or phone number.<br/>
                  Please, crosscheck it to make sure you are not mistyping it.
               </span>
         ';
      }

      $signUpForm .= '
               <div>
                  <input type="password" name="userPassword" placeholder="Password you will like to use for ife_facebook" class="inputFieldForSignUpForm" />
               </div>

               <div>
                  <input type="password" name="confirmationOfUserPassword" placeholder="Confirm password" class="inputFieldForSignUpForm" />
               </div>
      ';

      if ( isset( $_GET['userPasswordOrConfirmationOfUserPasswordHaveNotBeenProvided'] ) ) {
         $signUpForm .= '
               <span class="errorMessageInSignUpForm">Please enter your preferred password as well as its confirmation</span>
         ';
      }

      if ( isset( $_GET['requiredAction'] ) && $_GET['requiredAction'] == 'showThatUserPasswordIsInvalid' ) {
         $signUpForm .= '
               <span class="errorMessageInSignUpForm">Invalid passwords</span>
         ';
      }

      if ( isset( $_GET['requiredAction'] ) && $_GET['requiredAction'] == 'showThatUserPasswordIsDifferentFromConfirmationOfUserPassword' ) {
         $signUpForm .= '
               <span class="errorMessageInSignUpForm">The passwords you entered do not match</span>
         ';
      }

      $signUpForm .='
               <div>
                  <input type="submit" name="signUpButton" value="Sign Up" class="signUpButton">
               </div>
            </form>
         </div> <!-- end div.signUpFormContainer -->
      ';

      return $signUpForm;
   }


   function getMarkupToCongratulateUserForSuccessfullySigningUp()
   {
      return '
      <h1>Congratulations! You\'ve successfully signed up with ife_facebook.</h1>

      <div>
         <p>Your username is: ' . $_POST['userName'] . '</p>
         <p>Your password is: ' . $_POST['userPassword'] . '</p>
      </div>

      <p>Keep these details safe. You will always need them whenever you want to log in to ife_facebook.</p>
      <p>You can log in now by clicking on the link below:</p>
      <p><a href="index.php">Log in to ife_facebook</a></p>
      ';
   }


   function getMarkupToDisplayLinkToSignUpPage()
   {
      return '
         <div class="linkToSignUpPage">
            <p>Don\'t have an ife_facebook account?</p>
            <p>Just click on the link below to sign up for free.</p>

            <a href="signUpPage.php" class="signUpButton">Sign Up</a>
         </div>
      ';
   }


   function getMarkupForLoginFormWithoutDefaultValues()
   {
      return '
         <h2 class="loginMessage">Log In</h2>

         <form method="POST" action="processLoginRequest.php" class="loginForm">
            ' . getMarkupToKeepTrackOfTheSourcePage() . '

            <label class="loginFormEntry">
               <span class="descriptionInLoginForm">Email or Phone</span>
               <input type="text" name="userName" class="inputFieldForLoginForm" />
            </label>

            <label class="loginFormEntry">
               <span class="descriptionInLoginForm">Password</span>
               <input type="password" name="userPassword" class="inputFieldForLoginForm" />
            </label>

            <label class="loginFormEntry">
               <input type="submit" value="Log In" class="loginButton" />
            </label>
         </form> <!-- end login form -->
      ';
   }


   function getMarkupForLoginFormWithDefaultValues( $defaultValueOfUserName, $defaultValueOfUserPassword )
   {
      return '
         <form method="POST" action="' . $_SERVER['PHP_SELF'] . '" >
            ' . getMarkupToKeepTrackOfTheSourcePage() . '

            <label class="fieldInEditForm">
               Email or Phone: 
               <input type="text" name="userName" value="' . $defaultValueOfUserName . '" />
            </label>

            <label class="fieldInEditForm">
               Password: 
               <input type="password" name="userPassword" value="' . $defaultValueOfUserPassword . '" />
            </label>

            <label class="fieldInEditForm">
               <input type="submit" value="Login" class="buttonInEditForm" />
            </label>
         </form>

         <p><a href="forgotPassword.php">Forgot Password? Click here</a></p>';
   }


   function getMarkupToKeepTrackOfTheSourcePage()
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


   function getMarkupToTellTheUserToLogIn( $urlOfCurrentPage )
   {
      return '
      <div>
         <h1>ife_facebook</h1>
         <p>You must login to continue</p>

         <form method="POST" action="index.php">
            <input type="hidden" name="urlOfSourcePage" value="'  .  $urlOfCurrentPage  .  '" />
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


   function getMarkupToListStatusUpdatesFromDatabase( $offset, $numberOfRows )
   {
      $idOfStatusUpdates = retrieveFromDatabaseAndReturnInArrayIdOfStatusUpdates( $offset, $numberOfRows );

      if ( doesNotExistInDatabase( $idOfStatusUpdates ) ) {
         $list = '
         <p>Sorry, No relevant status update exists.</p>
         ';
      }
      else {
         $list = '';

         for ( $index = 0; $index < sizeof( $idOfStatusUpdates ); $index++ ) {
            $list .= getMarkupToDisplayStatusUpdateInDefaultFormat( $idOfStatusUpdates[$index] );
         }

      }

      return $list;
   }


   function getMarkupToListStatusUpdatesFromSESSION()
   {
      $list = '';

      for ( $index = 0; $index < $_SESSION['totalNumberOfStatusUpdatesCurrentlyListed']; $index++ ) {
         $list .= 
            getMarkupToDisplayStatusUpdateInDefaultFormat( $_SESSION['idOfRelevantStatusUpdate' . $index] );
      }

      return $list;
   }


   function getMarkupToListStatusUpdatesFromSESSIONShowingCommentsOnTheRequiredStatusUpdate()
   {
      $list = '';

      for ( $index = 0; $index < $_SESSION['totalNumberOfStatusUpdatesCurrentlyListed']; $index++ ) {

         if ( $_SESSION['idOfRelevantStatusUpdate' . $index] == $_GET['idOfRequiredStatusUpdate'] ) {
            storeIntoSESSIONInformationAboutComments( 
               $_SESSION['idOfRelevantStatusUpdate' . $index], $_GET['offset'], $_GET['numberOfRows'] );
            $list .= 
               getMarkupToDisplayStatusUpdateShowingComments( $_SESSION['idOfRelevantStatusUpdate' . $index] );
         }
         else {
            $list .= 
               getMarkupToDisplayStatusUpdateInDefaultFormat( $_SESSION['idOfRelevantStatusUpdate' . $index] );
         }

      }

      return $list;
   }


   function getMarkupToListStatusUpdatesFromSESSIONShowingNamesOfLikersOfTheRequiredStatusUpdate()
   {
      $list = '';

      for ( $index = 0; $index < $_SESSION['totalNumberOfStatusUpdatesCurrentlyListed']; $index++ ) {

         if ( $_SESSION['idOfRelevantStatusUpdate' . $index] == $_GET['idOfRequiredStatusUpdate'] ) {
            storeIntoSESSIONInformationAboutNamesOfLikers( 
                  $_SESSION['idOfRelevantStatusUpdate' . $index], $_GET['offset'], $_GET['numberOfRows'] );
            $list .= 
               getMarkupToDisplayStatusUpdateShowingNamesOfLikers( $_SESSION['idOfRelevantStatusUpdate' . $index] );
         }
         else {
            $list .= 
               getMarkupToDisplayStatusUpdateInDefaultFormat( $_SESSION['idOfRelevantStatusUpdate' . $index] );
         }

      }

      return $list;
   }


   function getMarkupToDisplayStatusUpdateInDefaultFormat( $idOfStatusUpdate )
   {
      $detailsOfStatusUpdate = retrieveFromDatabaseDetailsOfStatusUpdate( $idOfStatusUpdate );

      if ( doesNotExistInDatabase( $detailsOfStatusUpdate ) ) {
         return '
         <section class="statusUpdate">This status update does not exist</section>';
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
               getMarkupForFormForPostingCommentToStatusUpdate( $detailsOfStatusUpdate['status_update_id'] ) . '
            </footer>
         </section> <!-- end section.statusUpdate -->
         ';
      }

   }


   function getMarkupToDisplayStatusUpdateShowingComments( $idOfStatusUpdate )
   {
      $detailsOfStatusUpdate = retrieveFromDatabaseDetailsOfStatusUpdate( $idOfStatusUpdate );

      if ( doesNotExistInDatabase( $detailsOfStatusUpdate ) ) {
         return '
         <section class="statusUpdate">Ttatus update does not exist</section>';
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
                  getMarkupToListComments( $detailsOfStatusUpdate['status_update_id'] ) .  
                  getMarkupToDisplayLinkForViewingOlderComments( $detailsOfStatusUpdate['status_update_id'] ) .
                  getMarkupToDisplayLinkForViewingNewerComments( $detailsOfStatusUpdate['status_update_id'] ) . '
               </div>
               ' . 
               getMarkupForFormForPostingCommentToStatusUpdate( $detailsOfStatusUpdate['status_update_id'] ) . '
            </footer>
         </section>
         ';
      }

   }


   function getMarkupToDisplayStatusUpdateShowingNamesOfLikers( $idOfStatusUpdate )
   {
      $detailsOfStatusUpdate = retrieveFromDatabaseDetailsOfStatusUpdate( $idOfStatusUpdate );

      if ( doesNotExistInDatabase( $detailsOfStatusUpdate ) ) {
         return '
         <section class="statusUpdate">This status update does not exist</section>';
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
                  getMarkupToListNamesOfLikers( $detailsOfStatusUpdate['status_update_id'] ) . 
                  getMarkupToDisplayLinkForViewingPreviousNamesOfLikers( $detailsOfStatusUpdate['status_update_id'] ) . 
                  getMarkupToDisplayLinkForViewingMoreNamesOfLikers( $detailsOfStatusUpdate['status_update_id'] ) . '
               </div>

               <div class="infoAboutComments">' .
                  getMarkupToDisplayLinkForViewingComments( $detailsOfStatusUpdate['status_update_id'] ) . '
               </div>
               ' . 
               getMarkupForFormForPostingCommentToStatusUpdate( $detailsOfStatusUpdate['status_update_id'] ) . '
            </footer>
         </section> <!-- end section.statusUpdate -->
         ';
      }

   }


   function getMarkupToDisplayHeaderAndBodyOfStatusUpdate( $detailsOfStatusUpdate )
   {
      $namesOfPoster = 
         retrieveFromDatabaseFirstNameLastNameAndNickName( $detailsOfStatusUpdate['id_of_poster'] );

      if ( doesNotExistInDatabase( $namesOfPoster ) ) {
         return '
            <header class="statusUpdateHeader">There is something wrong with this status update.</header>';
      }

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


   function userLikesStatusUpdate( $idOfUser, $idOfStatusUpdate )
   {
      $entryIndicatingLike = retrieveFromDatabaseEntryThatIndicatesThatUserLikesStatusUpdate( 
         $idOfUser, $idOfStatusUpdate );

      return existsInDatabase( $entryIndicatingLike );
   }


   function getMarkupToDisplayLinkForViewingNamesOfLikers( $numberOfLikes, $idOfStatusUpdate )
   {
      $markup = '
                  <a href="index.php?requiredAction=viewNamesOfLikers&idOfRequiredStatusUpdate=' . $idOfStatusUpdate . '&offset=0&numberOfRows=' . DEFAULT_NUMBER_OF_ROWS_FOR_LIKES . '#' . $idOfStatusUpdate . '" class="linkWithinStatusUpdate">';

      if ( $numberOfLikes == 0 ) {
         $markup = '';
      }
      else if ( userLikesStatusUpdate( $_SESSION['idOfLoggedInUser'], $idOfStatusUpdate ) ) {

         if ( $numberOfLikes == 1 ) {
            $markup .= 'You like this post.</a>';
         }
         else if ( $numberOfLikes == 2 ) {
            $markup .= 'You and one other person like this post.</a>';
         }
         else {
            $markup .= 'You and ' . ( $numberOfLikes - 1 ) . ' other people like this post.</a>';
         }

      }
      else {
         $idOfFriendThatLikesThisStatusUpdate = 
            getIdOfAnyFriendOfLoggedInUserThatLikesThisStatusUpdate( $idOfStatusUpdate );

         if ( $idOfFriendThatLikesThisStatusUpdate != NULL ) {
            $namesOfLiker = 
               retrieveFromDatabaseFirstNameLastNameAndNickName( $idOfFriendThatLikesThisStatusUpdate );

            if ( $numberOfLikes == 1 ) {
               $markup .= $namesOfLiker['first_name'] . ' ' . $namesOfLiker['last_name'] . ' likes this post.</a>';
            }
            else if ( $numberOfLikes == 2 ) {
               $markup .= $namesOfLiker['first_name'] . ' ' . $namesOfLiker['last_name'] . ' and one other person like this post.</a>';
            }
            else {
               $markup .= $namesOfLiker['first_name'] . ' ' . $namesOfLiker['last_name'] . ' and ' . ( $numberOfLikes - 1 ) . ' other people like this post.</a>';
            }

         }
         else {

            if ( $numberOfLikes == 1 ) {
               $markup .= 'one person likes this post.</a>';
            }
            else {
               $markup .= $numberOfLikes . ' people likes this post.</a>';
            }

         }

      }

      return $markup;
   }


   function getIdOfAnyFriendOfLoggedInUserThatLikesThisStatusUpdate( $idOfStatusUpdate )
   {

      for ( $index = 0; $index < $_SESSION['totalNumberOfFriends']; $index++ ) {

         if ( userLikesStatusUpdate( $_SESSION['idOfFriend' . $index], $idOfStatusUpdate ) ) {
            return $_SESSION['idOfFriend' . $index];
         }

      }

      return NULL;
   }


   function getMarkupToDisplayLinkForViewingComments( $idOfStatusUpdate )
   {
      $idOfComments = 
         retrieveFromDatabaseAndReturnInArrayIdOfComments( $idOfStatusUpdate, 0, 1 );

      if ( existsInDatabase( $idOfComments ) ) {
         return '
                  <a href="index.php?requiredAction=viewComments&idOfRequiredStatusUpdate=' . $idOfStatusUpdate . '&offset=0&numberOfRows=' . DEFAULT_NUMBER_OF_ROWS_FOR_COMMENTS . '#' . $idOfStatusUpdate .  '" class="linkWithinStatusUpdate">View comments on this post.</a>';
      }
      else {
         return '';
      }

   }


   function getMarkupForFormForPostingCommentToStatusUpdate( $idOfStatusUpdate )
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


   function getMarkupToListComments( $idOfStatusUpdate )
   {
      $idOfComments = retrieveFromDatabaseAndReturnInArrayIdOfComments( 
         $idOfStatusUpdate, $_GET['offset'], $_GET['numberOfRows'] );

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
                  <section class="comment">This comment does not exist.</section>';
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
      $nextComment = retrieveFromDatabaseAndReturnInArrayIdOfComments( 
         $idOfStatusUpdate, $_SESSION['totalNumberOfCommentsDisplayedSoFar'], 1 );

      if ( existsInDatabase( $nextComment ) ) {
         return '
                  <a href="index.php?requiredAction=viewComments&idOfRequiredStatusUpdate=' . $idOfStatusUpdate . '&offset=' . $_SESSION['totalNumberOfCommentsDisplayedSoFar'] . '&numberOfRows=' . DEFAULT_NUMBER_OF_ROWS_FOR_COMMENTS . '#' . $idOfStatusUpdate . '" class="linkWithinStatusUpdate" id="linkForViewingOlderComments">&lt&ltView Older Comments</a>';
      }
      else {
         return '';
      }

   }


   function getMarkupToDisplayLinkForViewingNewerComments( $idOfStatusUpdate )
   {

      if ( $_SESSION['totalNumberOfCommentsDisplayedSoFar'] > DEFAULT_NUMBER_OF_ROWS_FOR_COMMENTS ) {
         return '
                  <a href="index.php?requiredAction=viewComments&idOfRequiredStatusUpdate=' . $idOfStatusUpdate . '&offset=' . ( $_SESSION['totalNumberOfCommentsDisplayedSoFar'] - $_SESSION['totalNumberOfCommentsCurrentlyListed'] - DEFAULT_NUMBER_OF_ROWS_FOR_COMMENTS ) . '&numberOfRows=' . DEFAULT_NUMBER_OF_ROWS_FOR_COMMENTS . '#' . $idOfStatusUpdate .  '" class="linkWithinStatusUpdate" id="linkForViewingNewerComments">View Newer Comments&gt;&gt;</a>';
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


   function getMarkupToListNamesOfLikers( $idOfStatusUpdate )
   {
      $idOfLikers = retrieveFromDatabaseAndReturnInArrayIdOfLikers( $idOfStatusUpdate, $_GET['offset'], $_GET['numberOfRows'] );

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


   function getMarkupToDisplayNameOfLiker( $idOfLiker ) {
      $nameOfLiker = retrieveFromDatabaseFirstNameLastNameAndNickName( $idOfLiker );

      if ( doesNotExistInDatabase( $idOfLiker ) ) {
      return '
                     <li class="nameOfLiker">This name of liker does not exist.</li>';
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
                  <a href="index.php?requiredAction=viewNamesOfLikers&idOfRequiredStatusUpdate=' . $idOfStatusUpdate . '&offset=' . ( $_SESSION['totalNumberOfLikersDisplayedSoFar'] - $_SESSION['totalNumberOfLikersCurrentlyListed'] - DEFAULT_NUMBER_OF_ROWS_FOR_LIKES ) . '&numberOfRows=' . DEFAULT_NUMBER_OF_ROWS_FOR_LIKES . '#' . $idOfStatusUpdate . '" class="linkWithinStatusUpdate" id="linkForViewingPreviousNamesOfLikers">&lt;&lt;View previous</a>';
      }
      else {
         return '';
      }

   }


   function getMarkupToDisplayLinkForViewingMoreNamesOfLikers( $idOfStatusUpdate )
   {
      $idOfNextLiker = retrieveFromDatabaseAndReturnInArrayIdOfLikers( 
        $idOfStatusUpdate, $_SESSION['totalNumberOfLikersDisplayedSoFar'], 1 );

      if ( existsInDatabase( $idOfNextLiker ) ) {
         return '
                  <a href="index.php?requiredAction=viewNamesOfLikers&idOfRequiredStatusUpdate=' . $idOfStatusUpdate . '&offset=' . $_SESSION['totalNumberOfLikersDisplayedSoFar'] . '&numberOfRows=' . DEFAULT_NUMBER_OF_ROWS_FOR_LIKES . '" class="linkWithinStatusUpdate" id="linkForViewingMoreNamesOfLikers">View more&gt;&gt;</a>';
      }
      else {
         return '';
      }

   }


   function getMarkupToDisplayLinkForViewingMoreStatusUpdates()
   {
      $nextRelevantStatusUpdate = retrieveFromDatabaseAndReturnInArrayIdOfStatusUpdates(
         $_SESSION['totalNumberOfStatusUpdatesDisplayedSoFar'], 1 );

      if ( existsInDatabase( $nextRelevantStatusUpdate ) ) {
         return '
         <a href="index.php?requiredAction=viewMoreStatusUpdates&offset=' . $_SESSION['totalNumberOfStatusUpdatesDisplayedSoFar'] . '&numberOfRows=' . DEFAULT_NUMBER_OF_ROWS_FOR_STATUS_UPDATES . '">View more posts</a>
         ';
      }
      else {
         return '';
      }

   }


   function getMarkupForTopOfProfilePage( $urlOfCurrentProfilePage )
   {
      return '
         <div class="topOfProfilePage">'  .
            getMarkupToDisplayCoverPhoto()   .
            getMarkupToDisplayUserNames()  .
            getMarkupToDisplayOtherImportantLinks( $urlOfCurrentProfilePage )   . '
         </div>  <!-- end div.topOfProfilePage -->
      ';
   }


   function getMarkupToDisplayCoverPhoto()
   {
      return '
            <img src="images/coverPhoto.jpg" height="260px" width="100%" name="coverPhoto" class="coverPhoto"/>
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


   function getMarkupToDisplayOtherImportantLinks( $urlOfCurrentPage )
   {
      return '
            <nav class="otherImportantLinks">
               <ul>
                  <li><a href="myProfile.php" class="otherImportantLink" ' . ( $urlOfCurrentPage == 'myProfile.php' ? 'id="currentPage"' : '' ) . '>Timeline</a></li>
                  <li><a href="aboutMe.php" class="otherImportantLink" ' . ( $urlOfCurrentPage == 'aboutMe.php' ? 'id="currentPage"' : '' ) . '>About</a></li>
                  <li><a href="myFriends.php" class="otherImportantLink" ' . ( $urlOfCurrentPage == 'myFriends.php' ? 'id="currentPage"' : '' ) . '>Friends&nbsp;<span class="numberOfFriends">' . $_SESSION['totalNumberOfFriends'] . '</span></a></li>
                  <li><a class="otherImportantLink"></a></li>
               </ul>
            </nav>
      ';
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


   function getMarkupForFormForEditingBirthdayDetails( $defaultDayOfBirth, 
      $defaultMonthOfBirth, $defaultYearOfBirth )
   {
      $form = '
         <form method="POST" action="' . $_SERVER['PHP_SELF'] . '">
            <label class="fieldInEditForm">
               Month of birth:
               <select name="monthOfBirth">
                  <option value="' . INVALID . '">----</option>';

      for ( $month = 1; $month <= 12; $month++ ) {

         if ( $month == $defaultMonthOfBirth ) {
            $form .= '
                  <option value="' . $month . '" selected>' . convertToNameOfMonth( $month ) . '</option>';
         }
         else {
            $form .= '
                  <option value="' . $month . '">' . convertToNameOfMonth( $month ) . '</option>';
         }

      }

      $form .= '
               </select>';

      if ( $defaultMonthOfBirth == INVALID ) {
         $form .= '
               <span class="errorMessageInEditForm">Invalid&nbsp;month</span>';
      }

      $form .= '
            </label>

            <label class="fieldInEditForm">
               Day of birth:
               <select name="dayOfBirth">
                  <option value="' . INVALID . '">----</option>';

      for ( $day = 1; $day <= 31; $day++ ) {

         if ( $day == $defaultDayOfBirth ) {
            $form .= '
                  <option value="' . $day . '" selected>' . $day . '</option>';
         }
         else {
            $form .= '
                  <option value="' . $day . '">' . $day . '</option>';
         }

      }

      $form .= '
               </select>';

      if ( $defaultDayOfBirth == INVALID ) {
         $form .= '
               <span class="errorMessageInEditForm">Invalid&nbsp;day</span>';
      }


      $form .= '
            </label>

            <label class="fieldInEditForm">
               Year of birth:
               <select name="yearOfBirth">
                  <option value="' . INVALID . '">----</option>';

      for ( $year = EARLIEST_YEAR; $year <= CURRENT_YEAR; $year++ ) {

         if ( $year == $defaultYearOfBirth ) {
            $form .= '
                  <option value="' . $year . '" selected>' . $year . '</option>';
         }
         else {
            $form .= '
                  <option value="' . $year . '">' . $year . '</option>';
         }

      }

      $form .= '
               </select>';

      if ( $defaultYearOfBirth == INVALID ) {
         $form .= '
               <span class="errorMessageInEditForm">Invalid&nbsp;year</span>';
      }

      $form .= '
            </label>

            <input type="submit" name="cancelButton" value="Cancel" class="buttonInEditForm" />
            <input type="submit" name="saveButton" value="Save" class="buttonInEditForm"/>
         </form>  <!-- end "form for editing birthday details" -->
      ';

      return $form;
   }


   function getMarkupForFormForEditingCityDetails( $defaultNameOfCity, $defaultNameOfCountry )
   {
      $form = '
         <form method="POST" action="' . $_SERVER["PHP_SELF"] . '">
            <label class="fieldInEditForm">
               Name of city:';

      if ( $defaultNameOfCity == INVALID ) {
         $form .= '
               <input type="text" name="nameOfCity" value="" />
               <span class="errorMessageInEditForm">Please specify the name of city</span>
         ';
      }
      else {
         $form .= '
               <input type="text" name="nameOfCity" value="' . $defaultNameOfCity . '" />
         ';
      }

      $form .= '
            </label>

            <label class="fieldInEditForm">
               Name of country:';

      if ( $defaultNameOfCountry == INVALID ) {
         $form .= '
               <input type="text" name="nameOfCountry" value="" />
               <span class="errorMessageInEditForm">Please specify the name of country</span>
         ';
      }
      else {
         $form .= '
               <input type="text" name="nameOfCountry" value="' . $defaultNameOfCountry . '" />
         ';
      }

      $form .= '
            </label>

            <input type="submit" name="cancelButton" value="Cancel" class="buttonInEditForm" />
            <input type="submit" name="saveButton" value="Save" class="buttonInEditForm" />
         </form> <!-- end "form for editing city details" -->
      ';

      return $form;
   }


   function getMarkupForFormForEditingGenderDetails( $defaultGenderDetails )
   {
      $defaultGenderDetails = strtolower( $defaultGenderDetails );

      $form = '
         <form method="POST" action="' . $_SERVER['PHP_SELF'] . '">
            <p>Please, select your gender:</p>
         ';

      if ( $defaultGenderDetails == 'male' ) {
         $form .= '
            <label class="fieldInEditForm"><input type="radio" name="genderDetails" value="male" checked/> Male</label>';
      }
      else {
         $form .= '
            <label class="fieldInEditForm"><input type="radio" name="genderDetails" value="male"/> Male</label>';
      }

      if ( $defaultGenderDetails == 'female' ) {
         $form .= '
            <label class="fieldInEditForm"><input type="radio" name="genderDetails" value="female" checked/> Female</label>';
      }
      else {
         $form .= '
            <label class="fieldInEditForm"><input type="radio" name="genderDetails" value="female"/> Female</label>';
      }

      if ( $defaultGenderDetails == INVALID ) {
         $form .= '
            <span class="errorMessageInEditForm">Please select a valid gender</span>
            <br/>
         ';
      }

      $form .= '
            <input type="submit" name="cancelButton" value="Cancel" class="buttonInEditForm"/>
            <input type="submit" name="saveButton" value="Save" class="buttonInEditForm"/>
         </form>
      ';

      return $form;
   }


   function getMarkupForFormForEditingLanguageDetails( $idOfDefaultLanguage, 
      $idOfLanguageToBeEdited, $defaultValueOfTextBox = NULL )
   {
      $form = '
            <div class="languageName">
               <form method="POST" action="' . $_SERVER['PHP_SELF'] . '" >
                  <input type="hidden" name="idOfLanguageToBeEdited" value="' . $idOfLanguageToBeEdited . '" />

                  <label class="fieldInEditForm">
                     <select name="idOfSelectedLanguage">
                        <option value="' . INVALID . '">----</option>';

      if ( $idOfDefaultLanguage == NONE_OF_THE_ABOVE || $idOfDefaultLanguage == NAME_NOT_SPECIFIED ) {
         $form .= '
                        <option value="' . NONE_OF_THE_ABOVE . '" selected>My language is not listed</option>';
      }
      else {
         $form .= '
                        <option value="' . NONE_OF_THE_ABOVE . '">My language is not listed</option>';
      }

      for ( $index = 0; $index < $_SESSION['totalNumberOfLanguages']; $index++ ) {

         if ( $_SESSION['idOfLanguage' . $index] == $idOfDefaultLanguage ) {
            $form .= '
                        <option value="' . $_SESSION['idOfLanguage' . $index] . '" selected>' . $_SESSION['nameOfLanguage' . $index] . '</option>';
         }
         else {
            $form .= '
                        <option value="' . $_SESSION['idOfLanguage' . $index] . '">' . $_SESSION['nameOfLanguage' . $index] . '</option>';

         }

      }

      $form .= '
                     </select>';

      if ( $idOfDefaultLanguage == INVALID ) {
         $form .= '
                     <br />
                     <span class="errorMessageInEditForm">Please, select a valid language</span>';
      }

      $form .= '
                  </label>
      ';

      if ( $idOfDefaultLanguage == NONE_OF_THE_ABOVE ) {
         $form .= '
                  <label class="fieldInEditForm">
                     What is the name of your language? 
                     <input type="text" name="nameOfNewLanguage" value="' . $defaultValueOfTextBox . '"/>
                  </label>
         ';
      }

      if ( $idOfDefaultLanguage == NAME_NOT_SPECIFIED ) {
         $form .= '
                  <label class="fieldInEditForm">
                     What is the name of your language? 
                     <input type="text" name="nameOfNewLanguage" value=""/>
                     <br />
                     <span class="errorMessageInEditForm">Please, specify the name of your language.</span>
                  </label>
         ';
      }

      $form .= '
                  <input type="submit" name="saveButton" value="OK" class="buttonInEditForm"/>
                  <input type="submit" name="cancelButton" value="Cancel" class="buttonInEditForm"/>
               </form>
            </div>';

      return $form;
   }


   function getMarkupToShowNameOfLanguageWithEditAndDeleteButton( $idOfLanguage )
   {

      for ( $index = 0; $index < $_SESSION['totalNumberOfLanguages'] && 
         $_SESSION['idOfLanguage' . $index] != $idOfLanguage; $index++ )
         ;

      if ( $index < $_SESSION['totalNumberOfLanguages'] ) {
         return '
            <div class="languageName">
               <span>' . capitalizeWordsThatShouldBeCapitalized( $_SESSION['nameOfLanguage' . $index] ) . '</span>
               <form method="POST" action="' . $_SERVER['PHP_SELF'] . '">
                  <input type="hidden" name="idOfLanguageToBeEdited" value="' . $idOfLanguage . '" />

                  <input type="submit" name="editLanguageButton" value="Edit" class="buttonInEditForm" />
                  <input type="submit" name="deleteLanguageButton" value="Delete" class="buttonInEditForm" />
               </form>
            </div>';
      }
      else {
         return '';
      }

   }


   function getMarkupForFormForEditingFavouriteQuoteDetails( $defaultFavouriteQuotes )
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


   function getMarkupForFormForEditingAboutMeDetails( $defaultAboutMeDetails )
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
?>