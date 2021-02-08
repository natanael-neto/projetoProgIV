<?php

use Doctrine\Common\ClassLoader,
	Doctrine\ORM\Configuration,
	Doctrine\ORM\EntityManager,
	Doctrine\Common\Cache\ArrayCache,
	Doctrine\DBAL\Logging\EchoSQLLogger;

class Doctrine
{
	public $em = null;

	public static $ems = null;

	public function __construct()
	{
		// load database configuration from CodeIgniter
		require APPPATH . 'config/database.php';

		// Set up class loading. You could use different autoloaders, provided by your favorite framework,
		// if you want to.
		require_once APPPATH . 'libraries/Doctrine/Common/ClassLoader.php';

		$doctrineClassLoader = new ClassLoader('Doctrine',  APPPATH . 'libraries');
		$doctrineClassLoader->register();
		$entitiesClassLoader = new ClassLoader('models', rtrim(APPPATH, "/"));
		$entitiesClassLoader->register();
		$proxiesClassLoader = new ClassLoader('Proxies', APPPATH . 'models/proxies');
		$proxiesClassLoader->register();
		$classLoader = new ClassLoader('DoctrineExtensions', APPPATH . 'libraries/Doctrine');
		$classLoader->register();

		// Set up caches
		$config = new Configuration;
		$cache = new ArrayCache;
		$config->setMetadataCacheImpl($cache);
		$driverImpl = $config->newDefaultAnnotationDriver(array(APPPATH . 'models/entidades'));
		$config->setMetadataDriverImpl($driverImpl);
		$config->setQueryCacheImpl($cache);

		// Proxy configuration
		$config->setProxyDir(APPPATH . '/models/proxies');
		$config->setProxyNamespace('Proxies');

		// Set up logger
		//$logger = new EchoSQLLogger;
		//$config->setSQLLogger($logger);

		$config->setAutoGenerateProxyClasses(TRUE);
		$config->addCustomStringFunction('REGEXP', 'DoctrineExtensions\Query\Mysql\Regexp');

		// Database connection information
		$connectionOptions = array(
			'driver' =>   'pdo_mysql',
			'user' =>     $db['default']['username'],
			'password' => $db['default']['password'],
			'host' =>     $db['default']['hostname'],
			'dbname' =>   $db['default']['database'],
			'charset' =>  $db['default']['char_set'],
			'driverOptions' => array(1002 => 'SET NAMES utf8')
		);

		// Create EntityManager
		$this->em = EntityManager::create($connectionOptions, $config);
		$conn = $this->em->getConnection();
		$conn->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
		Doctrine::$ems = $this->em;
	}
}
