# Yielder for PHP

> A similar alternative to yield in PHP for reading values from arrays, with a touch of zest.

Retrieve the value of the next index in an array whenever you want,
or define the values as callables so that their contents can be returned when needed.
This is likely just the beginning or the end of this package library!

## 🫡 Usage

### 🚀 Installation

You can install the package via composer:

```bash
composer require nabeghe/yielder
```

### Example 1: Value

Each time, the array returns the value of the next index.

```php
use Nabeghe\Yielder\Yielder;

$data = [
    'value 1',
    'value 2',
    'value 3',
];

$value = Yielder::value($data, $index);
echo "Index $index: $value\n"; // Index 0: value 1

$value = Yielder::value($data, $index);
echo "Index $index: $value\n"; // Index 1: value 2

$value = Yielder::value($data, $index);
echo "Index $index: $value\n"; // Index 2: value 3

$value = Yielder::value($data, $index);
echo "Index $index: $value\n"; // Index -1: null

Yielder::reset($data);

$value = Yielder::value($data, $index);
echo "Index $index: $value\n"; // Index 0: value 1
```

### Example 2: Each

Iterating through the array using the `value` method.

```php
$data = [
    'value 1',
    'value 2',
    'value 3',
];

Yielder::each($data, function ($value, $index) {
    echo "Index $index: $value\n";
    // return true if you want to break.
});
```

### Example 3: Value Call

Imagine you have an array that contains data,
but instead of placing the data directly in each index,
you can define them as callables.
This way, they can be executed when needed, returning their values.

This is something like lazy loading.

```php
use Nabeghe\Yielder\Yielder;

$data = [
    function () {
        return 'Value 1';
    },
    function () {
        return 'Value 2';
    },
    function () {
        return 'Value 3';
    },
];

$value = Yielder::valueCall($data, $index);
echo "Index $index: $value\n"; // Index 0: value 1

$value = Yielder::valueCall($data, $index);
echo "Index $index: $value\n"; // Index 1: value 2

$value = Yielder::valueCall($data, $index);
echo "Index $index: $value\n"; // Index 2: value 3

$value = Yielder::valueCall($data, $index);
echo "Index $index: $value\n"; // Index -1: null

Yielder::reset($data);

$value = Yielder::valueCall($data, $index);
echo "Index $index: $value\n"; // Index 0: value 1
```

### Example 4: Each Call

Iterating through the array, but exactly like `valueCall`.

```php
use Nabeghe\Yielder\Yielder;

$data = [
    function () {
        return 'Value 1';
    },
    function () {
        return 'Value 2';
    },
    function () {
        return 'Value 3';
    },
];

Yielder::eachCall($data, function ($value, $index) {
    echo "Index $index: $value\n";
    // return true if you want to break.
});
```

## 📖 License

Copyright (c) 2024 Hadi Akbarzadeh

Licensed under the MIT license, see [LICENSE.md](LICENSE.md) for details.