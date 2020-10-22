<?php


namespace Core\app;

/**
 * Interface AppInterface
 * @package App\app
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