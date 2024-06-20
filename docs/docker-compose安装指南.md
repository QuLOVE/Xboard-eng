#  Xboard installation guide:  the Docker compose express lane -  get up and runnin in 2 Minutes flat

This guide's gonna show you how to get Xboard rollin' using Docker Compose and SQLite. It's the quickest, cleanest way to get your hands dirty with Xboard.  

**MySQL not invited (Yet):**  We're keeping it simple for now.  If you need MySQL, you'll have to install and configure that yourself. Don't worry, we got you covered with separate instructions for that.

## Deployment:  faster than u can say "Docker compose"

1. **Get Docker on ur system:** 

   ```bash
   curl -sSL https://get.docker.com | bash
   systemctl enable docker
   systemctl start docker
   ```

2. **Grab the Docker compose file:**

   ```bash
   git clone -b docker-compose --depth 1 https://github.com/cedar2025/Xboard
   cd Xboard
   ```

3. **Install the DB (SQLite Style):**

   ```bash
   docker compose run -it --rm xboard php artisan xboard:install
   ```
   * **Keep it Simple:** Choose "Enable SQLite" and "Docker Built-in Redis" during the installation.
   * **Save Your Credentials:** This command will give you your backend URL and admin login. Guard them with your life (or at least write them down somewhere safe).

4. **Start Xboard:**

   ```bash
   docker compose up -d
   ```
   * **You're Live!**  You can now access your Xboard site. The default port is 7001, but you can set up a reverse proxy with Nginx to use port 80 if you're feeling fancy.

5. **Access ur site:**

   *  Go to: `http://your-server-ip:7001/`

   **Congratulations!** You've got a fully functional Xboard installation.

**Need MySQL?** No problem. Install it separately and then follow the Docker Compose instructions again.

## Updating:  keep it fresh

1. **Change the version (if needed):**

   * Go to your Xboard directory and open up the `docker-compose.yaml` file:

      ```bash
      cd Xboard
      vi docker-compose.yaml
      ```

   * Find the line that starts with `image:` and change the version number to the version you want. If you're using the latest version (`latest`), you can skip this step.

2. **Update:**

   ```bash
   docker compose pull
   docker compose down
   docker compose run -it --rm xboard php artisan xboard:update
   docker compose up -d
   ```

**Boom!**  Updated and ready to rock.

## Rolling Back:  oops, my bad

This rollback process doesn't touch your database.  Check the Xboard docs for details on how to roll back your database if you need to.

1.  **Change the version:** 

    *   Open the `docker-compose.yaml` file (in your Xboard directory) and change the version number in the `image:` line back to the previous version you were using.

2. **Start it up:**

   ```bash
   docker compose up -d
   ```

##  Keep in mind:

*   **Webman restarts:** If you enabled Webman and made code changes, you'll need to restart it for those changes to take effect. 
