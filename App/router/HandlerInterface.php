<?php


namespace Core\router;


/**
 * Interface HandlerInterface
 *
 * @package App\router
 */
interface HandlerInterface
{

    public function resolve($class_method, $params);

    public function reject($path);
}