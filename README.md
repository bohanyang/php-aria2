# A Simple Aria2 JSON-RPC Client For PHP

```shell script
composer require bohan/aria2
```

This library uses [symfony/http-client](https://github.com/symfony/http-client).

An exception will be thrown if an error occurred.

```php
<?php

declare(strict_types=1);

use Bohan\Aria2\Aria2;

$aria2 = new Aria2('http://localhost:6800/jsonrpc', 'rpc-secret');

$aria2->request('addUri', [
    ['https://example.com/'],
    ['out' => 'index.html']
]);

// or use the "__call" magic method
$aria2->addUri(
    ['https://example.com/'],
    ['out' => 'index.html']
);
```
