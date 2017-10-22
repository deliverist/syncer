<?php

	namespace Deliverist\Syncer\Utils;

	use CzProject\Events\Events;
	use Deliverist\Syncer\StaticClassException;


	class EventsFactory
	{
		const AFTER_SYNC = 'after-sync';


		public function __construct()
		{
			throw new StaticClassException('This is static class.');
		}


		/**
		 * @return Events
		 */
		public static function create()
		{
			return new Events(array(
				self::AFTER_SYNC,
			));
		}
	}
