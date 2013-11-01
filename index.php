<?php

//error_reporting(E_NOTICE);

require 'vendor/autoload.php';
require 'app/functions.php';

// Get database settings 

$config = parse_ini_file("config/app.ini");

$settings = array(
    'driver' => 'mysql',
    'host' => $config['database.host'],
    'database' => $config['database.dbname'],
    'username' => $config['database.username'],
    'password' => $config['database.password'],
    'collation' => 'utf8_general_ci',
    'charset' => "utf8",
    'prefix' => '',
    'port' => 3306,
);


// Bootstrap Eloquent ORM
Capsule\Database\Connection::make('default', $settings, true);


// Set up Sentry User Maanager 

class_alias('Cartalyst\Sentry\Facades\Native\Sentry', 'Sentry');

$dsn = "mysql:dbname={$config['database.dbname']};host={$config['database.host']}";
$user = $config['database.username'];
$password = $config['database.password'];
Sentry::setupDatabaseResolver(new PDO($dsn, $user, $password));

/**
 * @todo add log settings  
 * @todo log api calls and response
 */
$app = new \Slim\Slim(array(
            'mode' => 'development',
            'debug' => true,
        ));


// Only invoked if mode is "production"
$app->configureMode('production', function () use ($app) {
            $app->config(array(
                'log.enable' => true,
                'debug' => false
            ));
        });

// Only invoked if mode is "development"
$app->configureMode('development', function () use ($app) {
            $app->config(array(
                'log.enable' => false,
                'debug' => true
            ));
        });

require_once 'app/routes/users.php';
require_once 'app/routes/locations.php';
require_once 'app/routes/bloodgroups.php';
require_once 'app/routes/hospitals.php';

$app->run();

?>
