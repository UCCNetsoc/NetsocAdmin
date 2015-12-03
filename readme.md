Pokemon QR Code Competition
===
The idea of the game is simple: scan a QR code, catch a pokemon. Catch as many pokemon as you can before the deadline and the person with the most tied to their account wins a prize.

## Table Of Contents
* [Setup](#setup)
    * [Vagrant Box](#vagrant-box)
    * [Add an entry to your hosts file](#add-an-entry-to-your-hosts-file)
    * [.env file](#env-file)
    * [Node and Gulp](#node-and-gulp)
    * [You're good to go!](#youre-good-to-go)


| Category                              | Task                                                                                      | Sub-task/Info                          | Assignee | Status |
|---------------------------------------|-------------------------------------------------------------------------------------------|----------------------------------------|----------|--------|
| User Registration/Management          |                                                                                           |                                        |          |        |
|                                       | 1. Determine the relevant fields we need to store for a user                              |                                        |          |        |
|                                       | 2. Create relevant registration form                                                      |                                        |          |        |
|                                       | 3. Allow user to edit their information afterwards                                        |                                        |          |        |
|                                       | 4. Ability to signify a user as an admin (possibly just another field in the users table) |                                        |          |        |
| Administration Area                   |                                                                                           |                                        |          |        | 
|                                       | 1. Ability to add, change and remove system variables                                     |                                        |          |        |
|                                       |                                                                                           | * Start and end date of competition    |          |        |
|                                       | 2. Statistics (optional)                                                                  |                                        |          |        |
|                                       |                                                                                           | * Time series of all catches occurring |          |        |
|                                       |                                                                                           | * Most caught pokemon                  |          |        |
|                                       |                                                                                           | * Least caught pokemon                 |          |        |
|                                       | 3. Ability to edit user's profile data                                                    |                                        |          |        |
|                                       | 4. Ability to send user a reset password email                                            |                                        |          |        |
|                                       | 5. Generate all QR codes for printing                                                     |                                        |          |        |
|                                       | 6. Generate specific pokemon's code for printing                                          |                                        |          |        |
| Email Templates                       |                                                                                           |                                        |          |        |
|                                       | * Leaderboard update (sent once a day during the duration of the contest)                 |                                        |          |        |
|                                       | * Welcome email upon registering                                                          |                                        |          |        |
|                                       | * Password reset email                                                                    |                                        |          |        |
|                                       | * "Congratulations you're a winner" email                                                 |                                        |          |        |
| The Game Itself                       |                                                                                           |                                        |          |        |
|                                       | 1. Database of pokemon                                                                    |                                        |          |        |
|                                       | 2. Relation table to associate a pokemon with a unique hash                               |                                        |          |        |
|                                       | 3. Pages for each of the pokemon based on the hash of a URL                               |                                        |          |        |
|                                       | 4. Nonce system for once-off pokemon codes (optional)                                     |                                        |          |        |
| Leaderboard                           |                                                                                           |                                        |          |        |
|                                       | 1. List of people ranked by the number of pokemon they caught                             |                                        |          |        |
| Asassin's Branch (optional)           |                                                                                           |                                        |          |        |
|                                       | * More elaborate profiles                                                                 |                                        |          |        |
|                                       | * Draw in timetable data based on a person's course (optional - probably very very hard)  |                                        |          |        |
|                                       | * On "catch", assign person a new "target" wit a new target info email                    |                                        |          |        |
| Payment/Stripe Integration (Optional) |                                                                                           |                                        |          |        |
|                                       | 1. Implement payment upon registration                                                    |                                        |          |        |
|                                       |                                                                                           |                                        |          |        |
## Setup

### Vagrant Box

```bash
# Adds the box permanently to our collection as well as downloads it
vagrant box add Netsoc https://dl.dropboxusercontent.com/u/20999985/Vagrant%20Boxes/Netsoc.box

# Launches the Virtual Machine
vagrant up
```

### Add an entry to your hosts file

* On Mac and Linux, you can open the terminal and type `sudo vim /etc/hosts`.
* On Windows, you'll have to open notepad in administrator mode and then go to `C:\\Windows\System32\drivers\etc\hosts.txt`

Add the following to the end:

```
172.22.22.25 pokemon.dev
```

### .env file

You'll need to create a `.env` file in the root directory of your application (i.e. where your Vagrantfile is). Below is an example `.env` file you can use.

```php
APP_ENV=local
APP_DEBUG=true
APP_KEY={32$9;`GTky*=A"qw&v+-pe,?rGz$+/E
APP_URL=http://localhost

DB_HOST=localhost
DB_DATABASE=pokemon
DB_USERNAME=root
DB_PASSWORD=root

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_DRIVER=sync

MAIL_DRIVER=smtp
MAIL_HOST=mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null

DEV_EMAIL=netsoc@uccsocieties.ie
SITE_TITLE=Netsoc Pokemon
```

### Node and Gulp
Gulp is a build system which just means it's sort of like a customisable compiler for anything you're doing. We're using it to 1) compile LESS files and 2) refresh the browser whenever we make a change to a view or css.

In order to use Gulp, you will have to [install Node.js](https://nodejs.org/download/).

When Node is installed, simply navigate to your code's root directory (i.e. where the [package.json file](https://github.com/UCCNetworkingSociety/Pokemon-Gotta-Catch-Em-All/blob/master/package.json) is) and run the following command:

```bash
npm install
```

Everything you'll need will be installed in the node_modules folder. So to start the project, run the following:

```bash
gulp watch
```

### You're good to go! 
Now you can go to [http://localhost:3000/public](http://localhost:3000/public) to access the project and have it reload any time you make a change to the styling or layout.