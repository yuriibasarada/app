<?php


namespace shApp\router;


/**
 * Interface HandlerInterface
 *
 * @package shApp\router
 */
interface HandlerInterface
{

    public function resolve($class_method, $params);

    public function reject($path);
}