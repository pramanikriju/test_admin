# MemberVault Coding Test (demo admin)

This is a demo version of our old Admin program for testing purposes.  It reflects how many of our legacy systems are set up, and should give you a good idea of the type of code we are supporting.  Of course, we are aiming to migrate to Laravel, this is done in CodeIgniter without anything too fancy.  If you have ANY questions about the setup or as we go through this, please let me know at mike@membervault.co


## The task

 - You should pull down this code and get it set up running locally however you like.
 - You can log into the admin with "admin" for the username and password
 - Create your own feature branch off of master

Once you're logged in, you'll see on the main Users page that we are simply grabbing all 20,000+ records and displaying them on the page.  We're then wrapping this in a javascript "datatables" library to paginate it.  This means the page is still VERY slow to load, and won't remember where you were with the back button.

Your job is to remove the datatables library, and implement proper paging, only ever grabbing 50 records at a time from the database.  Please try and replicate the functionality that datatables is providing us, mainly as it refers to Search and column sorting.  If you wish to add in more ways to sort and filter, you can do so, but it is not required.  Ideally your solution will give our admins all the same functionality they already have, but much faster!

Once you think you have a great solution, please push your feature branch up and let me know at mike@membervault.co

## Installation

This is a pretty standard CodeIgnitor app and therefore has a pretty straight forward setup.  There are likely many ways to set this up, but we use a local PHP/MySQL/Apache for ourselves here.  Here is our suggested setup

 - Get PHP, Apache and MySql( or mariasql ) installed and set up locally
 - Checkout this code into your document root in a "test_admin" folder
 - Set up a vhost "www.testadmin.local" to point to that "test_admin" folder
 - Create a database called "test_admin" locally, and import the SQL dump in the root
 - Copy the _config.php file to config.php and change any connection info you have
 - Add a folder called "writable" in the /application folder, and make sure it's writable

You should then be able to simply browse to http://www.testadmin.local and see the login page.  Use "admin" for username and the password.  If you have issues here, please double check all of the steps and try again.  Reach out to me if you are unable to resolve this setup.