<?php

	namespace Deliverist\Syncer\Bridges;

	use CzProject\Logger\ILogger;
	use Deliverist\Syncer\StaticClassException;
	use Deployment\Server;
	use Deployment\Deployer;


	class FtpDeployerFactory
	{
		public function __construct()
		{
			throw new StaticClassException('This is static class.');
		}


		/**
		 * @param  string
		 * @param  ILogger
		 * @param  Server
		 * @return Deployer
		 */
		public static function create($directory, ILogger $logger, Server $server)
		{
			$deployer = new Deployer($server, $directory, new DeploymentLogger($logger));
			$deployer->testMode = FALSE;
			$deployer->allowDelete = TRUE;
			$deployer->preprocessMasks = array();
			return $deployer;
		}
	}
