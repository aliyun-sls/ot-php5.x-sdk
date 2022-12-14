<?php



namespace OpenTelemetry\Context\Propagation;

use OpenTelemetry\Context\Context;

/**
 * @see https://github.com/open-telemetry/opentelemetry-specification/blob/v1.6.1/specification/context/api-propagators.md#textmap-propagator
 */
interface TextMapPropagatorInterface
{
    /**
     * Returns list of fields that will be used by this propagator.
     *
     * @see https://github.com/open-telemetry/opentelemetry-specification/blob/v1.6.1/specification/context/api-propagators.md#fields
     *
     * @return list<string>
     */
    public function fields();

    /**
     * Injects specific values from the provided {@see Context} into the provided carrier
     * via an {@see PropagationSetterInterface}.
     *
     * @see https://github.com/open-telemetry/opentelemetry-specification/blob/v1.6.1/specification/context/api-propagators.md#textmap-inject
     *
     * @param mixed &$carrier
     */
    public function inject(&$carrier, $setter = null, $context = null);

    /**
     * Extracts specific values from the provided carrier into the provided {@see Context}
     * via an {@see PropagationGetterInterface}.
     *
     * @see https://github.com/open-telemetry/opentelemetry-specification/blob/v1.6.1/specification/context/api-propagators.md#textmap-extract
     */
    public function extract($carrier, $getter = null, $context = null);
}
