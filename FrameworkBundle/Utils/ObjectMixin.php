<?php


namespace Trinity\FrameworkBundle\Utils;


use Trinity\FrameworkBundle\Exception\MemberAccessException;


/**
 * Class ObjectMixin
 * @package Trinity\FrameworkBundle\Utils
 */
class ObjectMixin
{

    /**
     *
     * @param object $object
     * @param string $name
     * @return mixed
     * @throws MemberAccessException
     */
    public static function get($object, $name)
    {

        $class = get_class($object);
        $uname = ucfirst($name);
        $pname = substr($name, 0, strpos($name, '('));

        $strArgs = substr($name, strpos($name, '(') + 1, strlen($name) - strpos($name, '(') - 2);
        if (strlen($strArgs) > 0) {
            $args = (array_map('trim', explode(',', $strArgs)));
        } else {
            $args = null;
        }

        $name = $pname ? $pname : $name;
        $methods = self::getMethods([], $class);
        $properties = self::getProperties($class);

        if ($name === '') {
            throw new MemberAccessException("Cannot read a class '$class' property without name.");
        } elseif (isset($methods[$m = 'get'.$uname]) || isset($methods[$m = 'is'.$uname])) { // property getter
            if ($methods[$m] === 0) {
                $methods[$m] = (new \ReflectionMethod($class, $m))->returnsReference();
            }
            if ($methods[$m] === true) {
                return $object->$m();
            } else {
                return $object->$m();
            }
        } elseif (isset($methods[$name])) { // public method as closure getter

            $countOfParams = (new \ReflectionMethod($class, $name))->getNumberOfRequiredParameters();

            if ($countOfParams > 0 && !$args) {
                $source = '';
                foreach (debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS) as $item) {
                    if (isset($item['file']) && dirname($item['file']) !== __DIR__) {
                        $source = " in $item[file]:$item[line]";
                        break;
                    }
                }
                throw new MemberAccessException(
                    "You can not call method '$name' without parameters$source. $countOfParams params is required.",
                    E_USER_WARNING
                );
            }

            $reflectionMethod = new \ReflectionMethod($class, $name);
            $val = $reflectionMethod->invokeArgs($object, $args ? $args : []);

            return $val;
        } else { // strict class
            $items = array_merge($properties, array_keys($methods));
            $hint = join(", ", self::getSuggestion($items, $name));
            throw new MemberAccessException(
                "Cannot read an undeclared property $class::\$$name or method $class::$name()".(strlen(
                    $hint
                ) > 1 ? ", did you mean $hint?" : '.')
            );
        }
    }


    /**
     * Returns array of public (static, non-static and magic) methods.
     * @param array $methods
     * @param string $class
     * @return array
     */
    private static function getMethods($methods, $class)
    {
        $methods[] = array_fill_keys(get_class_methods($class), 0);
        if ($parent = get_parent_class($class)) {
            array_merge($methods, self::getMethods($methods, $parent));
        }

        return $methods[0];
    }


    /**
     * Returns array of class properties (public, protected, private).
     *
     * @param string $class
     * @return array
     */
    private static function getProperties($class)
    {
        $reflect = new \ReflectionClass($class);
        $prop = $reflect->getProperties(
            \ReflectionProperty::IS_PUBLIC | \ReflectionProperty::IS_PROTECTED | \ReflectionProperty::IS_PRIVATE
        );
        $properties = [];

        foreach ($prop as $property) {
            $properties[] = $property->name;
        }

        if ($parent = get_parent_class($class)) {
            $properties = array_merge(self::getProperties($parent), $properties);
        }

        return $properties;
    }


    /**
     * Finds the best suggestion.
     * @param array $items
     * @param string $value
     * @return array|null
     * @internal
     */
    public static function getSuggestion(array $items, $value)
    {
        $norm = preg_replace($re = '#^(get|set|has|is|add)(?=[A-Z])#', '', $value);
        $best = [];
        $min = (strlen($value) / 4 + 1) * 10 + .1;
        foreach ($items as $item) {
            if ($item !== $value && (($len = levenshtein($item, $value, 10, 11, 10)) < $min || ($len = levenshtein(
                            preg_replace($re, '', $item),
                            $norm,
                            10,
                            11,
                            10
                        ) + 20) < $min)
            ) {
                $min = $len;
                $best[] = $item;
            }
        }

        return $best;
    }
}

