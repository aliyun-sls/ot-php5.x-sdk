<?php


namespace OpenTelemetry\SDK\Resource;

/**
 * A Resource is an immutable representation of the entity producing telemetry. For example, a process producing telemetry
 * that is running in a container on Kubernetes has a Pod name, it is in a namespace and possibly is part of a Deployment
 * which also has a name. All three of these attributes can be included in the Resource.
 *
 * The class named as ResourceInfo due to `resource` is the soft reserved word in PHP.
 */
class ResourceInfo
{
    private $attributes;
    private $schemaUrl;

    private function __construct($attributes, $schemaUrl = null)
    {
        $this->attributes = $attributes;
        $this->schemaUrl = $schemaUrl;
    }

    public static function create($attributes, $schemaUrl = null)
    {
        return new ResourceInfo($attributes, $schemaUrl);
    }

    public function getAttributes()
    {
        return $this->attributes;
    }

    public function getSchemaUrl(){
        return $this->schemaUrl;
    }

    public function serialize()
    {
        $copyOfAttributesAsArray = array_slice($this->attributes->toArray(), 0); //This may be overly cautious (in trying to avoid mutating the source array)
        ksort($copyOfAttributesAsArray); //sort the associative array by keys since the serializer will consider equal arrays different otherwise

        //The exact return value doesn't matter, as long as it can distingusih between instances that represent the same/different resources
        return serialize([
            'schemaUrl' => $this->schemaUrl,
            'attributes' => $copyOfAttributesAsArray,
        ]);
    }

    /**
     * @codeCoverageIgnore
     */
    public static function defaultResource()
    {
        return ResourceInfoFactory::defaultResource();
    }

}
