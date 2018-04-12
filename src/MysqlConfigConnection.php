<?php

namespace Crazymeeks;

use Crazymeeks\Contracts\ConfigConnectionInterface;

class MysqlConfigConnection implements ConfigConnectionInterface
{

	/**
	 * Get connection's configuration
	 * 
	 * @return array
	 */
	public function getConfig() : array
	{
		global $wpdb;

		$config = [
			'driver' => $this->getDriver(),
			'host'   => DB_HOST,
			'database' => getenv('DB_NAME') ? getenv('DB_NAME') : DB_NAME,
			'username' => DB_USER,
			'password' => DB_PASSWORD,
			'charset'  => DB_CHARSET,
			'collation' => DB_COLLATE ? DB_COLLATE : DB_CHARSET . '_unicode_ci',
			'prefix'    => $wpdb->prefix,
		];

		return $config;
	}

	/**
	 * Get config driver
	 * 
	 * @return string
	 */
	public function getDriver() : string
	{
		return 'mysql';
	}
	
}