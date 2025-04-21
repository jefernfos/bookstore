<?php

namespace Core;

class Container
{
    private $entries = [];

    // Get an instance of the class from the container or resolve it
    public function get($class)
    {
        if ($this->has($class)) {
            $entry = $this->entries[$class];

            return $entry($this);
        }

        return $this->resolve($class);
    }

    // Check if the class is registered in the container
    public function has($class)
    {
        return isset($this->entries[$class]);
    }

    // Register a class or concrete implementation in the container
    public function set($class, $concrete)
    {
        $this->entries[$class] = $concrete;
    }

    // Resolve a class and its dependencies
    public function resolve($class)
    {
        $reflectionClass = new \ReflectionClass($class);
        if (!$reflectionClass->isInstantiable()) {
            throw new \Exception("Class $class cannot be instantiated.");
        }

        $constructor = $reflectionClass->getConstructor();
        if (!$constructor) {
            return new $class;
        }

        $parameters = $constructor->getParameters();
        if (!$parameters) {
            return new $class;
        }

        $dependencies = array_map(
            function (\ReflectionParameter $param) use ($class) {
                $name = $param->getName();
                $type = $param->getType();

                if (!$type) {
                    throw new \Exception("Cannot resolve parameter '$name' in class $class.");
                }

                if ($type instanceof \ReflectionUnionType) {
                    throw new \Exception("Union types are not supported for parameter '$name' in class $class.");
                }

                if ($type instanceof \ReflectionNamedType && !$type->isBuiltin()) {
                    return $this->get($type->getName());
                }

                throw new \Exception("Unsupported parameter type for '$name' in class $class.");
            },
            $parameters
        );

        return $reflectionClass->newInstanceArgs($dependencies);
    }
}