<?php



namespace OpenTelemetry\Context\Propagation;

use function preg_replace;

/**
 * Some servers concatenate multiple headers with ';' -- we need to replace these with ','
 * This is still a workaround and doesn't get around the problem fully, specifically it doesn't
 * handle edge cases where the header has a trailing ';' or an empty trace state.
 * We also need to trim trailing separators from the header, found when a header is empty.
 */
final class SanitizeCombinedHeadersPropagationGetter implements PropagationGetterInterface
{
    const LIST_MEMBERS_SEPARATOR = ',';
    const SERVER_CONCAT_HEADERS_REGEX = '/;(?=[^,=;]*=|$)/';
    const TRAILING_LEADING_SEPARATOR_REGEX = '/^' . self::LIST_MEMBERS_SEPARATOR . '+|' . self::LIST_MEMBERS_SEPARATOR . '+$/';

    private $getter;

    public function __construct(PropagationGetterInterface $getter)
    {
        $this->getter = $getter;
    }

    public function keys($carrier)
    {
        return $this->getter->keys($carrier);
    }

    public function get($carrier, $key)
    {
        $value = $this->getter->get($carrier, $key);
        if ($value === null) {
            return null;
        }

        return preg_replace(
            [self::SERVER_CONCAT_HEADERS_REGEX, self::TRAILING_LEADING_SEPARATOR_REGEX],
            [self::LIST_MEMBERS_SEPARATOR],
            $value
        );
    }
}
