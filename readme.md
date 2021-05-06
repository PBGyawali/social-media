

<p align="center"><img src="https://raw.githubusercontent.com/PBGyawali/social-media/main/static/images/logo/logo%20with%20words_4_02_01_21_4241.png" width="400"></p>

**Please go to the folder named "documentation" to read all the necessary documents and take a look at the 
documents required for you to edit in the website or run this website in your local server.

This projected in intended towards creating a social media. it is based on php as a backend server as uses object oriented method of programming to perform the operation. for the purpose of database it uses mysql as a server and uses mysqli driver and prepared statements to achieve the task without compromising security.**




# Programming feature
* use of prepared statements to prevent sql injection
* added measures to minimize XSS attacks
* based on object oriented programming
* influenced by MVC (model-view-controller) framework and tries to mimic the framework wherever possible
* It uses javascript and jquery to perform interactive action on the DOM.
* use of ajax to send data without loading pages
* steps takes to combine multiple pages into single pages wherever possible using jquery
* ability to dynamically set features like website name,website logo,website email,website timezone, website country,owners details etc
* use of bootstrap as css framework
* combination of multiple pages into one with help of bootstrap modal
* sanitized all the php codes into a function and removed useless codes
* any sql database can be choosen with minimal impact
* class and function are made in such a way that change of php drivers such as mysqli or pdo has minimal impact
* curently the whole website can switch betwen PDO and mysql driver in an instance with minimal impact
* server side code are based by taking consideration of new features and support. currently the code is supported upto php 7.4+
* websites can be reached without the .php extension in webaddress through htacess rewrite feature
* secuirty feature to give access only to allowed usertypes and user specific data and information
* security feature to prevent user from opening multiple tabs and logging out to still edit other profile's data
* security feature to prevent  hackers from mediating as a user by checking the user request origin and comparing user data previously sent to the user


# Features available:
* the user type is divided in guest,user,author,editor,admin and owner and various features and privilege is given according to user type
* there is a separate menu for user,guest and admin and and owner they are redirected to respected page on login
* log in as a guest with ability to read stories and contact admin is added
* the userlist table can be sorted,individual column can be hidden and the table can be searched upon
* users are locked for a moment in case of multiple failed login attempts and eventually blocked after too much failed login attempts
* * users get email for email verification,password change and profile verification



* admin section gets profile picture and the avataar in case no image is uploaded according to the gender of the user
* automatice creation of avatar image in case no image is uploaded
* the about section has been renovated with moving slideshows and social media links as well as a new theme
* users can view the number of times they have view the page in a session
* users can now view posted videos
* user are now allowed to post videos into their post
* readers are allowed to sort/searh posts on the basis of topic
* social media login feature
* create index,login,forgot password, terms and conditions and register page all in a single page with jquery
* add ability to check data like used username and used emails without submitting form with ajax
* add ability to create edit and update userlist with ajax



* allow users to create a post as anonymous author but still be able to manage the post as their own

users should be allowed to click a social media button and save their profile link in the profile section
they should also be able to see the previously posted profile link on the input textbox

## GUEST FEATURES
* view and search topics
* contact admin for problems
* read and share posts
* view comments 

## USER FEATURES
User have all the features of a guest plus the following additional feature
* add comments and replies as well as ability to edit and delete their own comments and replies
* view statistics ot their posts and post visitors
* statistics of their performance as well as profile data
* edit their profile as well as passwords
* create and edit their own posts
* follow other users
* view profile of other users
* get notification
* ability to contact admin as well as other users
* receive and view message sent by other users
* see the activity log of all the task performed by them
* decide whether they want to be redirected to a dashboard,home or user wall after login
* stop notification from certain tasks or delete notifications
* delete messages of users or stop getting message notification from certain users
* decide various post and profile related settings
* search post according to topics
* read and share post to external media
* user can create confession post without revealing their identity such user will be displayed as anonymous and their profile cannot be seen
* user can like,unlike,dislike, undislike other user's posts
* user can view other users statistics like last active, member since, no of post created, user reviews etc
* they can see the completion level of their profile



## EDITOR FEATURES
Editor have all the features of a user plus following ability
* view statistics as a dashboard
* add,edit or delete topics
* ability to take user reviews,problems and messages and creates approriate tickets
* edit and delete other user's posts
* review and delete other users comments and replies
* create a new post
* publish or unpublish a post
* add comments to a ticket or mark a ticket as open,pending,unrsolved or resolved
* login as a user and see the user side of interface or debugging or other things



##  ADMIN FEATURES
Admin have all the features of the editor plus following ability
* admin can view full statistics of the website
* ability to add new user
* admin can create a new user or create a new admin
* ability to add and delete profile pictures
* reset user passwords
* disable a user
* receive full detail of users
* create a report of users for a specific time periof
* delete a user
* edit user details
* review and close tickets created by editors
* admin can view if user target or post target has been reached or not


## OWNER FEATURES
Owners have all the features of an admin plus the ability to change sensitive data such as
* currency
* currency symbol
* website timezone
* website address
* website logo
* website name
* website icon
* website email and so on
* owner details such as name,address,contact and so on
* review activities of admin
* decide or post target or user targets to be achieved
