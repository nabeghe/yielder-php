<?php namespace Nabeghe\Yielder;

/**
 * An alternative for php yield!
 */
class Yielder
{
    /**
     * The key where the last received index is stored so that it can continue from there the next time.
     */
    public const KEY = '__';

    /**
     * The index value when reaching the end of the array.
     */
    public const NONE_INDEX = -1;

    /**
     * Returns the next index value with each call.
     * @param  array  $data  The array.
     * @param  mixed  $index  Optional. The second output, which is the index of the returned value.
     * @param  string|null  $key  Optional. The key where the index is stored. Default {@see KEY}
     * @return mixed|null The new index value.
     */
    public static function value(&$data, &$index = null, ?string $key = null)
    {
        $index = $data[static::KEY] ?? -1;
        $index++;
        if (isset($data[$index])) {
            $key = $key ?? static::KEY;
            $data[$key] = $index;
            return $data[$index];
        }
        $index = static::NONE_INDEX;
        return null;
    }

    /**
     * It is similar to the {@see value()} method, but assumes that the array values are callable, invoking them and returning the result that returned from the callable.
     * @param  array  $data
     * @param  mixed  $index
     * @param  string|null  $key
     * @return mixed|null
     */
    public static function valueCall(&$data, &$index = null, ?string $key = null)
    {
        $value = static::value($data, $index, $key);
        if ($index == static::NONE_INDEX) {
            return $value;
        }
        if (is_callable($value)) {
            $value = $value();
        }
        return $value;
    }

    /**
     * Resets the yield state of the array, meaning it removes the last received index.
     * @param  array  $data  The array.
     * @param  string|null  $key
     * @return void
     */
    public static function reset(&$data, ?string $key = null): void
    {
        unset($data[$key ?? static::KEY]);
    }

    /**
     * Iterates through an array using the {@see value} method and resets the state at the end.
     * @param  array  $data  The array.
     * @param  callable  $callback  A callback that is executed for each item, with the first argument being the value and the second argument being the index.
     *                           Returning a value of `true` from the callback indicates to stop the iteration.
     * @param  string|null  $key
     * @return void
     */
    public static function each(&$data, $callback, ?string $key = null): void
    {
        if (!is_iterable($data)) {
            return;
        }
        $key = $key ?? static::KEY;

        while (true) {
            $value = static::value($data, $index, $key);
            if ($index < 0) {
                static::reset($data, $key);
                break;
            }
            if ($callback($value, $index)) {
                break;
            }
        }
    }

    /**
     * It is similar to the {@see each()} method, with the difference that, like the {@see valueCall} method, it also considers the possibility of being callable for each item.
     * @param $data
     * @param $callback
     * @param  string|null  $key
     * @return void
     */
    public static function eachCall(&$data, $callback, ?string $key = null)
    {
        static::each($data, function ($value, $index) use ($callback) {
            if (is_callable($value)) {
                $value = $value();
            }
            return $callback($value, $index);
        }, $key);
    }
}