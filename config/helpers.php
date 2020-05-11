<?php

use Illuminate\Database\Capsule\Manager as Database;

$database = new Database();

$database->addConnection([
    'driver' => 'sqlite',
    'database' => 'config/sqlite.db',
]);
$database->setAsGlobal();

function generateCommandSignature($commandVerb, $passiveCommandVerb, $isMultipleArgument = false): string
{
    if ($isMultipleArgument) {
        return collect($passiveCommandVerb)->reduce(function($carry, $argument){
            return $carry.' {'.$argument['name'].' : '.$argument['description'].'}';
        }, $commandVerb);
    } else {
        return sprintf(
            '%s {numbers* : The numbers to be %s}',
            $commandVerb,
            $passiveCommandVerb
        );
    }
}

/**
 * @param string $command
 * @param string $description
 * @param string $calculationResult
 * @param string $result
 *
 * @return void
 */
function logCalculation($command, $description, $calculationResult, $result): void
{
    $data = fetchData();

    date_default_timezone_set('Asia/Jakarta');
    $currentTimestamp = date('Y-m-d h:i:s', time());

     Database::table('history')->insertGetId([
        'command' => $command,
        'description' => $description,
        'result' => $calculationResult,
        'output' => $result,
        'time' => $currentTimestamp
    ]);

    writeData($data->push([
        'command' => $command,
        'description' => $description,
        'result' => $calculationResult,
        'output' => $result,
        'time' => $currentTimestamp
    ])->toJson());
}

/**
 * @param boolean $isFetchFromDatabase
 *
 * @return \Illuminate\Support\Collection
 */
function fetchData($isFetchFromDatabase = false)
{
    if ($isFetchFromDatabase) {
        return collect(Database::table('history')->get());
    } else {
        $filename = 'history.json';
        return collect(file_exists($filename) ? json_decode(file_get_contents($filename)) : []);
    }
}

/**
 * @param string $data
 *
 * @return void
 */
function writeData($data): void
{
    $filename = 'history.json';
    if (empty($data)) {
        Database::table('history')->truncate();
        if (file_exists($filename)) {
            unlink($filename);
        }
    } else {
        file_put_contents($filename, $data);
    }
}

function extractData($data, $ops): string
{
    $temp = "";
    $tempCount = 1;
    $countData = count($data);
    foreach( $data as $element ) {  
        if($tempCount < $countData){
            $temp .= $element." ".$ops." ";
        }else{
            $temp .= $element;
        }
        $tempCount++;
    } 

    return $temp;
}