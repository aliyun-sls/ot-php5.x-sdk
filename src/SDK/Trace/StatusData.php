<?php



namespace OpenTelemetry\SDK\Trace;

use OpenTelemetry\API\Trace as API;

final class StatusData implements StatusDataInterface
{
    private static $ok = null;
    private static $unset = null;
    private static $error = null;
    private $code;
    private $description;

    /** @psalm-param API\StatusCode::STATUS_* $code */
    public function __construct($code, $description) {
        $this->code = $code;
        $this->description = $description;
    }

    /** @psalm-param API\StatusCode::STATUS_* $code */
    public static function create($code, $description = null)
    {
        if (empty($description)) {
            switch ($code) {
                case API\StatusCode::STATUS_UNSET:
                    return self::unset0();
                case API\StatusCode::STATUS_ERROR:
                    return self::error();
                case API\StatusCode::STATUS_OK:
                    return self::ok();
            }
        }

        // Ignore description for non Error statuses.
        if (API\StatusCode::STATUS_ERROR !== $code) {
            $description = '';
        }

        return new self($code, $description); /** @phan-suppress-current-line PhanTypeMismatchArgumentNullable */
    }

    public static function ok()
    {
        if (null === self::$ok) {
            self::$ok = new self(API\StatusCode::STATUS_OK, '');
        }

        return self::$ok;
    }

    public static function error()
    {
        if (null === self::$error) {
            self::$error = new self(API\StatusCode::STATUS_ERROR, '');
        }

        return self::$error;
    }

    public static function unset0()
    {
        if (null === self::$unset) {
            self::$unset = new self(API\StatusCode::STATUS_UNSET, '');
        }

        return self::$unset;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function getDescription()
    {
        return $this->description;
    }
}
