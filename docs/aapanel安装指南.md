# Xboard installation guide: The aaPanel edition - straight-up, no chaser

This guide's gonna walk you through setting up Xboard on aaPanel like a boss. Let's get this bread.

## Installation -  its bout to get real

**Word to the wise:** Some folks have had trouble getting Xboard up and running on CentOS 7. You might wanna use a different OS if you can.

### Step 1: settin up aaPanel -  laying the groundwork

1. **Install aaPanel:** Open your terminal and drop this command like a mixtape:

   ```bash
   URL=https://www.aapanel.com/script/install_6.0_en.sh && if [ -f /usr/bin/curl ];then curl -ksSO "$URL" ;else wget --no-check-certificate -O install_6.0_en.sh "$URL";fi;bash install_6.0_en.sh aapanel
   ```

2. **Login and choose LNMP:**  Log in to your aaPanel dashboard and choose the "LNMP" environment for installation. Select these options:

   * **Nginx (Any version)** -  We roll with whatever you got.
   * **MySQL 5.7** - The database king.
   * **PHP 8.1** (install it from the App Store if you don't see it) - Powering the backend.

   Choose "Fast" for compilation and let it rip.

3. **Extensions are key:**

   *  Go to **aaPanel Dashboard** > **App Store** > Find **PHP 8.1** > **Settings** > **Install extensions**.
   *  Install these extensions: 
      * `redis`
      * `fileinfo`
      * `swoole4`
      * `readline`
      * `event`
      * `inotify` (optional, for hot reloading)

4. **Unleash the functions:**

   * Go to **aaPanel Dashboard** > **App Store** > **PHP 8.1** > **Settings** > **Disabled functions**.
   * Remove these functions from the list:
      * `putenv`
      * `proc_open`
      * `pcntl_alarm`
      * `pcntl_signal`

5. **Add ur site:**

   * Go to **aaPanel Dashboard** > **Website** > **Add Site**.
   * Enter your domain name (make sure it's pointed at your server) in the **Domain** field.
   * Choose **MySQL** for the database.
   * Select **PHP-81** for the PHP version.

6. **Install Xboard:**

   *  **SSH Time:** Log in to your server via SSH.
   * **Navigate:** Go to your site's directory (e.g., `/www/wwwroot/your-domain-name`).
   * **Clean House:** Delete these files:

     ```bash
     chattr -i .user.ini
     rm -rf .htaccess 404.html 502.html index.html .user.ini
     ```

   * **Clone the code:**

     ```bash
     git clone https://github.com/cedar2025/Xboard.git ./
     ```

   *  **Install:**

     ```bash
     sh init.sh
     ```

   * **Follow the prompts:**  Enter the required information when prompted.

7. **Configure site directory & rewrite rules:**

   * Go to your site's settings in aaPanel, then **Site directory** > **Running directory**, and select `/public`. Save those changes.
   * Head over to **URL rewrite** and paste in these rules:

     ```nginx
     location /downloads {
     }

     location / {  
         try_files $uri $uri/ /index.php$is_args$query_string;  
     }

     location ~ .*\.(js|css)?$
     {
         expires      1h;
         error_log off;
         access_log /dev/null; 
     }
     ```

8. **Setting up the daemon process:** 

   * Xboard needs its queues running, so we'll use Supervisor (from aaPanel) to keep things running smoothly.
   *  Go to **aaPanel Dashboard** > **App Store** > **Tools**.
   * Find and install **Supervisor**.
   * Once installed, go to **Supervisor settings** > **Add Daemon**. 
   * Fill in the details:
     * **Name:** `Xboard`
     * **Run User:** `www`
     * **Run Dir:**  Your site's directory
     * **Start Command:** `php artisan horizon`
     * **Processes:**  `1`
   * Hit "Confirm" and watch it go.

9.  **Schedule those tasks:**

    *   Go to **aaPanel dashboard** > **Cron**.
    *   * **Type of task:** `Shell Script`
        * **Name of task:** `v2board`
        * **Period:** `N Minutes 1 Minute`
        * **Script content:** `php /www/wwwroot/your-site-path/artisan schedule:run`

    *   This sets up a cron job to run every minute. Make sure your path to the script is accurate!

### Enabling Webman for maximum power

Want to boost performance even further?  Webman's got your back.

1. **Configure `php.ini`:** 

   * SSH into your server and navigate to your site's directory.
   * Execute these commands:

     ```bash
     cp /www/server/php/81/etc/php.ini cli-php.ini
     sed -i 's/^disable_functions[[:space:]]*=[[:space:]]*.*/disable_functions=header,header_remove,headers_sent,http_response_code,setcookie,session_create_id,session_id,session_name,session_save_path,session_status,session_start,session_write_close,session_regenerate_id,set_time_limit/g' cli-php.ini
     ```

2. **Add the webman daemon:** 

   *  Open up Supervisor in aaPanel (**aaPanel Dashboard** > **App Store** > **Tools**).
   *   Go to settings and click **Add Daemon**.
   *  Fill in the details:
     * **Name:** `webman`
     * **Run user:** `www`
     * **Run dir:**  Your site's directory
     * **Start command:**  `/www/server/php/81/bin/php -c cli-php.ini webman.php start`
     * **Processes:**  `1`
   *  Hit "Confirm" to get Webman rollin'.

3.  **Rewrite the rules (again):**

    *   Go to ur site's settings in aaPanel, then head to **URL Rewrite (Rewrite rules)** and replace the existing rules with these:

        ```nginx
        location ~* \.(jpg|jpeg|png|gif|js|css|svg|woff2|woff|ttf|eot|wasm|json|ico)$ {

        }
        location ~ .* {
                proxy_pass http://127.0.0.1:7010;
                proxy_http_version 1.1;
                proxy_set_header Connection "";
                proxy_set_header X-Real-IP $remote_addr;
                proxy_set_header X-Real-PORT $remote_port;
                proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
                proxy_set_header Host $http_host;
                proxy_set_header Scheme $scheme;
                proxy_set_header Server-Protocol $server_protocol;
                proxy_set_header Server-Name $server_name;
                proxy_set_header Server-Addr $server_addr;
                proxy_set_header Server-Port $server_port;
          }
        ```

    *   Now u r cookin' with Webman!

### Updating Xboard - stay ahead of the game

1.  **SSH and navigate:** You know the drill.  Log in to ur server via SSH and go to ur site's directory.
2.  **Update Time:**

    ```bash
    sh update.sh
    ```

3.  **Restart Webman (if u r usin it):**

    *   Head to Supervisor in aaPanel (**aaPanel Dashboard** > **App Store** > **Tools**).
    *   Find the Webman daemon and hit the "Restart" button.

### Word of wisdom

Remember, if u'r using Webman, any code changes you make require a restart for those changes to take effect. 
