<?php


namespace Crazymeeks\Contracts;


interface ConfigConnectionInterface
{


	/**
	 * Get connection's configuration
	 * 
	 * @return array
	 */
	public function getConfig();

	/**
	 * Get config driver
	 * 
	 * @return string
	 */
	public function getDriver();
}