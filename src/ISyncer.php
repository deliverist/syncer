<?php

	namespace Deliverist\Syncer;

	use CzProject\Logger\ILogger;


	interface ISyncer
	{
		/**
		 * @return string
		 */
		function getLabel();


		/**
		 * @param  callback
		 * @return static
		 */
		function onAfterUpload($handler);


		/**
		 * @param  string[]
		 * @return static
		 */
		function setIgnore(array $ignore);


		/**
		 * @param  string[]
		 * @return static
		 */
		function setPurge(array $purge);


		/**
		 * @param  string
		 * @return static
		 */
		function setDeploymentFile($deploymentFile);


		/**
		 * @param  string
		 * @param  ILogger
		 * @return void
		 */
		function sync($dir, ILogger $logger);
	}
