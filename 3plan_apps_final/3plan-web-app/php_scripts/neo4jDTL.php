<?php

require_once "../vendor/autoload.php";

use Laudis\Neo4j\Databags\Statement;
use \Laudis\Neo4j\Types\Node;

function createNode($client, $uid)
{
    $results = $client->run('Create (p:Person {uid: "' . $uid . '"})');
}

function createRelationship($client, $uidA, $uidB)
{
    $results = $client->run('MATCH (a:Person), (b:Person) WHERE a.uid = "' . $uidA . '" and b.uid = "' . $uidB . '"
							create (a)-[:kennt]->(b)');
}

function getFriends($client, $uid):array
{
    $results = $client->run('MATCH (p:Person {uid: "' . $uid . '"}) - [:kennt] - (x:Person) return x');
    return convertToSet($results);
}

function deleteNode($client, $uid)
{
    $results = $client->run('MATCH (p:Person {uid: "' . $uid . '"}) DETACH DELETE p');
}

function deleteRelationship($client, $uid, $uid_Friend)
{
    $result = $client->run('MATCH (p:Person {uid: "' . $uid . '"})-[r:kennt]-(m:Person {uid: "' . $uid_Friend . '"})
    DELETE r');
}

function convertToSet($list)
{
    $array = [];
    foreach ($list as $item) {
        $node = $item->get('x');
        if (!in_array($node->getProperty('uid'), $array)) {
            array_push($array, $node->getProperty('uid'));
        }
    }
    return $array;
}