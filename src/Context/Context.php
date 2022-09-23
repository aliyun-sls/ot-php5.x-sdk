<?php


namespace OpenTelemetry\Context;

/**
 * @see https://github.com/open-telemetry/opentelemetry-specification/blob/v1.6.1/specification/context/context.md#overview
 */
final class Context
{
    /**
     * @var ContextStorageInterface&ExecutionContextAwareInterface
     */
    private static $storage;
    private static $root = null;
    private $key;
    /**
     * @var mixed
     */
    private $value;
    private $parent;

    /**
     * This is a general purpose read-only key-value store. Read-only in the sense that adding a new value does not
     * mutate the existing context, but returns a new Context which has the new value added.
     *
     * In practical terms, this is implemented as a linked list of Context instances, with each one holding a reference
     * to the key object, the value that corresponds to the key, and an optional reference to the parent Context
     * (i.e. the next link in the linked list chain)
     *
     * @param ContextKey|null $key The key object. Should only be null when creating an "empty" context
     * @param mixed $value
     * @param Context|null $parent Reference to the parent object
     */
    private function __construct($key = null, $value = null, $parent = null)
    {
        $this->key = $key;
        $this->value = $value;
        $this->parent = $parent;
    }

    /**
     * Static version of get()
     * This is primarily useful when the caller doesn't already have a reference to the Context that they want to mutate.
     * This will operate on the "current" global context in that scenario.
     *
     * There are two ways to call this function:
     * 1) With a $context value:
     *    Context::getValue($key, $context) is functionally equivalent to $context->get($key)
     * 2) Without a $context value:
     *    This will fetch the "current" Context if one exists or create one if not, then attempt to get the value from it.
     *
     * @param ContextKey $key
     * @param Context|null $context
     *
     * @return mixed
     */
    public static function getValue($key, $context = null)
    {
        $context = isset($context) ? $context : self::getCurrent();

        return $context->get($key);
    }

    /**
     * This adds a key/value pair to this Context. We do this by instantiating a new Context instance with the key/value and pass
     * a reference to $this as the "parent" creating the linked list chain.
     *
     * @param ContextKey $key
     * @param mixed $value
     *
     * @return Context a new Context containing the key/value
     */
    public function with($key, $value)
    {
        return new self($key, $value, $this);
    }

    /**
     * @todo: Implement this on the API side
     */
    public function withContextValue($value)
    {
        return $value->storeInContext($this);
    }

    /**
     * Makes `$this` the currently active {@see Context}.
     *
     * @todo: Implement this on the API side
     */
    public function activate()
    {
        return self::storage()->attach($this);
    }

    /**
     * Fetch a value from the Context given a key value.
     *
     * @return mixed
     */
    public function get($key)
    {
        for ($context = $this; $context; $context = $context->parent) {
            if ($context->key === $key) {
                return $context->value;
            }
        }

        return null;
    }

    /**
     * @param ContextStorageInterface&ExecutionContextAwareInterface $storage
     * @internal
     *
     */
    public static function setStorage($storage)
    {
        self::$storage = $storage;
    }

    /**
     * @return ContextStorageInterface&ExecutionContextAwareInterface
     */
    public static function storage()
    {
        /** @psalm-suppress RedundantPropertyInitializationCheck */
        return self::$storage = isset(self::$storage) ? self::$storage : new ContextStorage();
    }

    /**
     * @param non-empty-string $key
     *
     * @see https://github.com/open-telemetry/opentelemetry-specification/blob/v1.6.1/specification/context/context.md#create-a-key
     */
    public static function createKey($key)
    {
        return new ContextKey($key);
    }

    public static function getCurrent()
    {
        return self::storage()->current();
    }

    public static function getRoot()
    {
        return self::$root = isset(self::$root) ? self::$root : new self();
    }
}
