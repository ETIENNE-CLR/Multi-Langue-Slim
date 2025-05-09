<?php

namespace Interfaces;

interface ICRUD
{
    public function create();
    static function read();
    static function readById(int $id);
    public function update();
    static function delete(int $id);
}
