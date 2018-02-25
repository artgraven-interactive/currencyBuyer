Mukuru Technical Test
========================

Resources
---------

The following are useful resources when reviewing the use and my thinking when creating the application,
These resource can be found in the Resources folder in the root

    * users guide
    * technical test instructions
    * core reasoning

Setup
-----


Dependencies?
--------------

I used some libraries and components to bootstrap my work flow:

  * FOS User Bundle - for managing users;
  * JMS Serializer Bundle - serializing objects to json;
    https://github.com/schmittjoh/JMSSerializerBundle
  * EightPointsGuzzleBundle - api calls
    https://packagist.org/packages/eightpoints/guzzle-bundle
  * A custom bootstrap template for look and feel;
  * Mail Gun for sending out mail;
    https://packagist.org/packages/dugandzic/swiftmailer-mailgun-bundle
    optional - troubleshoot 
        note that if you are sending mail from local you should have your php configured with ssl as guzzle is used as part of the transfer protocal
        for newbs you can grab a free .pem from a link here http://flwebsites.biz/posts/how-fix-curl-error-60-ssl-issue

3rd Party api's and keys
------------------------

    jsonrates
        api key
            cb62ab7fe2b1cfc2651b2f7291a0a9ff
        api endpoints
            http://www.apilayer.net/api/live?access_key=cb62ab7fe2b1cfc2651b2f7291a0a9ff

        usage
            documentation
                https://currencylayer.com/quickstart
            example
                http://apilayer.net/api/live
                ? access_key = YOUR_ACCESS_KEY
                & source = USD
                & currencies = GBP,AUD,CAD,PLN,MXN
                & format = 1
 
Getting Started
---------------

if you are new to symfony you can find some documentation on their site https://symfony.com/. note that we are using symfony 3.4 or the standard edition
so lets get started

    1. git pull the repo and cd into application folder
    2. create a database table to be used for your project
    3. composer install - this assumes composer is installed globally
        3.1 this will install the dependencies and ask you for mail configuration and database configuration
        3.1.1 use the correct db info
        3.1.2 use a valid email address and smtp as the protocal - note we will change this later but sometimes it can bug out if you use a dependancy before installed
    4. from inside the application folder run the following command to get started
        4.1 bin/console doctrine:schema:update --force
        4.2 bin/console server:run 
            4.2.1 this will start the internal server but note your mysql should already be running at this point.
            4.2.2 you can also skip this step if you setup a virtual host but given the file path this may be a bit of a process as it involves rewrites but you will point it into the web folder and handle the loading page which is app.php not index.php
        4.3 the dependancies are managed using npm and grunt and bower
            4.3.1 if the assets didn't install already or there are some issues with the views then install grunt/bower first assuming npm is installed
            4.3.2 by running the command: npm install -g grunt-cli - this is mostly used for helping compile of the sass files and such tasks
            4.3.3 to install missing third party vendors insure bower is installed
            4.3.4 by using the command: npm install -g bower
            4.3.5 to install for example jquery use: bower install jquery --save
                Installed Vendors List
                        Bootstrap
                        jQuery
                        Material Design Iconic Font
                        Animate.css
                        Flot
                        Flot Tooltips (For Flot charts)
                        Flot Orderbars (For Flot charts)
                        Flot CurvedLines (For Flot charts)
                        jQuery Vector Maps
                        Easy Pie charts
                        Data Tables
                        Buttons for DataTables (For Data Tables)
                        JSZip (For Data Tables)
                        Autosize Textarea
                        jQuery Mask
                        Select 2
                        Dropzone JS
                        FullCalendar
                        Moment JS (For FullCalendar)
                        Flatpickr
                        noUiSlider
                        Bootstrap Colorpicker
                        Trumbowyg WYSIWYG Editor
                        SweetAlert 2
                        LightGallery
                        Clamp.js (For notes.html)
                        Bootstrap Notify
                        jQuery Scrollbars
                        Scroll Lock (For jQuery Scrollbars)
                        Peity Charts
                        Rate Yo!
                        jqTree
                        jQuery Text Counter
    5. now that you are setup and ready to go you will need a user 
        5.1.0 you can create a user by clicking on the register item of first loaded page or going directly to {{url_base}}/register
        5.1.1 there are normal users and admin users. once you have created a user you can promote this user to admin by using the console
        5.1.2 in the application folder run the following command: bin/console fos:user:promote and follow the promotes you will need your username and the user role is ROLE_ADMIN to make the user an admin
        5.1.3 u can also use the same package to create a user from the command line and to promote or demote them
        5.2 for testing it is recommended to have a normal user and an admin user. this is because transactions depend on funds available in the wallet at currently only admin can top up a users wallet with funds
    6. one can use the internal mail system which is switch by doing the usual configurations in the paramaters.yml and config.yml but for ease of transfer and domain i have opted to use mailgun which pushes to a third party provider
        6.1 the configuration will be fine in the config.yml but you must update the paramaters.yml and change the mail protocall from smtp to mailgun for it to read 
        6.2 note that using curl via guzzle will by default require ssl. check the mailgun options at the top for suggestions on manually adding an ssl cert if you are new to local ssl configurations or are having problems with this




            



