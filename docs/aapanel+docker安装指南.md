#  Xboard installation guide: The aaPanel + docker power move

Yo, wanna get Xboard pumpin' on your server using aaPanel and Docker? We 'bout to make this happen. 

##  Deployment -  lets get down to business

### Step 1: setting up aaPanel and docker - laying the foundation

1. **Install Docker (Like a Boss):** Open your terminal and hit it with:

   ```bash
   curl -sSL https://get.docker.com | bash
   systemctl enable docker
   systemctl start docker
   ```

2. **aaPanel time:** Now install aaPanel:

   ```bash
   URL=https://www.aapanel.com/script/install_6.0_en.sh && if [ -f /usr/bin/curl ];then curl -ksSO "$URL" ;else wget --no-check-certificate -O install_6.0_en.sh "$URL";fi;bash install_6.0_en.sh aapanel
   ```

3.  **aaPanel setup:** Log in to your shiny new aaPanel dashboard and let's get this bread. 

4. **LNMP environment:** Choose the "LNMP" environment for installation and select the following options:

   * **Nginx (Any version)** - We ain't picky.
   * **MySQL 5.7** -  For that database goodness.

   Choose "Fast" for compilation speed and proceed with the installation.

   **Pro tip:**  You don't need to install PHP or Redis. We got you covered on that front.

5. **Add ur site:**

   * Go to **aaPanel Dashboard** > **Website** > **Add Site**.
   * In **Domain**, enter your domain name (pointed at your server).
   * Choose **MySQL** for the database.
   * Select **Pure Static** for the PHP version.

### Step 2: Installing Xboard - time to unleash the beast

1.  **SSH time:** Log in to your server via SSH.
2.  **Navigate to ur site:**  Go to your site's directory. Should be something like `/www/wwwroot/your-domain-name`.
3.  **Clean up time:** Delete any unnecessary files:

   ```bash
   chattr -i .user.ini
   rm -rf .htaccess 404.html index.html .user.ini
   ```

4.  **Clone Xboard:** Get that code:

   ```bash
   git clone https://github.com/cedar2025/Xboard.git ./
   ```

5. **Docker compose setup:**
   * Copy the sample docker compose file:
      ```bash
      cp docker-compose.sample.yaml docker-compose.yaml
      ```
   * Install dependencies and Xboard:
      ```bash
      docker compose run -it --rm xboard sh init.sh
      ```

6.  **Enter ur info:** Follow the prompts and enter the required information.
7.  **Save ur credentials:** This step will give you ur backend URL and admin login.  Keep 'em somewhere safe.
8.  **Start Xboard:**

   ```bash
   docker compose up -d
   ```

9.  **Reverse proxy setup:**
   * Go to **Site Settings** > **Reverse Proxy** > **Add Reverse Proxy**.
   * In **Proxy Name**, enter `Xboard`.
   * In **Target URL**, enter `http://127.0.0.1:7001`.
   * **Modify the Reverse Proxy rules** to look like this:

     ```nginx
     location ^~ / {
         proxy_pass http://127.0.0.1:7001;
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
         proxy_cache off;
     }
     ```

🎉 **You're good to go!** You should now be able to access your Xboard panel using your domain name.

## Updating Xboard - stayin' fresh

1.  **SSH and navigate:** Log in to your server via SSH and go to your site's directory.
2.  **Update time:**

   ```bash
   docker compose pull
   docker compose run -it --rm xboard sh update.sh
   ```

3.  **Restart Xboard:**

   ```bash
   docker compose restart
   ```

🎉 **Update complete!**  You're rocking the latest and greatest version of Xboard.

##  Remember

*  **Webman needs a reboot:** If you make any code changes after enabling Webman, you gotta restart it for those changes to take effect.
