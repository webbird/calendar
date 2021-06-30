<?php

declare(strict_types=1);

namespace webbird\Calendar;

trait PropertyGeneratorTrait
{
    /**
     *
     */
    public function __call(string $methodName, array $arguments): mixed
    {
        if (preg_match('~^(set|get)([A-Z])(.*)$~', $methodName, $matches)) {
            $property = strtolower($matches[2]) . $matches[3];
            if (!property_exists($this, $property)) {
                throw new \UnexpectedValueException(sprintf(
                    'Property [%s] does not exist (method: %s)',
                    $property, $methodName
                ));
            }
            $result = false;
            switch($matches[1]) {
                case 'set':
                    $this->$property = $arguments[0];
                    $result = true;
                    break;
                case 'get':
                    if (property_exists($this, $property)) {
                        $result = $this->{$property};
                    } else {
                        $result = null;
                    }
                    break;
                case 'default':
                    throw new \UnexpectedValueException(sprintf(
                        'Method [%s] does not exist',
                        $methodName
                    ));
            }
        }
        return $result;
    }

    /**
     *
     */
    public function __get(string $property)
    {
        $method = 'get' . ucfirst($property); //camelCase() method name
        if (method_exists($this, $method)) {
            $reflection = new \ReflectionMethod($this, $method);
            if (!$reflection->isPublic()) {
                throw new \BadMethodCallException("The called method is not public.");
            }
        }
        if (property_exists($this, $property)) {
            return $this->{$property};
        }
    }

    /**
     *
     */
    public function __set(string $property, mixed $value)
    {
        $method = 'set' . ucfirst($property); //camelCase() method name
        if (method_exists($this, $method)) {
            $reflection = new \ReflectionMethod($this, $method);
            if (!$reflection->isPublic()) {
                throw new \BadMethodCallException("The called method is not public.");
            }
        }
        # to allow optional properties, we do not check for existance here
        $this->$property = $value;
    }

    /**
     *
     * @access public
     * @return
     **/
    public function specialKeys() : array
    {
        return array();
    }   // end function specialKeys()

    /**
     *
     * @access public
     * @return
     **/
    public function getParameters(mixed $optional)
    {
        if(is_array($optional)) {
            $specials = $this->specialKeys();
            foreach($optional as $key => $value) {
                if(array_key_exists($key,$specials)) {
                    if($value instanceof $specials[$key]) {
                        $this->$key = $value;
                    }
                } else {
                    $this->{$key} = $value;
                }
            }
        }
    }   // end function getParameters()
    
}
