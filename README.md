# Secure-Music-Website

## Background
In this assignment you will create a web-based application for a product similar to Spotify named 24/7Music. The 24/7Music web application will allow:
- members and non-members to search for songs, artists, albums.
- members and non-members to view lists of songs, artists, albums.
- members and non-members to play short samples of selected songs.
- members to create playlists of their favourite songs.

This is a very simplified web application and leaves out aspects that would be required in a real music streaming web application [such as actually streaming the music!!]. Read the [Functional Requirements](#functional-requirements) section to determine what is specifically required for 24/7Music. The MySQL database that supports the functionality of 24/7Music is named 247Music. The 247Music database is described in [Database Description](#databse-description) of this document. You will need to design and create the PHP web pages for
this assignment. 

## Functional Requirements
The 24/7Music web application **must**
a) be coded using HTML 5, CSS, JavaScript, and PHP as necessary. Note: all files described below must be PHP files to
achieve the server-side functionality.
b) provide easy-to-use navigation for the user as described in the following page descriptions.
c) provide the following page content and functionality for each page as described.

### Index Page
**Page purpose/description**:

This file is the home page to your site. This page only requires:

1. A welcome message
2. A navigation bar with links to the other pages of 24/7Music *as appropriate* including a **Log Out** link (if the user is
logged in) or a **Log In** link (if the user is not logged in).
3. Member username (if the user is logged in)
4. Membership category (if the user is logged in)


### Search Page
**Page purpose/description**:

This page is a search page to find albums, artists, or songs. The search page can be used by both non-members and
members.

**Page Content**:

The page will have the following content:
1. Navigation to the other pages of 24/7Music *as appropriate* including a **Log Out** link (if the user is logged in) or a
**Log In** link (if the user is not logged in).
2. Member username (if the user is logged in)
3. Membership category (if the user is logged in)
4. An HTML form (the search form) which contains:
- A text box to enter the keyword(s) for the search (mandatory field).
- A submit button.
As indicated above the search text box is mandatory. That is, a search may be performed only if a search keyword has been entered.
5. A ‘search results’ section that lists songs, artists, albums that match the keyword(s) entered in the form.

**Page Functionality**:

The Search page will

1. Validate that a search keyword has been entered in the search form (using client-side JavaScript). Do not allow the form to submit unless a search keyword has been entered. Any characters may be entered.
2. Use **postback** for the search form,
3. Sanitise the submitted keyword(s) to avoid possible sql injection, then search the 247Music database for records that contain the keyword(s) entered in the search form. The search should check for matches with album names, artist names, and song titles; hint: the SQL “LIKE” operator might help in this query. The search may find zero, one, or many matches depending upon the search term(s) entered. The output from the search depends on the number of matches found:
  a. **One or more records found**: generate a summary list of any matching albums, artists, and songs underneath the search form. The user will be able to choose from this list the match they want to view more detail about (see point 4 below) by clicking on the match. The summary list should be **displayed in groups** of albums, artists, and songs showing:
     i. The name of the album, artist, or song that has matched with the search keyword(s).
     ii. For all songs that match, also list the Artist name.
     iii. For all albums that match, also list the Artist name.
     iv. A thumbnail image for the match.
   b. **Zero records found**: display an appropriate message underneath the search form instead of a list of results.
4. Enable the user to choose an album, artist, or song match for viewing/playing from the search results. To do this, the name of the song, name of the artist, or name of the album in the search results list is to be a hypertext link. When clicked, the **hypertext link** loads the **Play page** which displays more specific details for the chosen match. Details of the Play page is given below.


### Play Page:
**Page purpose/description**:

The purpose of this page is to display to the user the content of the **chosen** match. The content displayed will vary depending upon the type of match chosen by the user. The chosen match could be for an artist, album, playlist, or a song. The user may make the choice of match on the **Search** page, on the **Play** page, or on the **Playlist** page. The **Play** page can be used by both non-members and members.

**Page Content and Functionality**:

The page will:
1. Include navigation to the other pages of 24/7Music **as appropriate** including a **Log Out** link (if the user is logged in) or a **Log In** link (if the user is not logged in).
2. Display the member username (if the user is logged in)
3. Display the membership category (if the user is logged in), and
4. Display content depending on the type of chosen match as follows:
  a. If the chosen match is an **Artist**, display the name of the artist and the thumbnail image (if one is available). Then display a list of all albums by this artist. For each album, display the album name, the year the album was released and the thumbnail image (if one is available). Each album name should be a hypertext link that will open the **Play** page so that the **Play** page may then display the details of the chosen album (see point 4b).
  b. If the chosen match is an **Album**, display the album thumbnail image (if one is available), album title, artist name, and a list of all songs from the album. For each song from the album display the song title, and song length. Each song title should be a hypertext link that will open the **Play** page so that the **Play** page may then display the details of the chosen song (see point 4d).
  c. If the chosen match is a **Playlist**, display the playlist name and a list of all songs in the playlist. For each song in the playlist display the song title, artist name, and song length. Each song title should be a
hypertext link that will open the **Play** page so that the **Play** page may then display the details of the chosen song (see point 4d).
  d. If the chosen match is a **Song**, display the song title, album title, song length, a link to ‘add to playlist’ (only available to logged in users), and an iframe to play a sample of the song using the spotify track ID (see details below)

**Playing a sample of a chosen song**:
To be able to play a preview of the chosen song use the following code to embed the Spotify iframe within the page:

```
<iframe src="https://open.spotify.com/embed/track/##########"
 width="380" height="380" frameborder="0"
 allowtransparency="true" allow="encrypted-media">
</iframe>
```
where ########## represents the spotify_track value from the track table in the database.


### Playlist Page:
**Page purpose/description**:

Playlists are collections of songs. Playlists can only be created and accessed by logged in members. The page enables logged in members to create new playlists, add songs to their playlists, play songs from their playlists. Songs cannot be removed from playlists. Playlists cannot be deleted. Playlists belong to a specific member; logged in members cannot access any other member’s playlist(s). Non-members cannot access this page and hence cannot create or change playlists.


**Page Content and Functionality**:

The page will:
1. Include navigation to the other pages of 24/7Music **as appropriate** including a **Log Out** link,
2. Display the member username for the logged in member,
3. Display the membership category for the logged in member,
4. Include a postback form to enable the logged in member to create a **new** playlist. The playlist name will need to be sanitised and validated on the server-side before being inserted into the database. Playlist names may only contain alphanumeric characters and spaces
5. Include a postback form to enable the member to add a song to a chosen playlist,
6. Display a list of all playlist names (that belong to the logged in member). Each playlist name is to be a hypertext link that will open the **Play** page so that songs from the chosen playlist may be viewed as described in the **Play** page.


### Member Login Page:
**Page purpose/description**:

The purpose of this page is to provide a login facility for members/subscribers of 24/7Music. Some of the functionality described in previous pages is only available to users after they have logged in.

**Page Content and Functionality**:

The page will:
1. Include navigation to the other pages of 24/7Music **as appropriate**,
2. Include a postback login form which contains:
   - a text box to capture the **member username**.
   - a password box to capture the **member password**.
   - a submit/log in button.

  When the form is submitted by the user the page will need to **authenticate** the member credentials (**username and password**) as supplied by the member in the login form against the records in the **membership** table of the 247Music database.
  The page will allow or deny access to the subsequent pages of 24/7Music depending on the result of authentication as follows:
  a. **Successful login attempt**: Successful authentication should automatically redirect the member to the Search page.
  b. **Failed login attempt**: Unsuccessful authentication should automatically redirect to the login page so that the user may try to login again. An appropriate error message must be displayed to the user if the login attempt fails. The message display must be implemented using appropriate PHP server-side code; it is not to be a JavaScript alert (or any other browser side component). The message should be displayed in an appropriate location on the login page in a suitable colour.
3. A link to the Sign-Up page (the Sign-Up page is not implemented in this version of the web application).
4. The provision for displaying error messages as detailed below.

**Member Login Credentials**:

The passwords that are stored in the **membership** table of the 247Music database are encrypted using the sha256 algorithm (the passwords are not salted to decrease the complexity of implementation). A list of member usernames and (plain text decrypted) passwords can be found below. After a successful user login, you might wish to store relevant information in session variables for later access.


|username           |password      |surname    |firstname    |membership    |
|-------------------|--------------|-----------|-------------|--------------|
|alan@me.com        |giantjelly41  |Quay       |Alan         |Free          |
|paige@turner.com   |redmusk60     |Turner     |Paige        |Premium       |
|justin@hotmail.com |tinymusic50   |Case       |Justin       |Family        |
