# Migrating ur config file -  out with the 0ld, in with the db

Yo, listen up!  Xboard's gone high-tech. We're storing config settings in a db now, not just some random file. Here's the rundown on how to get ur config migrated over. 

## Docker compose environments

1. **Create a folder:** In ur Xboard directory, make a new folder called `config`.
2. **Copy the old file:** Grab the `v2board.php` file from ur old project and drop it into that new `config` folder.
3. **Uncomment the magic line:** Open up ur `docker-compose.yaml` file and find this line:

   ```yaml
   # - ./config/v2board.php:/www/config/v2board.php
   ```

   Remove that pesky `#` at the beginning of the line to uncomment it.  That's the good stuff.

4. **Migrate time:** Now hit these commands in ur terminal (make sure you're in the Xboard directory):

   ```bash
   docker compose down
   docker compose run -it --rm xboard php artisan migrateFromV2b config 
   docker compose up -d
   ```

##  aaPanel environments

1. **Copy the file:** Same deal as before. Copy the `config/v2board.php` file from ur old setup and put it in the `config` folder of ur Xboard installation.
2. **Migrate:** Execute this command in ur terminal (make sure u'r in the Xboard directory):

   ```bash
   php artisan migrateFromV2b config 
   ```

## aaPanel + Docker Environments

1. **Copy (u guessed it):** Yep, copy the `config/v2board.php` file from ur old setup into the `config` folder of ur Xboard installation. 
2. **Migrate:** Hit these commands (make sure you're in the Xboard directory):

   ```bash
   docker compose down
   docker compose run -it --rm xboard php artisan migrateFromV2b config
   docker compose up -d
   ```

## Important Notes -  don't skip this part

* **Restart for path changes:** If you change the admin path, you gotta restart the server for it to take effect.

   ```bash
   docker compose restart
   ```

* **Restart Webman (aaPanel):**  If you're rockin' aaPanel and Webman, you gotta restart the Webman daemon after making those changes.
