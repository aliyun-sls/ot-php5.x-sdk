<?php


namespace OpenTelemetry\Context;

/**
 * @internal
 */
final class ContextStorage implements ContextStorageInterface, ExecutionContextAwareInterface
{
    public $current;
    private $main;
    /** @var array<int|string, ContextStorageHead> */
    private $forks = [];

    public function __construct()
    {
        $this->current = $this->main = new ContextStorageHead($this);
    }

    public function fork($id)
    {
        $this->forks[$id] = clone $this->current;
    }

    public function switch0($id)
    {
        $this->current = isset($this->forks[$id]) ? $this->forks[$id] : $this->main;
    }

    public function destroy($id)
    {
        unset($this->forks[$id]);
    }

    public function scope()
    {
        return (isset($this->current->node->head) ? $this->current->node->head : null) === $this->current
            ? $this->current->node
            : null;
    }

    public function current()
    {
        return isset($this->current->node->context) ? $this->current->node->context : Context::getRoot();
    }

    public function attach($context)
    {
        return $this->current->node = new ContextStorageNode($context, $this->current, $this->current->node);
    }

    private function __clone()
    {
    }
}
