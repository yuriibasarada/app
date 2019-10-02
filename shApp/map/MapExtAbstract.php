<?php


namespace shApp\map;


use shCore\database\DatabaseInterface;
use shCore\database\DatabasePdo;
use shCore\database\ResultInterface;
use shCore\database\ResultPdo;
use shCore\error\CoreException;

abstract class MapExtAbstract extends MapAbstract
{
    /**
     * @var DatabaseInterface
     */
    protected $db;

    /**
     * Абстракция для возможности перехвата вызова внутри карты
     *
     * @param string $method
     * @param mixed $params
     * @return mixed
     */
    public function _call($method, $params)
    {
        return $this->$method(...$params);
    }

    /**
     * Выполнить запрос к бд с параметрами или без
     *
     * @param $query
     * @param null $params
     * @return ResultInterface|ResultPdo
     * @throws CoreException
     */
    protected function query($query, $params = null)
    {
        if ($params) {
            return $this->onceDatabase()->queryPrepare($query, $params);
        } else {
            return $this->onceDatabase()->query($query);
        }
    }

    /**
     * Вернуть ссылку на существующее подключение к бд
     *
     * @return DatabaseInterface|DatabasePdo
     */
    protected function &onceDatabase()
    {
        if (!$this->db) $this->db = $this->getDatabase();
        return $this->db;
    }

    /**
     * Получить данные из сессии по ключу
     *
     * @param string $key
     * @return mixed|null
     */
    protected function get($key)
    {
        return $this->session->get($key);
    }

    /**
     * Задать данные по ключу в сессию
     *
     * @param string $key
     * @param mixed $value
     */
    protected function set($key, $value)
    {
        $this->session->set($key, $value);
    }
}