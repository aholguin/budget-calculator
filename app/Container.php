<?php

namespace App;

use App\Exceptions\Container\ContainerException;
use Psr\Container\ContainerInterface;
use ReflectionException;

class Container implements ContainerInterface
{

    private array $entries = [];

    /**
     * @inheritDoc
     * @throws ReflectionException
     */
    public function get(string $id)
    {

        if ($this->has($id)) {
            $entry = $this->entries[$id];

            if (is_callable($id)) {
                return $entry($this);
            }

            $id = $entry;
        }

        return $this->resolve($id);

    }

    /**
     * @inheritDoc
     */
    public function has(string $id): bool
    {
        return isset($this->entries[$id]);
    }

    public function set(string $id, callable|string $concrete): void
    {
        $this->entries[$id] = $concrete;
    }

    /**
     * @throws ReflectionException|ContainerException
     */
    public function resolve(string $id)
    {
        $reflectionClass = new \ReflectionClass($id);

        if (!$reflectionClass->isInstantiable()) {
            throw new ContainerException('Class ' . $id . ' is not instantiable');
        }

        $constructor = $reflectionClass->getConstructor();
        if (!$constructor) {
            return new $id;
        }

        $parameters = $constructor->getParameters();

        if (!$parameters) {
            return new $id;
        }

        $dependencies = array_map(function (\ReflectionParameter $parameter) use ($id) {

            $name = $parameter->getName();
            $type = $parameter->getType();

            if (!$type) {
                throw new ContainerException('Class ' . $id . ' does not have type hint for ' . $name);
            }

            if ($type instanceof \ReflectionUnionType) {
                throw new ContainerException('Class ' . $id . ' cannnot be resolve because it is instance of  ReflectionUnionType for ' . $name);
            }

            if ($type instanceof \ReflectionIntersectionType) {
                throw new ContainerException('Class ' . $id . ' cannnot be resolve because it is instance of  ReflectionIntersectionType for ' . $name);
            }

            if ($type instanceof \ReflectionNamedType && !$type->isBuiltin()) {
                return $this->get($type->getName());
            }

            throw new ContainerException('Class ' . $id . ' cannnot be resolve because is the parameter  ' . $name . 'is a builtin');

        }, $parameters);

        return $reflectionClass->newInstanceArgs($dependencies);
    }
}