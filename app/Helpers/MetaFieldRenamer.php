<?php


namespace App\Helpers;


use Illuminate\Support\Str;

class MetaFieldRenamer {

    /**
     * @param array $fields
     * @return array
     */
    public static function arrayKeyFromKebapToSnake(array $fields): array
    {
        $snakeArray = [];
        collect($fields)->each(function ($field, $key) use (&$snakeArray) {
            $newKey = $key;
            if (Str::contains($key, '-'))
            {
                $newKey = Str::snake(Str::camel($key));
            }
            $snakeArray[$newKey] = $field;
        });

        return $snakeArray;
    }

}
