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
