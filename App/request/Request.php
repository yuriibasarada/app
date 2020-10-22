<?php


namespace Core\request;

/**
 * Класс для хранения Cookies, POST/GET, Тела запроса, пути. И обращения к ним.
 *
 * Class Request
 * @package App\request
 */
class Request implements RequestInterface
{
    /**
     * @var array $params Массив для хранения из сепрглобальных перемнных $GET/$POST
     */
    protected $params;

    /**
     * @var array $cookies массив для хранения данны из куков
     */
    protected $cookies;

    /**
     * @var array $content массив для хранения из тела запроса
     */
    protected $content;

    /**
     * @var string $path строка для хранения пути
     */
    protected $path;

    /**
     * Request constructor.
     *
     * @param $params
     * @param string $path
     * @param $content
     */
    public function __construct($params, $path, $content)
    {
        $this->params = &$params;
        $this->path = &$path;
        $this->content = &$content;
    }

    /**
     * Возвращает данные из GET/POST
     * @param string $name
     * @return mixed|null
     */
    public function getParam($name)
    {
        return self::getFrom($this->params, $name);
    }

    /**
     * Возвращает данные из тела запроса
     * @return array|mixed|null
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Функция шаблон для возврата данных
     * @param $storage
     * @param $name
     * @return |null
     */
    protected static function getFrom($storage, $name)
    {
        $r = &$storage[$name];
        return isset($r) ? $r : null;
    }

    /**
     *
     * Функция вовращает путь к которому обращаться
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }
}