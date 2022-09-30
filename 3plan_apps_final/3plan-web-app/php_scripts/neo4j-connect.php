<?php

require_once "../vendor/autoload.php";

use Laudis\Neo4j\Authentication\Authenticate;
use Laudis\Neo4j\ClientBuilder;
use Laudis\Neo4j\Databags\Statement;
use \Laudis\Neo4j\Types\Node;

$client = ClientBuilder::create()->withDriver(
    'aura',
    'neo4j+s://fb848df8.databases.neo4j.io',
    Authenticate::basic('', '')
)
    ->build();