<?php

namespace Jakmall\Recruitment\Calculator\Http\Controller;

class CalculatorController
{
    public function calculate($action)
    {
        $inputData = json_decode($_REQUEST['input'], true);
        $result = 0;
        $correctData = true;
        $data = [ 'command' => strtolower($action), 'operation' => "-", 'result' => "only numeric value" ];
        switch (strtolower($action)) {
            case "add":
                $operation = extractData($inputData, "+");
                foreach( $inputData as $element ) {  
                    if(!is_numeric($element)){
                        $correctData = false;
                        break;
                    }
                    $result += $element;
                } 
                break;
            case "divide":
                $operation = extractData($inputData, "/");
                foreach( $inputData as $element ) {  
                    if(!is_numeric($element)){
                        $correctData = false;
                        break;
                    }
                    if($result == 0){
                        $result = $element;
                    }else{
                        $result = $result / $element;
                    }
                } 
                break;
            case "multiply":
                $operation = extractData($inputData, "*");
                foreach( $inputData as $element ) {  
                    if(!is_numeric($element)){
                        $correctData = false;
                        break;
                    }
                    if($result == 0){
                        $result = $element;
                    }else{
                        $result = $result * $element;
                    }
                } 
                break;
            case "pow":
                if(count($inputData) > 2){
                    $data = [ 'command' => strtolower($action), 'operation' => "-", 'result' => "only two data in pow" ];
                    $correctData = false;
                    break;
                }
                $operation = extractData($inputData, "^");
                foreach( $inputData as $element ) {  
                    if(!is_numeric($element)){
                        $correctData = false;
                        break;
                    }
                    if($result == 0){
                        $result = $element;
                    }else{
                        $result = pow($result ,$element);
                    }
                } 
                break;
            case "subtract":
                $operation = extractData($inputData, "-");
                foreach( $inputData as $element ) { 
                    if(!is_numeric($element)){
                        $correctData = false;
                        break;
                    } 
                    if($result == 0){
                        $result = $element;
                    }else{
                        $result = $result - $element;
                    }
                } 
                break;
            default:
                $correctData = false;
                $data = [ 'command' => strtolower($action), 'operation' => "-", 'result' => "Not Defined" ];
            }
        
        if($correctData){
            logCalculation(strtolower($action), $operation, $result, $operation ." = ". $result);
            $data = [ 'command' => strtolower($action), 'operation' => $operation, 'result' => $result ];
        }
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}
