<?php



namespace OpenTelemetry\Context;

interface ExecutionContextAwareInterface
{
    /**
     * @param int|string $id
     */
    public function fork($id);

    /**
     * @param int|string $id
     */
    public function switch0($id);

    /**
     * @param int|string $id
     */
    public function destroy($id);
}
