# Flow PHP library

The Flow PHP library provides convenient access to resources on the Nexagon Flow API for applications written in PHP.

## Requirements
PHP 7.2 and later

## Composer
You can install flow-php with composer. Run the following command:
```bash
composer require nexagon/flow-php
```
To use the library, use the autoloader from composer:
```php
require_once('vendor/autoload.php');
```

## Manual installation
If you do not wish to use composer, you can download the code from this repo.
Then, to use the library, simply include the `init.php` file.
```php
require_once('/path/to/flow-php/init.php');
```

## Dependencies
The sdk uses the following dependencies.
- `guzzlehttp/guzzle`
- `json` 

If you are using composer, everything should work out of the box.
Otherwise, make sure these extensions are available.

## Getting started
Simple usage of the library:
```php
$flow = new Flow\FlowClient("api-key-goes-here");
[$customer,] = $flow->customers->create([
    "name" => "Test customer",
    "email" => "some@email.test",
    "reference_identifier" => "some reference",
    "locations" => [
        "name" => "Headquarters",
        "phone" => "004588888888",
        "address_line_1" => "Test street 2",
        "postal_code" => "8000",        
        "city" => "Aarhus",
        "country" => "DK",
    ], 
]);

[$order,] = $flow->orders->create([
    "customer_group" => $customer->id,
]);
echo $order;
```

### Changing the API-endpoint
You might need to change the API-endpoint, if you are testing, or working on a staging environment.
```php

$flow = new Flow\FlowClient("api-key-goes-here", "http://localhost:8000/");
// or
$flow->setApiEndpoint("http://sometest-endpoint.test");
```
Remember to append a slash `/` at the end. Otherwise, requests may fail.

### Uploading files and adding multiple file-versions
Whenever you need to add a file to flow, it must first be created and uploaded before any resources can consume it.
Use the following as a reference for uploading files to flow

```php
$flow = new Flow\FlowClient("api-key-goes-here");
$stream = fopen("path/to/file.png", "r");
$mimetype = mime_content_type("path/to/file.png");
[$file,] = $flow->files->createAndUpload($stream, "file.png", $mimetype);

// Consume the file on order lines or other resources
$order_line_data = [
    "files" => [$file->id],
    ... // Any other required order line data - see documentation
];
[$order,] = $flow->orders->create([
    "order_lines" => [$order_line_data]
]);
```

If one needs to update a file, one must add a new version:
```php
$flow = new Flow\FlowClient("api-key-goes-here");
$stream = ...;
$name = ...;
$mimetype = ...;
[$file, ] = $flow->files->addFileVersion($stream, $name, $mimetype);

// You have access to all version
foreach ($file->versions as &$version) {
    if ($version->latest) {
        print_r("Im the latest version ($version->last_modified)! Download me here: $version->url");
    }
}
```

## Documentation
See the [Nexagon Flow documentation](https://docs.nexagon.dk).

## Accessing request
You can access the `Gruzzle\Request` directly:
```php
$flow = new Flow\FlowClient("api-key-goes-here");
[$order, $request] = $flow->orders->retrieve(1);

echo $request->getStatusCode();
```

Note that all requests with a statuscode >= 300 will fail and throw a `FlowException`.

## License

MIT License

Copyright (c) 2020 Nexagon IVS

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.