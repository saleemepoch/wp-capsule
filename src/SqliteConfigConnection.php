<?php

namespace Crazymeeks;

use Crazymeeks\Contracts\ConfigConnectionInterface;

class SqliteConfigConnection implements ConfigConnectionInterface
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
			'database' => ':memory:',
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
		return 'sqlite';
	}
	
}