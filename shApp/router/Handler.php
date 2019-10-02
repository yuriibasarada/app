<?php


namespace shApp\router;


use shApp\error\AppException;
use shApp\map\MapConfig;
use shApp\map\MapConfigInterface;
use shApp\request\RequestInterface;
use shCore\storage\session\SessionInterface;

class Handler implements HandlerInterface
{
    /**
     * Класс конфигураций карты
     *
     * @var MapConfigInterface
     */
    const CLASS_MAP_CONFIG = MapConfig::class;


    /**
     * @var SessionInterface
     */
    protected $session;

    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @var array
     */
    protected $ext;

    public function __construct(RequestInterface &$request, SessionInterface &$session, array &$ext = null)
    {
        $this->request = $request;
        $this->session = $session;
        $this->ext = $ext;
    }

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
            $class = new $class_method[0]($config);
            $method = $class_method[1];
            return $class->$method(...$params);
        } else {
            throw new AppException('Format of result not support');
        }
    }

    /**
     * Информирует об ошибке
     *
     * @param $path
     * @return array
     */
    public function reject($path)
    {
        return array(
            'error' => array(
                'text' => 'Path not found (:var)',
                'prepare' => array(
                    ':var' => $path
                )
            )
        );
    }
}