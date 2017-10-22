<?php

	namespace Deliverist\Syncer\Bridges;

	use CzProject\Logger\ILogger;


	class DeploymentLogger extends \Deployment\Logger
	{
		/** @var ILogger */
		private $logger;


		public function __construct(ILogger $logger)
		{
			$this->logger = $logger;
		}


		public function log($s, $color = NULL, $shorten = TRUE)
		{
			$level = ILogger::INFO;

			if ($color === 'red') {
				$level = ILogger::ERROR;

			} elseif ($color === 'green' || $color === 'lime') {
				$level = ILogger::SUCCESS;

			} elseif ($color === 'gray') {
				$level = ILogger::DEBUG;
			}

			$this->logger->log($s, $level);
		}
	}
