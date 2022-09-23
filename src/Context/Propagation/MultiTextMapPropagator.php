<?php


namespace OpenTelemetry\Context\Propagation;

use function array_map;
use function array_merge;
use function array_unique;
use function array_values;
use OpenTelemetry\Context\Context;

final class MultiTextMapPropagator implements TextMapPropagatorInterface
{
    /**
     * @readonly
     *
     * @var list<TextMapPropagatorInterface>
     */
    private $propagators = [];

    /**
     * @readonly
     *
     * @var list<string>
     */
    private $fields;

    /**
     * @no-named-arguments
     *
     * @param list<TextMapPropagatorInterface> $propagators
     */
    public function __construct(array $propagators)
    {
        $this->propagators = $propagators;
        $this->fields = $this->extractFields($propagators);
    }

    public function fields()
    {
        return $this->fields;
    }

    public function inject(&$carrier, $setter = null, $context = null)
    {
        foreach ($this->propagators as $propagator) {
            $propagator->inject($carrier, $setter, $context);
        }
    }

    public function extract($carrier, $getter = null, $context = null)
    {
        $context = isset($context) ? $context : Context::getCurrent();

        foreach ($this->propagators as $propagator) {
            $context = $propagator->extract($carrier, $getter, $context);
        }

        return $context;
    }

    /**
     * @param list<TextMapPropagatorInterface> $propagators
     * @return list<string>
     */
    private function extractFields(array $propagators)
    {
        return array_values(
            array_unique(
            // Phan seems to struggle here with the variadic argument
            // @phan-suppress-next-line PhanParamTooFewInternalUnpack
                array_merge(
                    ...array_map(
                        textMapPropagatorInterfaceCallables,
                        $propagators
                    )
                )
            )
        );
    }

    static function textMapPropagatorInterfaceCallables(TextMapPropagatorInterface $propagator) {
        return $propagator->fields();
    }
}
