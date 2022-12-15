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

Here is simple example of evaluating math expression
```php
<?php

$parser = new \Math\Parser();
$expression = '1 + 2 * 3 * ( 7 * 8 ) - ( 45 - 10 )';
$result = $parser->evaluate($expression);

echo $result; // 302

$expression = '-2+-2*13*(7*8)-(415-0.1)';
$result = $parser->evaluate($expression);

echo $result; // -1872.90



```
## TODO
  - Add additional translation strategy

## License

MIT, see LICENSE.
