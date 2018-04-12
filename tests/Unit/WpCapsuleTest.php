<?php

use PHPUnit\Framework\TestCase;

use Crazymeeks\WpCapsule;
use Crazymeeks\MysqlConfigConnection;
use Crazymeeks\SqliteConfigConnection;
use Illuminate\Database\Schema\Builder;
use Illuminate\Database\Schema\Blueprint;

class WpCapsuleTest extends TestCase
{
	
	/**
	 * @test
	 */
	public function it_can_set_connection_to_mysql()
	{
		$wpcapsule = new WpCapsule();

		$wpcapsule->setConfigConnection(new MysqlConfigConnection());

		$this->assertEquals('mysql', $wpcapsule->getConfigConnection()['driver']);

		$connection = $wpcapsule->createConnection();

		$this->assertEquals(get_class($connection->getConnection()), 'Illuminate\Database\MySqlConnection');
		
	}


	/**
	 * @test
	 */
	public function it_can_set_connection_to_sqlite()
	{
		$wpcapsule = new WpCapsule();

		$wpcapsule->setConfigConnection(new SqliteConfigConnection());

		$this->assertEquals('sqlite', $wpcapsule->getConfigConnection()['driver']);

		$connection = $wpcapsule->createConnection();

		$this->assertEquals(get_class($connection->getConnection()), 'Illuminate\Database\SQLiteConnection');
		
	}

	/**
	 * Just for documentation for creating migration
	 *
	 */
	public function it_can_create_table()
	{
		$wpcapsule = new WpCapsule();

		$wpcapsule->setConfigConnection(new MysqlConfigConnection());

		$connection = $wpcapsule->createConnection();

		$con = $connection->getConnection();

		$builder = new Builder($con);

		$builder->create('awesomeness', function(Blueprint $table){
			$table->increments('id');
            $table->string('title');
            $table->timestamps();
		});

		$this->assertEquals(get_class($connection->getConnection()), 'Illuminate\Database\MySqlConnection');
		
	}

}