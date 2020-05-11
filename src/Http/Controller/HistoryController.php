<?php

namespace Jakmall\Recruitment\Calculator\Http\Controller;

use Illuminate\Http\Request;
use Illuminate\Database\Capsule\Manager as Database;

class HistoryController
{
    public function index()
    {
        // todo: modify codes to get history
        $data = fetchData(true);
        $count = 0;
        $dataFull = array();
        foreach( $data as $element ) {  
            switch (strtolower($element->command)) {
                case "add":
                    $input = str_replace(' ', "", str_replace('"', "", json_encode(explode('+', $element->description))));
                    break;
                case "divide":
                    $input = str_replace(' ', "", str_replace('"', "", json_encode(explode('/', $element->description))));
                    break;
                case "multiply":
                    $input = str_replace(' ', "", str_replace('"', "", json_encode(explode('*', $element->description))));
                    break;
                case "pow":
                    $input = str_replace(' ', "", str_replace('"', "", json_encode(explode('^', $element->description))));
                    break;
                case "subtract":
                    $input = str_replace(' ', "", str_replace('"', "", json_encode(explode('-', $element->description))));
                    break;
                default:

                }

            $data = [ 
                'id' => strtotime($element->time),
                'command' => $element->command,
                'operation' => $element->description,
                'input' => $input,
                'result' => $element->result,
                'time' => $element->time,
             ];

             array_push($dataFull,$data);
        }
        
        header('Content-Type: application/json');
        echo json_encode($dataFull);
    }

    public function show($id)
    {
        $time = date('Y-m-d h:i:s', $id);
        $element = Database::table('history')->where('time', $time)->first();
        switch (strtolower($element->command)) {
            case "add":
                $input = str_replace(' ', "", str_replace('"', "", json_encode(explode('+', $element->description))));
                break;
            case "divide":
                $input = str_replace(' ', "", str_replace('"', "", json_encode(explode('/', $element->description))));
                break;
            case "multiply":
                $input = str_replace(' ', "", str_replace('"', "", json_encode(explode('*', $element->description))));
                break;
            case "pow":
                $input = str_replace(' ', "", str_replace('"', "", json_encode(explode('^', $element->description))));
                break;
            case "subtract":
                $input = str_replace(' ', "", str_replace('"', "", json_encode(explode('-', $element->description))));
                break;
            default:

            }

        $data = [ 
            'id' => strtotime($element->time),
            'command' => $element->command,
            'operation' => $element->description,
            'input' => $input,
            'result' => $element->result,
            'time' => $element->time,
            ];
        
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function remove($id)
    {
        // todo: modify codes to remove history
        $time = date('Y-m-d h:i:s', $id);
        $element = Database::table('history')->where('time', $time)->first();
        if($element){
            Database::table('history')->where('time', $time)->delete();
            header('Content-Type: application/json');
            echo json_encode([ 'result' => "Done"]);
        }else{
            header("HTTP/1.1 204 NO CONTENT");
            return response(null, 204);
        }
    }
}
