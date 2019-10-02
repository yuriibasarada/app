<?php


namespace shApp\map;


use shApp\request\RequestInterface;
use shCore\database\DatabaseConfigPDO;
use shCore\database\DatabasePdo;
use shCore\database\ext\Crud;
use shCore\storage\session\SessionInterface;
use shApp\map\MapConfigInterface as MapConfig;

abstract class MapAbstract
{
    const DATABASE_CLASS = DatabasePdo::class;
    const DATABASE_CONFIG_CLASS = DatabaseConfigPDO::class;
    const CRUD_CLASS = Crud::class;

    /**
     * @var MapConfig $config конфигурацмия к базе данных
     */
    protected $config;

    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @var SessionInterface
     */
    protected $session;

    /**
     * @var array $db_config массив для подключения к базе данных
     */
    protected $db_config;

    /**
     * MapController constructor.
     *
     * @param MapConfig $config
     */
    public function __construct(MapConfig &$config)
    {
        $this->config = $config;
        $this->request = $config->getRequest();
        $this->session = $config->getSession();
    }

    /**
     * Инициализирует переменную $db_config
     *
     * @return array|mixed
     */
    public function getDatabaseConfig()
    {
        if (!$this->db_config) {
            $ext = $this->config->getExt();
            $this->db_config = &$ext['db/config'];
        }
        return $this->db_config;
    }

    /**
     * Подключения к базе данных  с текущими параметрами подключения
     *
     * @return DatabasePdo
     */
    public function getDatabase()
    {
        $db_class = static::DATABASE_CLASS;
        $config_class = static::DATABASE_CONFIG_CLASS;
        $config = new $config_class($this->getDatabaseConfig());
        return new $db_class($config);
    }

    /**
     * Возвращает инициализированный класс текущей базой данных
     *
     * @param  $table
     * @return Crud
     */
    public function getCrud($table)
    {
        $crud_class = static::CRUD_CLASS;
        return new $crud_class(
            $this->getDatabase(),
            $table
        );
    }

    /**
     * Получения информации из тела запроса
     *
     * @return mixed
     */
    public function getData()
    {
        return $this->request->getContent();
    }

}