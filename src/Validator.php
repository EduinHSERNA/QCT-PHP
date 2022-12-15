<?php
namespace QCT;

class Validator{
    public $input_data;
    
    function __construct($data){
        $this -> input_data = $data;
    }

    function validate(){
        return $this -> expressionInsideBrackets();
    }

    function expressionInsideBrackets(){
        $data = $this -> input_data;
        preg_match_all("/\[(.*?)\]/", $data, $inside_brackets);
        $closing_brackets = explode(']',$data);
        $opening_brackets = explode('[',$data);
        array_pop($closing_brackets);
        array_pop($opening_brackets);
        $closing_brackets = sizeof($closing_brackets);
        $opening_brackets = sizeof($opening_brackets);
        if(empty($inside_brackets[0]) || $opening_brackets != $closing_brackets){
            return "Error: Input data must be inside brackets.";
        }
        return $this -> isOneDimension();
    }

    function isOneDimension(){
        $data = $this -> input_data;
        $data_to_array = explode(']', $data);
        array_pop($data_to_array);
        $last_row_elements = explode(',', $data_to_array[sizeof($data_to_array) - 1]);
        $first_row_elements = explode(';', $data_to_array[0]);
        if(sizeof($last_row_elements) + sizeof($first_row_elements) === 2){
            return $this -> gatesAndQubitsEqualSize();
        }
        return $this -> qubitsSeparatedByColons();
    }
    
    function qubitsSeparatedByColons(){
        $data = $this -> input_data;
        $data_to_array = explode(']', $data);
        array_pop($data_to_array);
        $last_row = $data_to_array[sizeof($data_to_array) - 1];
        if (!strpos($last_row, ',') || strpos($last_row, ';')){
            return "Error: Qubits must be separated by colons.";
        }
        return $this -> gatesSeparatedBySemicolons();
    }
    
    function gatesSeparatedBySemicolons(){
        $data = $this -> input_data;
        $data_to_array = explode(']', $data);
        array_pop($data_to_array);
        array_pop($data_to_array);
        $expected_length = sizeof(explode(';', $data_to_array[0]));
        foreach($data_to_array as $operations){
            $operators = explode(';', $operations);
            if (sizeof($operators) != $expected_length){
                return "Error: Gates must be separated by semicolons.";
            }
        }
        return $this -> gatesAndQubitsEqualSize();
    }

    function gatesAndQubitsEqualSize(){
        $data = $this -> input_data;
        $data_to_array = explode(']', $data);
        array_pop($data_to_array);
        $last_row_elements = explode(',', $data_to_array[sizeof($data_to_array) - 1]);
        $first_row_elements = explode(';', $data_to_array[0]);
        $first_row_elements = array_filter($first_row_elements, create_function('$value', 'return $value !== "";'));
        if (sizeof($last_row_elements) != sizeof($first_row_elements)){
            return "Error: Qubits and gates columns must have the same dimensions.";
        }
        return $this -> input_data;
    }
}
?>
