#  Xboard installation guide: the 1panel edition -  let's get this bread

Yo, so you wanna set up Xboard using 1panel? I got you. This guide's gonna walk you through it step-by-step, like a recipe for digital domination.

##  Installation - its easier than u think

### Step 1: get 1panel up and runnin

1.  **Install 1panel:**  Open your terminal and drop this command like it's hot:

    ```bash
    curl -sSL https://resource.fit2cloud.com/1panel/package/quick_start.sh -o quick_start.sh && sudo bash quick_start.sh
    ```

2.  **Login and set it up:** Once 1panel's installed, login with your credentials and set up your environment.

### Step 2: Install the necessary apps

1.  **Head to the app store:** In your 1panel dashboard, navigate to the "App Store" section.
2.  **Install time:** You're gonna need:

    *   **OpenResty (Any version):** Make sure you check the "External Access for Port" option during installation to open the firewall.
    *   **MySQL 5.7.\***: If you're on an ARM architecture, MariaDB can roll with it too.

    **Pro tip:**  Keep the default settings during the installation process unless you really know what you're doing.

### Step 3: Set up ur site

1.  **Create a website:**  Go to "Websites" in your 1panel dashboard and hit the "Create Website" button. Choose "Reverse Proxy" as the site type.
2.  **Fill in the blanks:**
    *   **Main Domain:** Enter the domain name you pointed to your server.
    *   **Code:**  Type in `xboard`.
    *   **Proxy Address:** Enter `127.0.0.1:7001`.
3.  **Create and configure:** Hit the "Create" button and then go to "Configure" \> "Reverse Proxy" \> "Source Text" for your newly created site. Replace the existing rules with the following:

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

### Step 4: create the DB

1.  **Database time:** Head to the "Database" section in your 1panel dashboard and click "Create Database."
2.  **Details, details:** 
    *   **Name:**  Enter `xboard`.
    *   **User:**  Enter `xboard`.
    *   **Permissions:** Select "Everyone (%)".
3.  **Create and remember:**  Hit that "Create" button and keep the database credentials safe. You'll need them later.

### Step 5: install Xboard

1.  **SSH to ur server:**  Log in to your server via SSH.
2.  **Navigate to ur site path:**  Go to your site's directory. It should look something like this: `/opt/1panel/apps/openresty/openresty/www/sites/xboard/index`.
3.  **Install git (if needed):**  If Git isn't installed on your system, use these commands:

    *   **Ubuntu/Debian:**

        ```bash
        apt update
        apt install -y git
        ```

    *   **CentOS/RHEL:**

        ```bash
        yum update
        yum install -y git
        ```

4.  **Clone the Xboard repository:** Execute the following command within your site's directory:

    ```bash
    git clone -b docker-compose --depth 1 https://github.com/cedar2025/Xboard ./
    ```

5.  **Run the installation command:** 

    ```bash
    docker compose run -it --rm xboard php artisan xboard:install
    ```

6.  **Enter ur credentials:** Follow the prompts and enter the database credentials you saved earlier. Choose to use the built-in Redis for installation.
7.  **Save ur credentials:**  This command will provide you with your backend URL and admin login credentials. Keep them in a safe place. 

### Step 6: start xboard

1.  **Start the engine:** In your site directory, run:

    ```bash
    docker compose up -d
    ```

🎉 **U'r live!** You should now be able to access your Xboard panel using the domain name you set up earlier.

## Updating xboard - stay fresh

1.  **SSH and navigate:** Log in to your server via SSH and go to your Xboard site directory. 
2.  **Update, pull, up:** Run these commands:

    ```bash
    docker compose down xboard
    docker compose pull 
    docker compose up -d
    ```

🎉 **That's a wrap!**  You've successfully updated Xboard. Keep crushin' it!

## Keep in mind

*   **Webman restarts:** Any code changes you make after enabling Webman will require a restart for them to take effect.
