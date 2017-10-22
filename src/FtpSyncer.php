<?php

	namespace Deliverist\Syncer;

	use CzProject\Events\Events;
	use CzProject\Logger\ILogger;


	class FtpSyncer implements ISyncer
	{
		/** @var Events */
		private $events;

		/** @var string */
		private $host;

		/** @var string|NULL */
		private $user;

		/** @var string|NULL */
		private $password;

		/** @var string|NULL */
		private $path;

		/** @var int|NULL */
		private $port;

		/** @var bool */
		private $passiveMode = TRUE;

		/** @var bool */
		private $ssl = TRUE;

		/** @var array|NULL */
		private $ignore;

		/** @var array|NULL */
		private $purge;

		/** @var string|NULL */
		private $deploymentFile;


		/**
		 * @param  string
		 * @param  string|NULL
		 * @param  string|NULL
		 * @param  string|NULL
		 */
		public function __construct($host, $user = NULL, $password = NULL, $path = NULL)
		{
			$this->events = Utils\EventsFactory::create();
			$this->host = $host;
			$this->user = $user;
			$this->password = $password;
			$this->path = $path;
		}


		/**
		 * @param  int|NULL
		 * @return self
		 */
		public function setPort($port)
		{
			$this->port = $port;
			return $this;
		}


		/**
		 * @return self
		 */
		public function disablePassiveMode()
		{
			$this->passiveMode = FALSE;
			return $this;
		}


		/**
		 * {@inheritDoc}
		 */
		public function disableSsl()
		{
			$this->ssl = FALSE;
			return $this;
		}


		/**
		 * {@inheritDoc}
		 */
		public function getLabel()
		{
			return $this->getUrl(TRUE);
		}


		/**
		 * {@inheritDoc}
		 */
		public function onAfterUpload($handler)
		{
			$this->events->addHandler(Utils\EventsFactory::AFTER_SYNC, $handler);
			return $this;
		}


		/**
		 * {@inheritDoc}
		 */
		public function setIgnore(array $ignore)
		{
			$this->ignore = $ignore;
			return $this;
		}


		/**
		 * {@inheritDoc}
		 */
		public function setPurge(array $purge)
		{
			$this->purge = $purge;
			return $this;
		}


		/**
		 * {@inheritDoc}
		 */
		public function setDeploymentFile($deploymentFile)
		{
			$this->deploymentFile = $deploymentFile;
			return $this;
		}


		/**
		 * {@inheritDoc}
		 */
		public function sync($dir, ILogger $logger)
		{
			$server = new \Deployment\FtpServer($this->getUrl(), $this->passiveMode);
			$deployer = Bridges\FtpDeployerFactory::create($dir, $logger, $server);

			if ($this->deploymentFile !== NULL) {
				$deployer->deploymentFile = $this->deploymentFile;
			}

			if ($this->ignore !== NULL) {
				$deployer->ignoreMasks = $this->ignore;
			}

			if ($this->purge !== NULL) {
				$deployer->toPurge = $this->purge;
			}

			$deployer->runAfter[] = function () {
				$this->events->fireEvent(Utils\EventsFactory::AFTER_SYNC);
			};

			$deployer->deploy();
		}


		/**
		 * @return string
		 */
		private function getUrl($anonymized = FALSE)
		{
			$url = $this->ssl ? 'ftps' : 'ftp';
			$url .= '://';

			if (isset($this->user)) {
				$url .= $anonymized ? '***' : rawurlencode($this->user);
			}

			if (isset($this->password)) {
				$url .= ':' . ($anonymized ? '***' : rawurlencode($this->password));
			}

			if (isset($this->user) || isset($this->password)) {
				$url .= '@';
			}

			$url .= $this->host;

			if (isset($this->port)) {
				$url .= ':' . $this->port;
			}

			$url .= '/';

			if ($this->path) {
				$url .= ltrim($this->path, '/');
			}

			return $url;
		}
	}
