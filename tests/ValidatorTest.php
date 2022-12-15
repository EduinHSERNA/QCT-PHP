<?php
namespace QCT\Tests;

use QCT\Validator;

/**
 * @covers QCT\Validator
 */
class ValidatorTest extends \PHPUnit\Framework\TestCase{
    const EXPRESSION='[H;I;I][CONTROL(2);R_\frac{\pi}{2};I][CONTROL(3);I;R_\frac{\pi}{4}][I;H;I][I;CONTROL(3);R_\frac{\pi}{2}][I;I;H][x_3,x_2,x_1]';  
    
    public function testConstruct(){
        $validator = new Validator(self::EXPRESSION);
        $validator_expression = $validator -> input_data;
        $this -> assertTrue($validator_expression == self::EXPRESSION);
    }

    public function testFailConstruct(){
        $fail_expression = 'H;I;ICONTROL(2);[x_3x_2,x_1';  
        $validator = new Validator($fail_expression);
        $validator_expression = $validator -> input_data;
        $this -> assertFalse($validator_expression == self::EXPRESSION);
    }

    public function testExpressionInsideBrackets(){
        $validator = new Validator(self::EXPRESSION);
        $validated = $validator -> expressionInsideBrackets(); 
        $this -> assertTrue($validated == self::EXPRESSION);
    }

    public function testFailExpressionInsideBrackets(){
        $fail_expression = 'H;I;ICONTROL(2);[x_3x_2,x_1';  
        $validator = new Validator($fail_expression);
        $validated = $validator -> expressionInsideBrackets(); 
        $this -> assertFalse($validated == $fail_expression);
        $this -> assertSame("Error: Input data must be inside brackets.", $validated);
    }

    public function testOneDimension(){
        $expression='[H][0]';
        $validator = new Validator($expression);
        $validated = $validator -> isOneDimension();
        $this -> assertTrue($validated == $expression);
    }

    public function testFailOneDimension(){
        $expression='[H][0,1]';
        $validator = new Validator($expression);
        $validated = $validator -> isOneDimension();
        $this -> assertFalse($validated == $expression);
        $this -> assertSame("Error: Qubits and gates columns must have the same dimensions.", $validated);
    }

    public function testQubitsSeparatedByColons(){
        $validator = new Validator(self::EXPRESSION);
        $validated = $validator -> qubitsSeparatedByColons();
        $this -> assertTrue($validated == self::EXPRESSION);
    }

    public function testFailQubitsSeparatedByColons(){
        $fail_expression = '[H;I;I;CONTROL(2)][x_3x_2x_1]';  
        $validator = new Validator($fail_expression);
        $validated = $validator -> qubitsSeparatedByColons();
        $this -> assertFalse($validated == $fail_expression);
        $this -> assertSame("Error: Qubits must be separated by colons.", $validated);
    }

    public function testGatesSeparatedBySemicolons(){
        $validator = new Validator(self::EXPRESSION);
        $validated = $validator -> gatesSeparatedBySemicolons();
        $this -> assertTrue($validated == self::EXPRESSION);
    }

    public function testfailGatesSeparatedBySemicolons(){
        $fail_expression = '[H,I,J][O;P;T][x_3,x_2,x_1]';  
        $validator = new Validator($fail_expression);
        $validated = $validator -> gatesSeparatedBySemicolons();
        $this -> assertFalse($validated == $fail_expression);
        $this -> assertSame("Error: Gates must be separated by semicolons.", $validated);
    }

    public function testGatesAndQubitsEqualSize(){
        $validator = new Validator(self::EXPRESSION);
        $validated = $validator -> gatesAndQubitsEqualSize();
        $this -> assertTrue($validated == self::EXPRESSION);
    }

    public function testFailGatesAndQubitsEqualSize(){
        $fail_expression = '[H;I;I;CONTROL(2);H][x_3,x_2,x_1]';  
        $validator = new Validator($fail_expression);
        $validated = $validator -> gatesAndQubitsEqualSize();
        $this -> assertFalse($validated == $fail_expression);
        $this -> assertSame("Error: Qubits and gates columns must have the same dimensions.", $validated);
    }

    public function testValidate(){
        $validator = new Validator(self::EXPRESSION);
        $validated = $validator -> validate();
        $this -> assertTrue($validated == self::EXPRESSION);
    }

    public function testFailValidate(){
        $fail_expression = 'HIICONTROL(2);Hx_3x_2x_1';  
        $validator = new Validator($fail_expression);
        $validated = $validator -> validate();
        $this -> assertFalse($validated == self::EXPRESSION);
    }
}
?>