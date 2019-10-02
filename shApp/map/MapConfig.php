<?php


namespace shApp\map;


use shApp\request\RequestInterface;
use shCore\storage\session\SessionInterface;

class MapConfig implements MapConfigInterface
{
    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @var SessionInterface
     */
    protected $session;

    /**
     * @var array $ext Additional configuration
     */
    protected $ext;

    public function __construct(RequestInterface &$request, SessionInterface &$session, array &$ext = null)
    {
        $this->session = $session;
        $this->request = $request;
        $this->ext = $ext;
    }

    /**
     * @return RequestInterface
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return SessionInterface
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * @return array
     */
    public function getExt()
    {
        return $this->ext;
    }
}