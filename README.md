# Xboard - like, the Next-Level control panel, you feel me?

Aight, so listen up, fam. This here's Xboard. It's built off that V2board thing, but we talkin' serious upgrades on the performance and features, ya dig?

## Disclaimer - gotta keep it real, know what I'm sayin'?

This whole shebang is just me learnin' and tinkerin', you know how it is. I ain't makin' no promises about it workin' perfectly or anything like that. If this thing blows up in your face (not literally, hopefully),  that's on you, homie. 

## Xboard - this ain't ur mama's control panel

This bad boy is like V2board on steroids. We talkin':

* **Laravel 10:** Upgraded and ready to roll.
* **Laravels Support:**  This thing handles more users at once than a nightclub bathroom. We talkin' 10x the power, baby!
* **Webman Support:** Even faster than Laravels. This thing's like the Usain Bolt of control panels.
* **Database-Driven Config:**  All the settings are stored in a database now. Fancy, right?
* **Docker & Distributed Deployment:** Run this bad boy anywhere, split it up across multiple servers, you name it.
* **Location-Based Subscriptions:** Hand out subscriptions based on where users are connectin' from. Keep that traffic local, homie.
* **Hy2 Support:** We got you covered.
* **Sing-box Support:** Yeah, we got that too.
* **Real IP Detection:** This thing sees through Cloudflare like it's nothin'.
* **Automatic Protocol Updates:** Automatically send the latest protocols to clients based on their version.
* **Line Filtering:** Filter subscriptions by location.  Need a server in Hong Kong or the US?  Done.
* **Sqlite Support:** Ditch MySQL if you want.  Use Sqlite instead. Your call.
* **Vue3, TypeScript, the Works:**  The whole front-end is rebuilt with the good stuff: Vue3, TypeScript, NaiveUI, Unocss, Pinia. You'll be lookin' fly. 
* **Bug Fixes:** We squashed more bugs than a windshield in summertime.

## System Requirements -  gotta have the right tools for the work

* **PHP 8.1+** (none of that old stuff)
* **Composer** (for managing those packages)
* **MySQL 5.7+** (or MariaDB, if you're feelin' adventurous)
* **Redis** (for that in-memory cache)
* **Laravel** (the framework that makes it all happen)

## Performance -  this thing's faster than you think [View real shiet](./docs/Performance.md)

We're talkin' night and day difference here. Xboard blows the old V2board out of the water. Check out the numbers:

| Test        | Old Way (php-fpm) | Old Way (opcache) | Laravels | Webman (Docker) |
|-------------|-------------------|--------------------|----------|-----------------|
| Homepage   | 6 requests/sec   | 157 requests/sec   | 477 requests/sec  | 803 requests/sec |
| User Sub  | 6 requests/sec   | 196 requests/sec   | 586 requests/sec  | 1064 requests/sec|
| User Home Load Time | 308ms       | 110ms          | 101ms     | 98ms            |

## Installation - let's get this bread

We got you covered with a bunch of different ways to install this bad boy:

* **1panel:**  [Click here for the 1panel guide](./docs/1panel安装指南.md)
* **Docker Compose (Command Line):**  [Click here for the Docker Compose guide](./docs/docker-compose安装指南.md)
* **aapanel + Docker Compose (Recommended):**  [Click here for the aapanel + Docker Compose guide](./docs/aapanel+docker安装指南.md)
* **aapanel:**  [Click here for the aapanel guide](./docs/aapanel安装指南.md)

## Migrating from Other Versions -  upgrading ain't no problem

We got you covered with migration guides for all the popular versions:

* **v2board dev (23/10/27):** [Click here for the migration guide](./docs/v2b_dev迁移指南.md)
* **v2board 1.7.4:** [Click here for the migration guide](./docs/v2b_1.7.4迁移指南.md)
* **v2board 1.7.3:** [Click here for the migration guide](./docs/v2b_1.7.3迁移指南.md)
* **v2board wyx2685:**  [Click here for the migration guide](./docs/v2b_wyx2685迁移指南.md)

## Important Notes -  pay attention!

* **Restart ffter path changes:** If you change the admin path, you gotta restart the server for it to take effect. 
   ```
   docker compose restart
   ```
* **Restart Webman (aapanel):**  If you're using aapanel, you gotta restart the Webman daemon after makin' changes. 
