<?php
   include_once 'includeFiles/miscellaneousFunctions.php';

   /*
      function 'formatAboutMeDetails' is redundant. It just exists for consistency sake
   */
   function formatAboutMeDetails( $row )
   {
      return $row['about_me'];
   }


   function formatBirthdayDetails( $row )
   {
      $nameOfMonthOfBirth = convertToNameOfMonth( $row['month_of_birth'] );

      return $nameOfMonthOfBirth . ' ' . $row['day_of_birth'] . ', ' . $row['year_of_birth'];
   }


   function formatCityDetails( $row )
   {
      $capitalizedNameOfCity = capitalizeWordsThatShouldBeCapitalized( $row['name_of_city'] );
      $capitalizedNameOfCountry = capitalizeWordsThatShouldBeCapitalized( $row['name_of_country'] );

      return  $capitalizedNameOfCity . ', ' . $capitalizedNameOfCountry;
   }


   function formatFavouriteQuoteDetails( $row )
   {
      return '<q>' . $row['favourite_quotes'] . '</q>';
   }


   function formatGenderDetails( $row )
   {
      return capitalizeWordsThatShouldBeCapitalized( $row['name_of_gender'] );
   }


   function formatLanguageDetails( $arrayContainingNamesOfLanguages )
   {
      $INDEX_OF_FIRST_LANGUAGE = 0;

      $formattedLanguageDetails = $arrayContainingNamesOfLanguages[$INDEX_OF_FIRST_LANGUAGE];

      if ( sizeof( $arrayContainingNamesOfLanguages ) > 1 ) {
         $INDEX_OF_LAST_LANGUAGE = sizeof( $arrayContainingNamesOfLanguages ) - 1;

         for ( $index = 1; $index < $INDEX_OF_LAST_LANGUAGE; $index++ ) {
            $formattedLanguageDetails .= ', ' . $arrayContainingNamesOfLanguages[$index];
         }

         $formattedLanguageDetails .= ' and ' . $arrayContainingNamesOfLanguages[$INDEX_OF_LAST_LANGUAGE];
      }

      return capitalizeWordsThatShouldBeCapitalized( $formattedLanguageDetails );
   }


   function formatTimeShowingAmOrPm( $hour, $minute )
   {

      if ( $hour < 12 ) {
         return $hour . ':' . $minute . 'am';
      }
      else if ( $hour == 12 ) {

         if ( $minute == 0 ) {
            return $hour . ':' . $minute . 'noon';
         }
         else {
            return $hour . ':' . $minute . 'pm';
         }

      }
      else {
         return ( $hour - 12 ) . ':' . $minute . 'pm';
      }

   }
?>