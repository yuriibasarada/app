<?php


namespace Core\router;


use Core\error\AppException;
use Core\map\MapExtAbstract;

class HandlerExt extends Handler
{
    /**
     * Вызывает метод класса с указанными параметрами
     *
     * @param array $class_method
     * @param array $params
     * @return mixed
     * @throws AppException
     */
    public function resolve($class_method, $params)
    {
        if (is_array($class_method) && sizeof($class_method) === 2) {
            $conf_class = static::CLASS_MAP_CONFIG;
            $config = new $conf_class($this->request, $this->session, $this->ext);

            /**
             * @var MapExtAbstract $class
             */
            $class = new $class_method[0]($config);
            return $class->_call($class_method[1], $params);
        } else {
            throw new AppException('Format of result not support');
        }
    }
}