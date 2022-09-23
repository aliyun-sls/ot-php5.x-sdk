<?php


namespace OpenTelemetry\SDK\Resource;

use function in_array;
use OpenTelemetry\SDK\Common\Attribute\Attributes;

class ResourceInfoFactory
{

    /**
     * Merges resources into a new one.
     *
     * @param ResourceInfo ...$resources
     * @return ResourceInfo
     */
    public static function merge(...$resources)
    {
        $attributes = [];

        foreach ($resources as $resource) {
            $attributes += $resource->getAttributes()->toArray();
        }

        $schemaUrl = self::mergeSchemaUrl(...$resources);

        return ResourceInfo::create(Attributes::create($attributes), $schemaUrl);
    }

    public static function defaultResource()
    {
        return ResourceInfo::create(Attributes::create([]));
    }

    public static function emptyResource()
    {
        return ResourceInfo::create(Attributes::create([]));
    }

    private static function mergeSchemaUrl(...$resources)
    {
        $schemaUrl = null;
        foreach ($resources as $resource) {
            if ($schemaUrl !== null && $resource->getSchemaUrl() !== null && $schemaUrl !== $resource->getSchemaUrl()) {
                // stop the merging if non-empty conflicting schemas are detected
                return null;
            }
            $schemaUrl = isset($schemaUrl) ? $schemaUrl : $resource->getSchemaUrl();
        }

        return $schemaUrl;
    }
}
