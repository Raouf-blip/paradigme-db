<?php
require_once __DIR__ . '/../vendor/autoload.php';

class MongoConnection
{
    private static ?\MongoDB\Client $client = null;

    public static function getDb(): \MongoDB\Database
    {
        if (!self::$client) {
            self::$client = new \MongoDB\Client('mongodb://127.0.0.1:27017');
        }
        return self::$client->selectDatabase('chopizza');
    }
}