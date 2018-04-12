<?php

namespace Crazymeeks\Exceptions;

class UnsupportedDBDriverException extends \Exception
{


	public function __construct($message, $statusCode = 500)
	{
		parent::__construct($message, $statusCode);
	}
}