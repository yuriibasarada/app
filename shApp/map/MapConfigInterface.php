<?php


namespace shApp\map;


use shApp\request\RequestInterface;
use shCore\storage\session\SessionInterface;

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