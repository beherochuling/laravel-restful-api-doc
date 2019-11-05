<?php
namespace OlderW\RestfulDoc\Interfaces;

interface DocPusher {
    /**
     * @param $type string
     * @param $data string
     */
    public function push($type, $data);
}
