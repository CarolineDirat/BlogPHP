# BlogPHP

**Professional blog written as part of my web developer training.**

PHP - Object Oriented Programming - Model View Controller

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/8044d672c24c4334b6ddb7926e3ed1f4)](https://app.codacy.com/manual/CarolineDirat/BlogPHP?utm_source=github.com&utm_medium=referral&utm_content=CarolineDirat/BlogPHP&utm_campaign=Badge_Grade_Settings)

#### Constraints
- no CMS
- no framework
The only lines of code that can come from elsewhere will be those of the Bootstrap theme, which you will be careful to choose.

## Requirements

#### BlogPHP installation needs:
- in command line:
  * **composer**:  [getcomposer.org/](https://getcomposer.org/)
  * **Git**: [git-scm.com/](https://git-scm.com/) to clone the project
- and:
  * **NCSA HTTPd** server as **Apache**, because it use .htaccess file.

#### BlogPHP use:
- **PHP** version: 7.4.* (server and terminal),[www.php.net/](https://www.php.net/)
- **MySQL** database that you can manage with a **database tool** (as [phpmyadmin](https://www.phpmyadmin.net/) or [DBeaver](https://dbeaver.io/) ...)
- **URL rewriting**, so on **Apache**, you must active **rewrite_module** module.
- **[cocur/slugify](https://github.com/cocur/slugify)** package requires the **Multibyte String extension** from PHP. Typically you can use the configure option --enable-mbstring while compiling PHP. More information can be found in the [PHP documentation](https://www.php.net/manual/en/mbstring.installation.php).
- **PHPMailer** to send emails. To understand its configuration in config/config.php, and in src/Application/PHPMailerApp.php, you can see its [documentation](https://github.com/PHPMailer/PHPMailer#a-simple-example) on Github.

## Installation on a local server :

The following instructions guide you to install the project locally, on HTTP server Apache (for example : with Wampserver).

1. **Clone the project** from Github 
   At the root of your local serveur, with command line
   
   > `git clone  https://github.com/CarolineDirat/BlogPHP.git`

   We obtain for example: C:/wamp/www/BlogPHP
   > _You can rename the BlogPHP directory if you want._
   
2. At the root of _BlogPHP_ directory, use composer to **download vendor** with:
   > `composer install`

3. Define your **configuration data**:
  - **copy** the config/**config.php.dist** file by naming it config/**config.php**
  - in config/config.php, from line 26, **define** each **constant value** with yours
   
4. In your MySQL database :   
  - **Create** the **database** (with the name defined in config/config.php file)
    > **charset**: utf8mb4  
    > **collation**: utf8mb4_unicode_ci
  
  - **Create tables** in your database by running the script in the **createdatabase.sql** file.

  - Run **incomplete_dataset.sql** script to put data in database. 
    > This data contains users, posts and comments (with different status) to understand how the site works. You can delete unnecessary data later. You will be able to change admin password later too.
    But **users's emails address are missing**, so from your database tools, **add users's emails**. You can put 4 identical mails, but Admin's email address must match to EMAIL_ADMIN constant defined in your config/config.php file.

       user       |  password     |    role    |   status
     ------------ | ------------- | ---------- | ------------
     Admin        |  admin        | admin      | enabled
     Subscriber1  |  subscriber1  | subscriber | enabled
     Subscriber2  |  subscriber2  | subscriber | enabled
     Subscriber3  |  subscriber3  | subscriber | not enabled

5. Create a **virualhost** on **Wampserver**. 
Be careful, virtualhost must point to the public directory
  > for example: C:/wamp/www/BlopPHP/public
   
### **Change the admin data to login**
  - You can change his pseudo as you want (but users pseudos must be distincts).
  - Be careful, passwords are hashed with `password_hash(string 'password', PASSWORD_DEFAULT')` => You can change admin passsword only if you use this function to hash it.

### Warnings 
##### If you want push this project in production :
I have the rights for the CaroCode logo, you do not have the right to use it on your own website (or any other public use). You must therefore change the public/build/img/logo.png file.

## Use 

##### Here are some URIs corresponding to the features of the blog:

### Any user
#### /
> On the home page, any user can contact you from contact form.
Your CV must be a file named resume.pdf, in public/download directory.
#### /blog    
> Lists posts from most recent to oldest
#### /post/{id}/{slug}
> To read a post
#### /login
> To log in.
#### /register
> To register : a user will be created with Subscriber role (only to comment posts), and a confirmation email is send to him to activate his account.

### Subscriber user
#### /post/{id}/{slug}
> Can add a comment on a post (but it will have to be validated by admin who will receive an email)
### Admin user
#### /admin, 
> To manage posts : add, modify or delete a post
#### /admin/add/post
> To add a post
#### /admin/update/post/{id}
> To modify a post
#### /admin/delete/post/{id}
> To delete a post
#### /admin/comments/post/{id}
> To manage post's comments

[![Codacy Badge](https://app.codacy.com/project/badge/Grade/25ebc61fdc9e40b7b92cab3794831cbb)](https://www.codacy.com/manual/CarolineDirat/BlogPHP?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=CarolineDirat/BlogPHP&amp;utm_campaign=Badge_Grade)
