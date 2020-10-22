<?php


namespace Core\router;


/**
 * Класс для получения маршрута (При помощи обращения к методу класса)
 * Class Router
 * @package App\router
 */
class Router implements RouterInterface
{

    /**
     * @var string MSG_HANDLER_NOT_FOUND переменная Хранящая сообщение об ошибке
     */
    const MSG_HANDLER_NOT_FOUND = 'Handler not found';

    /**
     * @var string KEY_ROUTE_CALL_CLASS переменная Хранящая сообщение об успехе
     */
    const KEY_ROUTE_CALL_CLASS = 'route_call_class';

    /**
     * @var array $map карта маршрутов
     */
    protected $map;

    /**
     * @var HandlerInterface $handler ссылка на класс Handler
     */
    protected $handler;

    /**
     * Инициализация карты
     *
     * @param array $map
     * @param array $config
     */
    public function __construct($map, HandlerInterface $handler)
    {
        $this->map = $map;
        $this->handler = $handler;
    }

    /**
     * Вызвать маршрут из карты маршрутов
     *
     * @param string $path
     * @return array
     */
    public function callRoute($path)
    {
        $r = $this->getRoute($path);
        if ($r) return $this->handler->resolve(...$r);
        return $this->handler->reject($path);
    }

    /**
     * Найти маршрут с параметрами, в карте маршрутов
     *
     * @param string $path
     * @return array | bool
     */
    public function getRoute($path)
    {
        $route = &$this->map[$path];
        if ($route) {
            return [
                $route,
                []
            ];
        } else {
            foreach ($this->map as $key => &$class_method) {
                if (!strpos($key, ':')) continue;

                // %^/test/(.*)/(.*)/(.*)/$%
                $key = '%^' . str_replace(':var', '(.*)', $key) . '$%';
                $res = preg_match($key, $path, $match);
                if ($res) {
                    array_shift($match);
                    return [
                        $class_method,
                        $match
                    ];
                }
            }
        }
        return false;
    }
}