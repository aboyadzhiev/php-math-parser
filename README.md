# Math

Simple mathematical expression parser and calculator.

## Install
The recommended way to install Math is [through composer](http://getcomposer.org).

```JSON
{
    "require": {
        "aboyadzhiev/php-math-parser": "dev-master"
    }
}
```
## Usage

Here is an simple example of evaluation of mathematical expression
```php
<?php

$parser = new \Math\Parser();
$expression = '1 + 2 * 3 * ( 7 * 8 ) - ( 45 - 10 )';
$result = $parser->evaluate($expression);

echo $result; //302

```
## TODO
  - Add unit tests.
  - Add additional strategy for translation from infix to reverse polish notation

## License

MIT, see LICENSE.
