<?php


namespace shApp\app;


use shApp\request\Request;
use shApp\request\RequestInterface;
use shApp\router\Handler;
use shApp\router\HandlerInterface;
use shApp\router\Router;
use shApp\router\RouterInterface;
use shCore\storage\session\SessionInterface;
use shCore\storage\session\SessionNative;

/**
 * Абстрактная реализация загрузчика приложения
 *
 * @package shApp\app
 */
abstract class AppAbstract implements AppInterface
{
    /**
     * Путь для маршрутизации по классам
     *
     * @var string
     */
    const KEY_PATH = '_path';

    /**
     * Дополнительные параметры запроса
     *
     * @var string
     */
    const KEY_PARAMS = '_params';

    /**
     * Входящие данные
     *
     * @var string
     */
    const KEY_CONTENT = '_content';

    /**
     * Идентификатор сессии
     *
     * @var string
     */
    const KEY_SESSION_ID = '_session_id';

    /**
     * Название параметра сессии
     *
     * @var string
     */
    const KEY_SESSION_NAME = '_session_name';

    /**
     * Название карты в хранилище сессии
     *
     * @var string
     */
    const KEY_SESSION_MAP_NAME = '_session_map';

    /**
     * Дополнительная конфигурация
     *
     * @var string
     */
    const KEY_EXT_CONFIG = '_ext';

    /**
     * Путь для маршрутизации по классам
     *
     * @var string
     */
    const MAP_DEFAULT = array();

    /**
     * Класс для обработки и хранения сессий
     *
     * @var SessionInterface
     */
    const SESSION_CLASS = SessionNative::class;

    /**
     * Класс для обработки входящих параметров запроса
     *
     * @var RequestInterface
     */
    const REQUEST_CLASS = Request::class;

    /**
     * Класс для обработки маршрутов
     *
     * @var RouterInterface
     */
    const ROUTER_CLASS = Router::class;

    /**
     * Класс для обработки вызова маршрута
     *
     * @var HandlerInterface
     */
    const HANDLER_CLASS = Handler::class;


    /**
     * Конфигурация
     *
     * @var array|null
     */
    protected $config = array();

    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @var SessionInterface
     */
    protected $session;

    public function __construct($config = null)
    {
        if ($config) $this->config = $config;
    }

    public function run()
    {
        $req_class = static::REQUEST_CLASS;
        $this->request = new $req_class(
            $this->config[static::KEY_PARAMS],
            $this->config[static::KEY_PATH],
            $this->config[static::KEY_CONTENT]
        );

        $ses_class = static::SESSION_CLASS;
        $this->session = new $ses_class(
            array(),
            $this->config[static::KEY_SESSION_ID]
        );

        $han_class = static::HANDLER_CLASS;
        $handler = new $han_class(
            $this->request,
            $this->session,
            $this->config[static::KEY_EXT_CONFIG]
        );

        $rou_class = static::ROUTER_CLASS;
        $router = new $rou_class($this->getMap(), $handler);
        return $router->callRoute($this->config[static::KEY_PATH]);
    }

    protected function getMap()
    {
        $this->session->sync();
        return $this->session->get(static::KEY_SESSION_MAP_NAME) ?? static::MAP_DEFAULT;
    }
}