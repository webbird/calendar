<?php

declare(strict_types=1);

namespace webbird\Calendar;

trait PropertyGeneratorTrait
{
    public function __get(string $property)
    {
        $method = 'get' . ucfirst($property); //camelCase() method name
        if (method_exists($this, $method)) {
            $reflection = new \ReflectionMethod($this, $method);
            if (!$reflection->isPublic()) {
                throw new \RuntimeException("The called method is not public.");
            }
        }
        if (property_exists($this, $property)) {
            return $this->{$property};
        }
    }

    public function __set(string $property, mixed $value)
    {
        $method = 'set' . ucfirst($property); //camelCase() method name
        if (method_exists($this, $method)) {
            $reflection = new \ReflectionMethod($this, $method);
            if (!$reflection->isPublic()) {
                throw new \RuntimeException("The called method is not public.");
            }
        }
        # to allow optional properties, we do not check vor existance here
        #if (property_exists($this, $property)) {
            $this->$property = $value;
        #}
    }
}
