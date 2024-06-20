<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Encryption\Encrypter;
use App\Models\User;
use App\Utils\Helper;
use Illuminate\Support\Env;
use function Laravel\Prompts\confirm;
use function Laravel\Prompts\text;
use function Laravel\Prompts\note;

class XboardInstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xboard:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Xboard initialization and installation';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            $isDocker = env('docker', false);
            $this->info("__    __ ____                      _  ");
            $this->info("\ \  / /| __ )  ___   __ _ _ __ __| | ");
            $this->info(" \ \/ / | __ \ / _ \ / _` | '__/ _` | ");
            $this->info(" / /\ \ | |_) | (_) | (_| | | | (_| | ");
            $this->info("/_/  \_\|____/ \___/ \__,_|_|  \__,_| ");
            if (
                (\File::exists(base_path() . '/.env') && $this->getEnvValue('INSTALLED'))
                || (env('INSTALLED', false) && $isDocker)
            ) {
                $securePath = admin_setting('secure_path', admin_setting('frontend_admin_path', hash('crc32b', config('app.key'))));
                $this->info("Visit http(s)://your-site/{$securePath} to access the admin panel, you can change your password in the user center.");
                $this->warn("To reinstall, please empty the contents of the .env file in the directory (do not delete this file for Docker installations)");
                $this->warn("Shortcut command to empty .env:");
                note('rm .env && touch .env');
                return;
            }
            if (is_dir(base_path() . '/.env')) {
                $this->error('😔: Installation failed. For Docker environment installation, please keep the .env file empty.');
                return;
            }
            // Choose whether to use Sqlite
            if (confirm(label: 'Whether to enable Sqlite (no additional installation required) instead of Mysql', default: false, yes: 'Enable', no: 'Disable')) {
                $sqliteFile = '.docker/.data/database.sqlite';
                if (!file_exists(base_path($sqliteFile))) {
                    // Create an empty file
                    if (!touch(base_path($sqliteFile))) {
                        $this->info("sqlite created successfully: $sqliteFile");
                    }
                }
                $envConfig = [
                    'DB_CONNECTION' => 'sqlite',
                    'DB_DATABASE' => $sqliteFile,
                    'DB_HOST' => '',
                    'DB_USERNAME' => '',
                    'DB_PASSWORD' => '',
                ];
                try {
                    \Config::set("database.default", 'sqlite');
                    \Config::set("database.connections.sqlite.database", base_path($envConfig['DB_DATABASE']));
                    \DB::purge('sqlite');
                    \DB::connection('sqlite')->getPdo();
                    if (!blank(\DB::connection('sqlite')->getPdo()->query("SELECT name FROM sqlite_master WHERE type='table'")->fetchAll(\PDO::FETCH_COLUMN))) {
                        if (confirm(label: 'Data already exists in the database. Do you want to clear the database to install new data?', default: false, yes: 'Clear', no: 'Exit installation')) {
                            $this->info('Clearing the database, please wait...');
                            $this->call('db:wipe', ['--force' => true]);
                            $this->info('Database cleared successfully.');
                        } else {
                            return;
                        }
                    }
                } catch (\Exception $e) {
                    // Connection failed, output error message
                    $this->error("Database connection failed: " . $e->getMessage());
                }
            } else {
                $isMysqlValid = false;
                while (!$isMysqlValid) {
                    $envConfig = [
                        'DB_CONNECTION' => 'mysql',
                        'DB_HOST' => text(label: "Please enter the database address", default: '127.0.0.1', required: true),
                        'DB_PORT' => text(label: 'Please enter the database port', default: '3306', required: true),
                        'DB_DATABASE' => text(label: 'Please enter the database name', default: 'xboard', required: true),
                        'DB_USERNAME' => text(label: 'Please enter the database username', default: 'root', required: true),
                        'DB_PASSWORD' => text(label: 'Please enter the database password', required: false),
                    ];
                    try {
                        \Config::set("database.default", 'mysql');
                        \Config::set("database.connections.mysql.host", $envConfig['DB_HOST']);
                        \Config::set("database.connections.mysql.port", $envConfig['DB_PORT']);
                        \Config::set("database.connections.mysql.database", $envConfig['DB_DATABASE']);
                        \Config::set("database.connections.mysql.username", $envConfig['DB_USERNAME']);
                        \Config::set("database.connections.mysql.password", $envConfig['DB_PASSWORD']);
                        \DB::purge('mysql');
                        \DB::connection('mysql')->getPdo();
                        $isMysqlValid = true;
                        if (!blank(\DB::connection('mysql')->select('SHOW TABLES'))) {
                            if (confirm(label: 'Data already exists in the database. Do you want to clear the database to install new data?', default: false, yes: 'Clear', no: 'Do not clear')) {
                                $this->info('Clearing the database, please wait...');
                                $this->call('db:wipe', ['--force' => true]);
                                $this->info('Database cleared successfully.');
                            } else {
                                $isMysqlValid = false;
                            }
                        }
                    } catch (\Exception $e) {
                        // Connection failed, output error message
                        $this->error("Database connection failed: " . $e->getMessage());
                        $this->info("Please re-enter the database configuration");
                    }
                }
            }
            $envConfig['APP_KEY'] = 'base64:' . base64_encode(Encrypter::generateKey('AES-256-CBC'));
            $envConfig['INSTALLED'] = true;
            $isReidsValid = false;
            while (!$isReidsValid) {
                // Determine if it is a Docker environment
                if ($isDocker == 'true' && (confirm(label: 'Whether to enable Docker built-in Redis', default: true, yes: 'Enable', no: 'Disable'))) {
                    $envConfig['REDIS_HOST'] = '/run/redis-socket/redis.sock';
                    $envConfig['REDIS_PORT'] = 0;
                    $envConfig['REDIS_PASSWORD'] = null;
                } else {
                    $envConfig['REDIS_HOST'] = text(label: 'Please enter the Redis address', default: '127.0.0.1', required: true);
                    $envConfig['REDIS_PORT'] = text(label: 'Please enter the Redis port', default: '6379', required: true);
                    $envConfig['REDIS_PASSWORD'] = text(label: 'Please enter the Redis password (default: null)', default: '');
                }
                $redisConfig = [
                    'client' => 'phpredis',
                    'default' => [
                        'host' => $envConfig['REDIS_HOST'],
                        'password' => $envConfig['REDIS_PASSWORD'],
                        'port' => $envConfig['REDIS_PORT'],
                        'database' => 0,
                    ],
                ];
                try {
                    $redis = new \Illuminate\Redis\RedisManager(app(), 'phpredis', $redisConfig);
                    $redis->ping();
                    $isReidsValid = true;
                } catch (\Exception $e) {
                    // Connection failed, output error message
                    $this->error("Redis connection failed: " . $e->getMessage());
                    $this->info("Please re-enter the REDIS configuration");
                }
            }

            if (!copy(base_path() . '/.env.example', base_path() . '/.env')) {
                abort(500, 'Failed to copy environment file, please check directory permissions');
            }
            ;
            $email = text(
                label: 'Please enter the administrator account',
                default: 'admin@demo.com',
                required: true,
                validate: fn(string $email): ?string => match (true) {
                    !filter_var($email, FILTER_VALIDATE_EMAIL) => 'Please enter a valid email address.',
                    default => null,
                }
            );
            $password = Helper::guid(false);
            $this->saveToEnv($envConfig);

            $this->call('config:cache');
            \Artisan::call('cache:clear');
            $this->info('Importing database, please wait...');
            \Artisan::call("migrate", ['--force' => true]);
            $this->info(\Artisan::output());
            $this->info('Database import complete.');
            $this->info('Start registering administrator account');
            if (!$this->registerAdmin($email, $password)) {
                abort(500, 'Administrator account registration failed, please try again');
            }
            $this->info('🎉: Everything is ready');
            $this->info("Administrator email: {$email}");
            $this->info("Administrator password: {$password}");

            $defaultSecurePath = hash('crc32b', config('app.key'));
            $this->info("Visit http(s)://your-site/{$defaultSecurePath} to access the admin panel, you can change your password in the user center.");
        } catch (\Exception $e) {
            $this->error($e);
        }
    }

    public function registerAdmin($email, $password)
    {
        $user = new User();
        $user->email = $email;
        if (strlen($password) < 8) {
            abort(500, 'The administrator password must be at least 8 characters long');
        }
        $user->password = password_hash($password, PASSWORD_DEFAULT);
        $user->uuid = Helper::guid(true);
        $user->token = Helper::guid();
        $user->is_admin = 1;
        return $user->save();
    }

    private function set_env_var($key, $value)
    {
        $value = !strpos($value, ' ') ? $value : '"' . $value . '"';
        $key = strtoupper($key);

        $envPath = app()->environmentFilePath();
        $contents = file_get_contents($envPath);

        if (preg_match("/^{$key}=[^\r\n]*/m", $contents, $matches)) {
            $contents = str_replace($matches[0], "{$key}={$value}", $contents);
        } else {
            $contents .= "\n{$key}={$value}\n";
        }

        return file_put_contents($envPath, $contents) !== false;
    }

    private function saveToEnv($data = [])
    {
        foreach ($data as $key => $value) {
            self::set_env_var($key, $value);
        }
        return true;
    }

    function getEnvValue($key, $default = null)
    {
        $dotenv = \Dotenv\Dotenv::createImmutable(base_path());
        $dotenv->load();

        return Env::get($key, $default);
    }
}
