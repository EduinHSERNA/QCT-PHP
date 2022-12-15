<?php
namespace QCT\Tests;

use QCT\InputExpression;

/**
 * @covers QCT\InputExpression
 */
class InputExpressionTest extends \PHPUnit\Framework\TestCase{
    const WORKING_EXPRESSION='[CONTROL(3);CONTROL(3);X][i_1,i_2,i_3]';  
    const BAD_EXPRESSION='H;I;ICONTROL(2);R_\frac{ac{\pi}{4}I;H;II;CONTROL(3);R_\frac{\pi}{2}I;I;Hx_3,x_2,x_1';  
    public function testFailInclude(){
        $input_expression = new InputExpression(self::BAD_EXPRESSION);
        $input_expression -> validate();
        $returned_expression = $input_expression -> input_expression;
        $this -> assertFalse($returned_expression == self::BAD_EXPRESSION);
    }

    public function testInclude(){
        $input_expression = new InputExpression(self::WORKING_EXPRESSION);
        $input_expression -> validate();
        $returned_expression = $input_expression -> input_expression;
        $this -> assertTrue($returned_expression == self::WORKING_EXPRESSION);
    }

    public function testFailConstruct(){
        $input_expression = new InputExpression(self::BAD_EXPRESSION);
        $input_expression = $input_expression -> input_expression;
        $this -> assertFalse($input_expression == self::WORKING_EXPRESSION);
    }
    
    public function testConstruct(){
        $input_expression = new InputExpression(self::WORKING_EXPRESSION);
        $input_expression = $input_expression -> input_expression;
        $this -> assertTrue($input_expression == self::WORKING_EXPRESSION);
    }

    public function testFailValidate(){
        $input_expression = new InputExpression(self::BAD_EXPRESSION);
        $input_expression -> validate();
        $input_expression = $input_expression -> input_expression;
        $this -> assertFalse($input_expression == self::BAD_EXPRESSION);
    }

    public function testValidate(){
        $input_expression = new InputExpression(self::WORKING_EXPRESSION);
        $input_expression -> validate();
        $input_expression = $input_expression -> input_expression;
        $this -> assertTrue($input_expression == self::WORKING_EXPRESSION);
    }

    public function testFailMatches(){
        $input_expression = new InputExpression(self::BAD_EXPRESSION);
        $returned_matches = $input_expression -> matches();
        $this -> assertEmpty($returned_matches[0]);
        $this -> assertEmpty($returned_matches[1]);
    }

    public function testMatches(){
        $input_expression = new InputExpression(self::WORKING_EXPRESSION);
        $returned_matches = $input_expression -> matches();
        $this -> assertTrue(sizeof($returned_matches[0]) > 0);
        $this -> assertTrue(sizeof($returned_matches[1]) > 0);
    }
}
?>
