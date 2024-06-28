# Tho PHP Authorization
![version](https://img.shields.io/badge/Version-1.0.1-green.svg)

User authorization PHP library. Includes code to manage users: sign up, sign in, sign out, forgot password, sending emails.

## Contents
+ [What's new](#whats-new)
+ [Features](#features)
+ [Install](#simple-example)
+ [Examples](#examples)
+ [Simple example](#simple-example)
+ [Generic example](#generic-example)
+ [License](#license)


## What's new
- Added ability to work with files/streams
- Added ability to send emails via sendmail/SMTP
- Added Birthday, E-Mail, File, Message related PHP traits, interfaces and clases in Data
- Added ExitException - exception to exit to closest try..catch
- Added Log PHP classes to preserve log messages

## Features
- Users can be stored in MySQL database
- Set prefix for database tables
- User sign in
- User sign up
- User sign out
- User keep signed in/remember me
- Mail sending (sendmail/SMTP) with ability to provide CC, BCC, sender, reply to, file attachments

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


### Generic example
*For this example You will need working web server/hosting with PHP and MySQL installed.*

Example of generic user authorization.
User has all gereric fields: user name, First and Last name, birthday, email, phone number and address fields.
User can sign in with user name, email or phone number.
Notification mail is sent to admin and user email on sign up.
It has example of attaching file to mail letter for user.

*It outoloads PHP classes from ThoPHPAuthorization namespace*

[Example folder -->](examples/generic)

#### Instalation
1. Create MySQL database for this example, if you don't have one
2. Open in text editor `examples/generic/settings.php` and change **ALL** settings constats values to Yours
3. Add all required database tables by opening in browser `examples/generic/install.php`
4. Open in browser `examples/generic/index.php` everything should work now

## License

[GNU/GPLv3](LICENSE)