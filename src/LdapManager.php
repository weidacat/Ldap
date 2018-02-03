<?php namespace Weidacat\Ldap;

use Illuminate\Support\Manager;

class LdapManager {

	/**
	 * The config Array
	 *
	 * @var array
	 */
	protected $config;

	/**
	 * The active connection instances.
	 *
	 * @var Directory
	 */
	protected $connection;



    function __construct(Array $config)
    {
        $this->config = $config;
    }

	/**
	 * Get a Ldap connection instance.
	 *
	 * @return Weidacat\Ldap\Directory
	 */
	public function connection()
	{
		if ( ! isset($this->connection))
		{
			$this->connection = $this->createConnection();
		}

		return $this->connection;
	}

	/**
	 * Create the given connection.
	 *
	 * @return Weidacat\Ldap\Directory
	 */
	protected function createConnection()
	{
		$connection = new Directory($this->config, new Connection($this->config));

		return $connection;
	}

	/**
	 * Dynamically pass methods to the default connection.
	 *
	 * @param  string  $method
	 * @param  array   $parameters
	 * @return mixed
	 */
	public function __call($method, $parameters)
	{
		return call_user_func_array(array($this->connection(), 'query'), array($method, $parameters));
	}

}
