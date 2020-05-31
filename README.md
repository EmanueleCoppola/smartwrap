## EmanueleCoppola/smartwrap
I wrote this package because I faced the same problem as in [this](https://stackoverflow.com/q/9815040/5280969) StackOverflow question.

#### Sample input/output
```php
$output = wordwrap('hello! heeeeeeeeeeeeeeereisaverylongword', 20, "\n", true);
// The output will be ↓
$output == "hello!\nheeeeeeeeeeeeeeereis\naverylongword";

$output = smartwrap('hello! heeeeeeeeeeeeeeereisaverylongword', 20, "\n", true);
// The output will be ↓
$output == "hello! heeeeeeeeeeee\neeereisaverylongword";
```

#### Usage
```php
use EmanueleCoppola\SmartWrap\SmartWrap;

$sw = new SmartWrap();

$wrapped = $sw->smartwrap('hello! heeeeeeeeeeeeeeereisaverylongword', 20, "\n", true);

print($wrapped);

// Or by using the global function
$wrapped = smartwrap('hello! heeeeeeeeeeeeeeereisaverylongword', 20, "\n", true);

print($wrapped);
```