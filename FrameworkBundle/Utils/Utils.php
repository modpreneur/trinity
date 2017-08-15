<?php
/**
 * Created by PhpStorm.
 * User: fisa
 * Date: 10/21/16
 * Time: 3:03 PM
 */

namespace Trinity\FrameworkBundle\Utils;

/**
 * Class Utils
 * @package Trinity\FrameworkBundle\Utils
 */
class Utils
{
    /**
     * Merge deeply two or more arrays into one.
     * Ordering is from least significant (defaults) to most significant values (our custom behaviour)
     *
     * @param \array[] ...$arrays unlimited arrays to be merged
     *
     * @return array
     */
    public static function mergeArraysDeep(array ...$arrays): array
    {
        $result = [];

        foreach ($arrays as $arr) {
            foreach ($arr as $key => $value) {
                if (\array_key_exists($key, $result) && \is_array($value)) {
                    $result[$key] = self::mergeArraysDeep($result[$key], $value);
                } else {
                    $result[$key] = $value;
                }
            }
        }

        return $result;
    }
}
