<?php
namespace QCT;
class InputExpression{
    public $input_expression;
    public function __construct($expression){
        $this -> input_expression = $expression;
    }

    public function validate(){
        $expression = $this -> input_expression;
        $validator = new Validator($expression);
        $this -> input_expression = $validator -> validate();
    }

    public function matches(){
        $expression = $this -> input_expression;
        preg_match_all("/\[(.*?)\]/", $expression, $matches);
        return $matches;
    }
}
?>
