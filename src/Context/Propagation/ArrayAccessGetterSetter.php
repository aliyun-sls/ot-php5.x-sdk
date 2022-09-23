<?php


namespace OpenTelemetry\Context\Propagation;

if (!function_exists('array_key_first')) {
    function array_key_first(array $arr)
    {
        foreach ($arr as $key => $unused) {
            return $key;
        }
        return NULL;
    }
}

use ArrayAccess;
use function get_class;
use function gettype;
use InvalidArgumentException;
use function is_array;
use function is_object;
use function is_string;
use function sprintf;
use function strcasecmp;
use Traversable;

/**
 * @see https://github.com/open-telemetry/opentelemetry-specification/blob/v1.6.1/specification/context/api-propagators.md#textmap-propagator Getter and Setter.
 *
 * Default implementation of {@see PropagationGetterInterface} and {@see PropagationSetterInterface}.
 * This type is used if no custom getter/setter is provided to {@see TextMapPropagatorInterface::inject()} or {@see TextMapPropagatorInterface::extract()}.
 */
final class ArrayAccessGetterSetter implements PropagationGetterInterface, PropagationSetterInterface
{
    private static $instance = null;

    /**
     * Returns a singleton instance of `self` to avoid, multiple runtime allocations.
     */
    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /** {@inheritdoc} */
    public function keys($carrier)
    {
        if ($this->isSupportedCarrier($carrier)) {
            $keys = [];
            foreach ($carrier as $key => $_) {
                $keys[] = (string)$key;
            }

            return $keys;
        }

        throw new InvalidArgumentException(
            sprintf(
                'Unsupported carrier type: %s.',
                is_object($carrier) ? get_class($carrier) : gettype($carrier)
            )
        );
    }

    /** {@inheritdoc} */
    public function get($carrier, $key)
    {
        if ($this->isSupportedCarrier($carrier)) {
            $value = isset($carrier[$this->resolveKey($carrier, $key)]) ? $carrier[$this->resolveKey($carrier, $key)] : null;
            if (is_array($value) && $value) {
                $value = $value[array_key_first($value)];
            }

            return is_string($value)
                ? $value
                : null;
        }

        throw new InvalidArgumentException(
            sprintf(
                'Unsupported carrier type: %s. Unable to get value associated with key:%s',
                is_object($carrier) ? get_class($carrier) : gettype($carrier),
                $key
            )
        );
    }

    /** {@inheritdoc} */
    public function set(&$carrier, $key, $value)
    {
        if ($key === '') {
            throw new InvalidArgumentException('Unable to set value with an empty key');
        }
        if ($this->isSupportedCarrier($carrier)) {
            if (($r = $this->resolveKey($carrier, $key)) !== $key) {
                unset($carrier[$r]);
            }

            $carrier[$key] = $value;
            return;
        }

        throw new InvalidArgumentException(
            sprintf(
                'Unsupported carrier type: %s. Unable to set value associated with key:%s',
                is_object($carrier) ? get_class($carrier) : gettype($carrier),
                $key
            )
        );
    }

    private function isSupportedCarrier($carrier)
    {
        return is_array($carrier) || $carrier instanceof ArrayAccess && $carrier instanceof Traversable;
    }

    private function resolveKey($carrier, $key)
    {
        if (isset($carrier[$key])) {
            return $key;
        }

        foreach ($carrier as $k => $_) {
            $k = (string)$k;
            if (strcasecmp($k, $key) === 0) {
                return $k;
            }
        }

        return $key;
    }
}
