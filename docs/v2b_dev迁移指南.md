# Migrating from V2Board Dev -  get with the times, hommie

This guide's gonna show you how to migrate from V2Board Dev (specifically the 2023/10/27 version) to the dope world of Xboard.  Database changes, file moves, the whole nine yards. 

## Database changes  -  the rundown

Here's the lowdown on what's about to go down in your database:

* **`v2_order` Table:**  
   *  Adding a new field called `surplus_order_ids` (text, nullable) to track those extra order IDs. 
* **`v2_plan` Table (Important for Cycle and Traffic Value Calculations):**
   * Removing the `daily_unit_price` field - we don't need that anymore.
   *  Removing the `transfer_unit_price` field - out with the old!
* **`v2_server_hysteria` Table (affects "Ignore Client Bandwidth" and "Obfuscation Type" Settings):**
   * Removing the `ignore_client_bandwidth` field - bye, bye!
   * Removing the `obfs_type` field - it's gone, baby, gone!

##  Before u start - listen up!

1. **Update V2Board:** Before you even THINK about migrating, make sure your V2Board Dev installation is updated to the **2023/10/27** version. Follow the official V2Board upgrade instructions to get there.

2. **Fresh Xboard install (no SQLite):**  Once V2Board's up-to-date, install a fresh copy of Xboard.  And don't even TRY using SQLite for this - pick a different database type. 

   *  Need help with the installation?  Check these guides:
      * [Docker Compose (Command Line)](./docs/docker-compose安装指南.md)
      * [aaPanel + Docker Compose](./docs/aapanel+docker安装指南.md)
      *  [aaPanel](./docs/)

3. **SQLite? good luck:**  If you're using SQLite, you're on your own for the migration.

##  Let's migrate!

###  Docker environments

1. **SSH time:**  SSH into your server and navigate to your Xboard project directory.
2.  **Stop Xboard:**

    ```bash
    docker compose down
    ```

3.  **Wipe the DB:**

    ```bash
    docker compose run -it --rm xboard php artisan db:wipe
    ```

4. **Import ur DB (dont mess this up):** Import your V2Board Dev database into the newly created Xboard database.  

5. **Migrate:**

    ```bash
    docker compose run -it --rm xboard php artisan migratefromv2b dev231027
    ```

### aaPanel environments

1.  **Wipe the DB:** 

    ```bash
    php artisan db:wipe
    ```

2.  **Import ur old database (Seriously, Don't Forget This):**  Import your V2Board Dev database into the Xboard database. 

3.  **Migrate:**

    ```bash
    php artisan migratefromv2b dev231027
    ```

##  Migrate that config file - 1 last thing

After the database migration's done, you gotta migrate the `config/v2board.php` file. Xboard's gone digital and stores those settings in the database now.  Head to the [Config File Migration Guide](./config迁移指南.md) for the steps. 
