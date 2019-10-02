<?php


namespace shApp\app;

/**
 * Interface AppInterface
 * @package shApp\app
 */
interface AppInterface
{

    /**
     * Метод вызываеться для записи страницы
     *
     * @return mixed
     */
    public function run();
}