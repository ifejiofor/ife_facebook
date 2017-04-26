/* 
 * This SQL script creates the 'ife_facebook_database', as well as the tables
 * within the it
 *
 * 'ife_facebook_database' will be used by 'ife_facebook.com', a social 
 * networking site which I designed to mimick the basic functionalities 
 * of Mark Zukerberg's 'facebook.com'.
 *
 * For more information see the comment in the file 
 * 'C:/xampp/htdocs/ife_facebook.com/index.php'
 *
 */



DROP DATABASE IF EXISTS ife_facebook_database;
CREATE DATABASE ife_facebook_database;
USE ife_facebook_database;


/* 
   user_information table will be used to store information about
   every user of 'ife_facebook.com' 
*/
CREATE TABLE user_information (
   user_id INT PRIMARY KEY AUTO_INCREMENT,

   first_name VARCHAR( 50 ),
   last_name VARCHAR( 50 ),
   nick_name VARCHAR( 50 ),

   phone_number VARCHAR( 14 ),
   email_address VARCHAR( 50 ),
   login_password VARCHAR( 50 ),

   date_of_birth DATE,
   id_of_current_city INT,  /* points to a city_id in the cities TABLE */
   id_of_hometown INT,      /* points to a city_id in the cities TABLE */
   id_of_gender INT,        /* points to a gender_id in the genders TABLE */
   favourite_quotes TEXT,
   about_me TEXT
);


/* cities table will be used to store information about cities and towns */
CREATE TABLE cities (
   city_id INT PRIMARY KEY AUTO_INCREMENT,
   name_of_city VARCHAR( 50 ),
   name_of_country VARCHAR( 50 )
);


/* genders table will be used to store information about genders */
CREATE TABLE genders (
   gender_id INT PRIMARY KEY AUTO_INCREMENT,
   name_of_gender VARCHAR( 6 )
);


/* languages table will be used to store information about languages */
CREATE TABLE languages (
   language_id INT PRIMARY KEY AUTO_INCREMENT,
   name_of_language VARCHAR( 50 )
);


/*
   user_and_language table will be used to map every user with 
   the language they speak
*/
CREATE TABLE user_and_language (
   id_of_user INT,
   id_of_language INT
);


/*
   friend_relationships table will be used to map every user 
   with their friends
*/
CREATE TABLE friend_relationships (
   id_of_first_user INT,
   id_of_second_user INT
);


/* friend_requests table will be used to keep track of friend requests */
CREATE TABLE friend_requests (
   id_of_sender INT,
   id_of_reciever INT
);


/*
   status_updates table will be used to store information about 
   every status update
*/
CREATE TABLE status_updates (
   status_update_id INT PRIMARY KEY AUTO_INCREMENT,
   status_update_text TEXT,
   id_of_poster INT,          /* points to the user_id of the user who posted the status update */
   time_of_posting DATETIME,
   number_of_likes INT
);


/*
   comments table will be used to store information about every 
   comment made every status update
*/
CREATE TABLE comments (
   comment_id INT PRIMARY KEY AUTO_INCREMENT,
   comment_text TEXT,
   id_of_commenter INT,        /* points to the user_id of the user who made the comment */
   id_of_status_update INT,    /* points to the status_update_id of the status update which the comment was made to */
   time_of_commenting DATETIME
);


/*
   likes table will be used to store information about every 'like' 
   to every status update
*/
CREATE TABLE likes (
   id_of_user INT,
   id_of_status_update INT
);


/*
   notifications table will be used to store all notifications meant for ife_facebook users
*/
CREATE TABLE notifications (
   notification_id INT PRIMARY KEY AUTO_INCREMENT,
   id_of_user_whom_notification_is_meant_for INT,
   notification_text TEXT,
   time_of_creating_notification DATETIME,
   notification_state ENUM( 'read', 'not_read' )
);



/* ************************************************************** */
/* Below, are SQL queries to insert sample data into the database */
/* ************************************************************** */


/* insert sample data into the 'user_information' table */
INSERT INTO user_information ( first_name, last_name, email_address, phone_number, login_password )
   VALUES ( "Ife", "Ejiofor", "ejioforife@yahoo.com", "+2348169297735", "ifeismypassword" ); /* user_id == 1 */

INSERT INTO user_information ( first_name, last_name, email_address, phone_number, login_password )
   VALUES ( "Emeka", "Maduike", "maduikekris@gmail.com", "+2348012345678", "emekaismypassword" ); /* user_id == 2 */

INSERT INTO user_information ( first_name, last_name, email_address, phone_number, login_password )
   VALUES ( "Izu", "Maduike", "maduikeizu@yahoo.com", "+2348069297735", "izuismypassword" ); /* user_id == 3 */

INSERT INTO user_information ( first_name, last_name, email_address, phone_number, login_password )
   VALUES ( "Sunshine", "Nonso", "sunshine.nonso@hotmail.com", "+2347069297735", "sunshineismypassword" ); /* user_id == 4 */

INSERT INTO user_information ( first_name, last_name, email_address, phone_number, login_password )
   VALUES ( "Ada", "Ada", "adaada12@yahoo.com", "+2347098765432", "adaismypassword" ); /* user_id == 5 */


/* insert sample data into the 'friend_relationships' table */
INSERT INTO friend_relationships ( id_of_first_user, id_of_second_user )
   VALUES ( 1, 2 );  /* make "Ife" and "Emeka" to be friends */

INSERT INTO friend_relationships ( id_of_first_user, id_of_second_user )
   VALUES ( 1, 3 ); /* make "Ife" and "Izu" to be friends */

INSERT INTO friend_relationships ( id_of_first_user, id_of_second_user )
   VALUES ( 1, 4 ); /* make "Ife" and "Sunshine" to be friends */

INSERT INTO friend_relationships ( id_of_first_user, id_of_second_user )
   VALUES ( 2, 3 ); /* make "Emeka" and "Izu" to be friends */

INSERT INTO friend_relationships ( id_of_first_user, id_of_second_user )
   VALUES ( 3, 4 ); /* make "Izu" and "Sunshine" to be friends */


/* insert sample data into 'cities' table */
INSERT INTO cities ( name_of_city, name_of_country )
   VALUES ( "nsukka", "nigeria" ); /* city_id == 1 */

INSERT INTO cities ( name_of_city, name_of_country )
   VALUES ( "lagos", "nigeria" ); /* city_id == 2 */


/* insert sample data into the 'languages' table */
INSERT INTO languages ( name_of_language )
   VALUES ( "igbo" ); /* language_id == 1 */

INSERT INTO languages ( name_of_language )
   VALUES ( "english" ); /* language_id == 2 */

INSERT INTO languages ( name_of_language )
   VALUES ( "french" ); /* language_id == 3 */


/* insert sample data into 'user_and_language' table */
INSERT INTO user_and_language( id_of_user, id_of_language )
   VALUES( 1, 2 ); /* "Ife" speaks "english" */

INSERT INTO user_and_language( id_of_user, id_of_language )
   VALUES( 1, 3 ); /* "Ife" speaks "french" */


/*
   insert sample data into the 'genders' table.

   NB:
   This particular initialization is very very important and 
   should never be deleted (even when the other initializations are deleted).
*/
INSERT INTO genders ( name_of_gender )
   VALUES ( 'male' ); /* gender_id == 1 */

INSERT INTO genders ( name_of_gender )
   VALUES ( 'female' ); /* gender_id == 2 */


/* insert sample data into 'status_updates' table */
INSERT INTO status_updates ( status_update_text, id_of_poster, time_of_posting, number_of_likes )
   VALUES ( 'Well well well. This is simply a sample status update. How do you see it?', 2, '2016-09-24 16:15', 1 ); /* sample status update by "Emeka"; status_update_id == 1 */

INSERT INTO status_updates ( status_update_text, id_of_poster, time_of_posting, number_of_likes )
   VALUES ( 'Lemme just post a sample status update.', 4, '2016-09-24 16:17', 0 ); /* sample status update by "Sunshine"; status_update_id == 2 */

INSERT INTO status_updates ( status_update_text, id_of_poster, time_of_posting, number_of_likes )
   VALUES ( 'Truly, persistence pays. Today, I am proud to say that I successfully completed the first version of ife_facebook. I am really grateful to God for providing me with knowledge, insight, strength, and very importantly a laptop. Without these, I would not have completed this project successfully.', 1, '2017-04-24 15:53', 3 ); /* sample status update by "Ife"; status_update_id == 3 */


/* insert sample data into 'comments' table */
INSERT INTO comments ( comment_text, id_of_commenter, id_of_status_update, time_of_commenting )
   VALUES ( 'I am happy for you bro. Thumbs up!!', 2, 3, '2016-09-24 16:24' ); /* sample comment by "Emeka" to the status update with id of 3; comment_id == 1 */

INSERT INTO comments ( comment_text, id_of_commenter, id_of_status_update, time_of_commenting )
   VALUES ( 'Wow! Ife you succeeded.', 3, 3, '2016-09-24 16:25' ); /* sample comment by "Izu" to the status update with id of 3; comment_id == 2 */

INSERT INTO comments ( comment_text, id_of_commenter, id_of_status_update, time_of_commenting )
   VALUES ( 'Cool', 4, 3, '2016-09-24 16:26' ); /* sample comment by "Sunshine" to the status update with id of 3; comment_id == 3 */

INSERT INTO comments ( comment_text, id_of_commenter, id_of_status_update, time_of_commenting )
   VALUES ( 'mehn ... guys na God oo...', 1, 3, '2016-09-24 16:26' ); /* sample comment by "Emeka" to the status update with id of 3; comment_id == 4 */

INSERT INTO comments ( comment_text, id_of_commenter, id_of_status_update, time_of_commenting )
   VALUES ( 'Mekus Mekus!', 3, 1, '2016-09-24 16:28' ); /* sample comment by "Izu" to the status update with id of 1; comment_id == 5 */


/* insert sample data into the 'likes' table */
INSERT INTO likes ( id_of_user, id_of_status_update )
   VALUES ( 3, 1 ); /* "Izu" likes the status update with id of 1 */

INSERT INTO likes ( id_of_user, id_of_status_update )
   VALUES ( 3, 3 ); /* "Izu" likes the status update with id of 3 */

INSERT INTO likes ( id_of_user, id_of_status_update )
   VALUES ( 2, 3 ); /* "Emeka" likes the status update with id of 3 */

INSERT INTO likes ( id_of_user, id_of_status_update )
   VALUES ( 5, 3 ); /* "Ada" likes the status update with id of 3 */