# Tho PHP Authorization
![version](https://img.shields.io/badge/Version-1.0.2-green.svg)

User authorization PHP library. Includes code to manage users: sign up, sign in, sign out, forgot password, sending emails.

## Contents
+ [What's new](#whats-new)
+ [Features](#features)
+ [Install](#simple-example)
+ [Examples](#examples)
+ [Simple example](#simple-example)
+ [Generic example](#generic-example)
+ [Advanced example](#advanced-example)
+ [License](#license)


## What's new
- Added code for database transactions - start, commit, rollback transaction;
- Added data lazy load - load data when it required, i.e. load additional data from database on request
- Added advanced example (#advanced-example)

## Features
- Users can be stored in MySQL database
- Set prefix for database tables
- User sign in
- User sign up
- User sign out
- User keep signed in/remember me
- Mail sending (sendmail/SMTP) with ability to provide CC, BCC, sender, reply to, file attachments
- Forgot password
- User editing
- Data lazy load

## Examples
For refference there are a few examples of how it can be done, but You are not limited to these examples and can use it as base for Your requirements.

- [Simple example](#simple-example) - very basic example, that provides only user name and password example
- [Generic example](#generic-example) - example with all generic data data, mail sending on user sign up

You can find all examples at [Examples folder](examples)


### Simple example
*For this example You will need working web server/hosting with PHP and MySQL installed.*

Simple example of user authorization with user name and password.

[Example folder -->](examples/simple)

#### Instalation
1. Create MySQL database for this example, if you don't have one
2. Open in text editor `examples/simple/settings.php` and change **ALL** settings constats values to Yours
3. Add all required database tables by opening in browser `examples/simple/install.php`
4. Open in browser `examples/simple/index.php` everything should work now

#### Autoload
By default it includes all required PHP files in `examples/simple/includes.php`.
To make it autoload PHP classes from ThoPHPAuthorization namespace you can change `require_once('./includes/start.php');` to `require_once('./includes/start-autoload.php');` in all files

#### Pages
- `install.php` - adds all required tables to the database;
- `index.php` - page with sign in form, or user details for signed in users;
- `sign-up.php` - user sign up form;
- `sign-out.php` - user sign out page, will sign out user and redirect to `index.php`.


### Generic example
*For this example You will need working web server/hosting with PHP and MySQL installed.*

Example of generic user authorization.
User has all gereric fields: user name, First and Last name, birthday, email, phone number and address fields.
User can sign in with user name, email or phone number.
Notification mail is sent to admin and user email on sign up.
It has example of attaching file to mail letter for user.


*It autoloads PHP classes from ThoPHPAuthorization namespace*

[Example folder -->](examples/generic)

#### Instalation
1. Create MySQL database for this example, if you don't have one
2. Open in text editor `examples/generic/settings.php` and change **ALL** settings constats values to Yours
3. Add all required database tables by opening in browser `examples/generic/install.php`
4. Open in browser `examples/generic/index.php` everything should work now

#### Pages
- `install.php` - adds all required tables to the database;
- `index.php` - page with sign in form, or user details for signed in users;
- `sign-up.php` - user sign up form, will send admin and user email on successful sign up;
- `forgot-password.php` - forgot password form, when existing user email is entered: it will send email with a link to `restore-password.php` page with unique security key (genrated unique for user name and password) to change user password;
- `restore-password.php` - restore password form, requires valid security key to access;
- `edit-user-details.php` - edit signed in user details (first and last name, birthday, address);
- `edit-user-contacts.php` - edit signed in user contact data (username, email, phone number), it will require current user password to do so;
- `change-password.php` - change signed in user password, it will require current user password to do so;
- `sign-out` - user sign out page, will sign out user and redirect to `index.php`.


### Advanced example
*For this example You will need working web server/hosting with PHP and MySQL installed.*

Example of advanced user authorization.
User has all sort of fields: user name, First and Last name, birthday, email, additioanl emails, phone number, additional phone numbers and multiple sets of addresses.
User can sign in with user name, email or phone number.
Notification mail is sent to admin and user email on sign up.
It has example of attaching file to mail letter for user.
Forgot password requests are stored in the MySQL database.


*It autoloads PHP classes from ThoPHPAuthorization namespace*

[Example folder -->](examples/advanced)

#### Instalation
1. Create MySQL database for this example, if you don't have one
2. Open in text editor `examples/advanced/settings.php` and change **ALL** settings constats values to Yours
3. Add all required database tables by opening in browser `examples/advanced/install.php`
4. Open in browser `examples/advanced/index.php` everything should work now

#### Pages
- `install.php` - adds all required tables to the database;
- `index.php` - page with sign in form, or user details for signed in users;
- `sign-up.php` - user sign up form, will send admin and user email on successful sign up;
- `forgot-password.php` - forgot password form, when existing user email is entered: it will send email with a link to `restore-password.php` page to change user password, with unique security key for each password recovery request;
- `restore-password.php` - restore password form, requires valid security key to access;
- `edit-user-details.php` - edit signed in user details (first and last name, birthday, address);
- `edit-user-contacts.php` - edit signed in user contact data (username, email, phone number), it will require current user password to do so;
- `change-password.php` - change signed in user password, it will require current user password to do so;
- `sign-out` - user sign out page, will sign out user and redirect to `index.php`.

## License

[GNU/GPLv3](LICENSE)