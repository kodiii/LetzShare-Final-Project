# LetzShare-Final-Project

LetzShare is a website for users to upload and share photographs of Luxembourg. LetzShare is our final project on Fit4Coding Bootcamp at NumericALL.
About LetzShare
LetzShare is a website for users to upload and share photographs of Luxembourg. These can be rated
and commented upon by other users and the site will keep track of the most liked photos.
Luxembourg is a small country nestling between France, Germany and Belgium and is not so well
known outside the region.
By creating a platform to showcase attractive images of the Grand Duchy we hope to play a role in
elevating its profile. Rich in history with many monuments and historic buildings this small country is
also favoured by many attractive natural landscapes and beauty spots.
As well as this Luxembourg has its own unique culture and hugely diverse and multicultural
population with a vibrant culture and nightlife reflecting this.
Letzshare will be the platform which allows users to share images of all these aspects of
Luxembourg.

Features
The core features of LetzShare are for registered users to be able to upload photos with some
information about them and for other users to be able to “like” and comment about them.
Additional features which will be included if time allows and they prove to be feasible are:
The site can have a direct link with Facebook and Instagram so the uploaded photos can be
simultaneously shared there.
When photos are uploaded from a mobile phone the geodata is automatically included, possibly via
a downloadable app.
Users can also sign up / login with their Facebook credentials
There is a service whereby a user can contact another user, for example if they want to discuss a
photo the second user has posted.

Conformance with Project Recommendations

1. The project must use notions of BackOffice and FrontOffice
   The site will have different user permissions – unregistered users can only browse the site
   content. Registered users will be able to upload, like and comment on photos as well as edit their
   own uploads and their own profile information.
2. It must include use of a database

The database will be set up using Laravel migrations the principal tables being the photos and
users tables, with separate tables to manage comments and likes.

3. The Front Office part must be integrated using techniques of Responsive Web Design
   We intend to use the functionality of Bootstrap and equivalent libraries to make the site
   responsive.
4. The PHP code must be organized according to MVC architecture using the WebForce3
   educational framework
   We will use the Laravel PHP framework which has this built-in
5. The PHP code must be object oriented
   We will use the Laravel PHP framework which has this built-in
6. The JavaScript code must use at least one external API, or, alternatively, integrate AJAX
   features
   As a minimum we will integrate AJAX calls in the user forms. Assuming one or more of the bonus
   features are completed we will use APIs from one or more of Facebook, Google Maps and
   Instagram.
7. The HTML / CSS code must be valid and accessible
   We will use W3S validation for the code and ensure accessibility by rendering image alt text by
   PHP from info fields entered by the user.
8. The project must put into practice some notions related to security, such as password
   hashing or measures to avoid &quot;SQL injection&quot;-type attacks
   We will use the inbuilt security features of Laravel for prevention of SQL injection and password
   hashing.

Team Members
Stuart Walker
Ricardo Ribiero
Michel dos Santos
Liliana Grigor

Update Notes

13-Aug 13:00
SQL info migrated using plugin - note in "users" table created_at and updated_at were automatically converted to timestamp
email_verified at was not changed and remains as VARCHAR (was timestamp in default "users" table)

14-Aug 15:00
Send Email to reset password
1 - In the terminal:
composer require guzzlehttp/guzzle
2 - Put " " in the MAIL_USERNAME and MAIL_PASSWORD

.
