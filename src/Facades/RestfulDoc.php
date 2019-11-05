<?php
namespace OlderW\RestfulDoc\Facades;

use Illuminate\Support\Facades\Facade;

class RestfulDoc extends Facade {
    protected static function getFacadeAccessor() {
        return \OlderW\RestfulDoc\RestfulDoc::class;
    }
}
