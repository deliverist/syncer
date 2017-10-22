
# Deliverist\Syncer

## Installation

[Download a latest package](https://github.com/deliverist/syncer/releases) or use [Composer](http://getcomposer.org/):

```
composer require deliverist/syncer
```

Deliverist\Syncer requires PHP 5.6.0 or later.


## Usage

``` php
$syncer = new Deliverist\Syncer\FtpSyncer($host, $user, $password, $path);
$logger = new CzProject\Logger\OutputLogger;
$syncer->sync(__DIR__ . '/directory/', $logger);
```

------------------------------

License: [New BSD License](license.md)
<br>Author: Jan Pecha, https://www.janpecha.cz/
