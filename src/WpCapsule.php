<?php

namespace Crazymeeks;

use Illuminate\Database\Capsule\Manager as Capsule;
use Crazymeeks\Contracts\ConfigConnectionInterface;
use Illuminate\Database\Schema\Grammars\MySqlGrammar;
use Illuminate\Database\Schema\Grammars\SQLiteGrammar;
use Crazymeeks\Exceptions\UnsupportedDBDriverException;

class WpCapsule
{

	/**
	 * The available config connection
	 * 
	 * @var array
	 */
	private $configConnection = [];

	private $allowedDrivers = ['mysql', 'sqlite'];

	/**
	 * The DB Driver
	 * 
	 * @var string
	 */
	protected $dbdriver = 'mysql';


	/**
	 * Establish connection
	 * 
	 * @return \Illuminate\Database\Capsule\Manager
	 */
	public function createConnection() : Capsule
	{	
		
		$capsule = new Capsule();

		$capsule->addConnection($this->getConfigConnection());

		$capsule->setAsGlobal();

		$capsule->bootEloquent();

		// we need to set schema grammar
		// for so that this package
		// can be use together with migration

		$this->setSchemaGrammar($capsule);

		return $capsule;

	}

	/**
	 * Set schema grammar
	 * 
	 * @param \Illuminate\Database\Capsule\Manager $capsule
	 *
	 * @return  void
	 */
	private function setSchemaGrammar(Capsule $capsule)
	{
		$grammar = $this->getGrammar();

		$capsule->getConnection()->setSchemaGrammar($grammar);
	}

	/**
	 * Get grammar
	 * 
	 * @return mixed
	 */
	private function getGrammar()
	{

		if ($this->dbdriver == 'mysql') {

			return new MySqlGrammar();
		}

		return new SQLiteGrammar();

	}

	/**
	 * Set config connection
	 * 
	 * @param \Crazymeeks\Contracts\ConfigConnectionInterface $connection
	 *
	 * @return  $this
	 */
	public function setConfigConnection(ConfigConnectionInterface $connection)
	{
		$this->addConnection($connection->getConfig());

		$this->setDbDriver($connection->getDriver());

		return $this;
	}

	/**
	 * Set DB Driver
	 * 
	 * @param string $dbdriver
	 */
	public function setDbDriver($dbdriver)
	{
		$this->dbdriver = $dbdriver;
	}

	/**
	 * Add connection
	 * 
	 * @param array $config
	 *
	 * @return  void
	 */
	private function addConnection(array $config)
	{
		$this->configConnection = $config;
	}

	/**
	 * Get Connection instance
	 * 
	 * @return array
	 */
	public function getConfigConnection() : array
	{
		if ( count($this->configConnection ) > 0) {
			return $this->configConnection;
		}

		// set config connection if empty
		$this->setConfigConnection($this->createFromFactory());

		return $this->configConnection;
	}

	/**
	 * Factory
	 * 
	 * @return \Crazymeeks\Contracts\ConfigConnectionInterface
	 */
	private function createFromFactory()
	{

		$driver = $this->checkConfigConnection();

		return new $driver;

	}

	/**
	 * Check defined connection if supported
	 * 
	 * @return string
	 *
	 * @throws  Crazymeeks\Exceptions\UnsupportedDBDriverException
	 */
	private function checkConfigConnection() : string
	{
		if ( !in_array($this->dbdriver, $this->allowedDrivers) ) {
			throw new UnsupportedDBDriverException('Unsupported database driver');
		}

		return __NAMESPACE__ . '\\' . ucfirst(strtolower($this->dbdriver)) . 'ConfigConnection';
	}

}