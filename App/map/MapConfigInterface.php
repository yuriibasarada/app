<?php


namespace Core\map;


use Core\request\RequestInterface;
use Core\storage\session\SessionInterface;

interface MapConfigInterface
{
    /**
     * @return RequestInterface
     */
    public function getRequest();

    /**
     * @return SessionInterface
     */
    public function getSession();

    /**
     * @return array
     */
    public function getExt();
}