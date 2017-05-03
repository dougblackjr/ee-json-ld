<?php

namespace Spatie\SchemaOrg;

use DateTime;
use ReflectionClass;
use DateTimeInterface;
use Spatie\SchemaOrg\Exceptions\InvalidProperty;
abstract class BaseType implements Type
{
    /** @var array */
    protected $properties = [];
    public function getContext()
    {
        return 'http://schema.org';
    }
    public function getType()
    {
        return (new ReflectionClass($this))->getShortName();
    }
    public function setProperty($property, $value)
    {
        $this->properties[$property] = $value;
        return $this;
    }
    // Renamed this from if because if is a php term
    // Was throwing an error
    public function testIf($condition, $callback)
    {
        if ($condition) {
            $callback($this);
        }
        return $this;
    }
    public function getProperty($property, $default = null)
    {
        return isset($this->properties[$property]) ? $this->properties[$property] : $default;
    }
    public function getProperties()
    {
        return $this->properties;
    }
    public function toArray()
    {
        $properties = $this->serializeProperty($this->getProperties());
        return ['@context' => $this->getContext(), '@type' => $this->getType()] + $properties;
    }
    protected function serializeProperty($property)
    {
        if (is_array($property)) {
            return array_map([$this, 'serializeProperty'], $property);
        }
        if ($property instanceof Type) {
            $property = $property->toArray();
            unset($property['@context']);
        }
        if ($property instanceof DateTimeInterface) {
            $property = $property->format(DateTime::ISO8601);
        }
        if (is_object($property)) {
            throw new InvalidProperty();
        }
        return $property;
    }
    public function toScript()
    {
        return '<script type="application/ld+json">' . json_encode($this->toArray()) . '</script>';
    }
    public function __toString()
    {
        return $this->toScript();
    }
}