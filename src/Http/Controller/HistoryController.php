<?php

namespace Jakmall\Recruitment\Calculator\Http\Controller;

use Illuminate\Http\Request;

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

    public function show()
    {
        dd('create show history by id here');
    }

    public function remove()
    {
        // todo: modify codes to remove history
        dd('create remove history logic here');
    }
}
