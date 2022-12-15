<?php
namespace QCT\Tests;

use QCT\TexFile;
use QCT\InputExpression;
use QCT\LatexMatrix;

/**
 * @covers QCT\TexFile
 */
class TexFileTest extends \PHPUnit\Framework\TestCase{

    public function testConstruct(){
		$file = fopen("tmp/circuit.tex","w");
        $tex_file = new TexFile($file);
        $this -> assertFalse(empty($tex_file -> tex_file));
    }

    public function testFailConstruct(){
		$file = "";
        $tex_file = new TexFile($file);
        $this -> assertEmpty($tex_file -> tex_file);
    }

    public function testTop(){
        $file = fopen("tmp/circuit.tex","w");
        $tex_file = new TexFile($file);
        $tex_file -> top();
        $file = fopen("tmp/circuit.tex","r");
        $this -> assertFalse(empty($file));
    }

    public function testTranslator(){
        $expression = '[CONTROL(4);I;I;X][I;CONTROL(4);I;X][I;I;CONTROL(4);X][I;I;I;e^{-i \bigtriangleup tZ}][I;I;CONTROL(4);X][I;CONTROL(4);I;X][CONTROL(4);I;I;X][,,,0]';
        $input_expression = new InputExpression($expression);
        $latex_matrix_instance = new LatexMatrix();
        $input_expression -> validate();
        $matches = $input_expression -> matches();
        $latex_matrix = $latex_matrix_instance -> create($matches);
        $transposed_matrix = $latex_matrix_instance -> transpose($latex_matrix);
        $input_file = fopen("tmp/circuit.tex","w");
        $tex_file = new TexFile($input_file);
        $translator_response = $tex_file -> translator($transposed_matrix);
        $output_file = fopen("tmp/circuit.tex","w");
        $this -> assertFalse(empty($translator_response));
        $this -> assertIsArray($translator_response);
        $this -> assertIsArray($translator_response[0]);
        $this -> assertIsArray($translator_response[1]);
        $this -> assertIsString($translator_response[0][0]);
        $this -> assertIsString($translator_response[1][1]);
        $this -> assertFalse($input_file === $output_file);
    }

    public function testFailTranslator(){
        $expression = '[H][,]';
        $input_expression = new InputExpression($expression);
        $latex_matrix_instance = new LatexMatrix();
        $input_expression -> validate();
        $matches = $input_expression -> matches();
        $latex_matrix = $latex_matrix_instance -> create($matches);
        $transposed_matrix = $latex_matrix_instance -> transpose($latex_matrix);
        $file = fopen("tmp/circuit.tex","w");
        $tex_file = new TexFile($file);
        $translator_response = $tex_file -> translator($transposed_matrix);
        $this -> assertFalse(empty($translator_response));
        $this -> assertIsArray($translator_response);
        $this -> assertEmpty($translator_response[0]);
        $this -> assertEmpty($translator_response[1]);
    }

    public function testQubits(){
        $expression = '[CONTROL(4);I;I;X][I;CONTROL(4);I;X][I;I;CONTROL(4);X][I;I;I;e^{-i \bigtriangleup tZ}][I;I;CONTROL(4);X][I;CONTROL(4);I;X][CONTROL(4);I;I;X][,,,0]';
        $input_expression = new InputExpression($expression);
        $latex_matrix_instance = new LatexMatrix();
        $input_expression -> validate();
        $matches = $input_expression -> matches();
        $latex_matrix = $latex_matrix_instance -> create($matches);
        $transposed_matrix = $latex_matrix_instance -> transpose($latex_matrix);
        $input_file = fopen("tmp/circuit.tex","w");
        $tex_file = new TexFile($input_file);
        $tex_file -> qubits($transposed_matrix);
        $output_file = fopen("tmp/circuit.tex","w");
        $this -> assertFalse($input_file === $output_file);
    }

    public function testControl(){
        $expression = '[CONTROL(4);I;I;X][I;CONTROL(4);I;X][I;I;CONTROL(4);X][I;I;I;e^{-i \bigtriangleup tZ}][I;I;CONTROL(4);X][I;CONTROL(4);I;X][CONTROL(4);I;I;X][,,,0]';
        $input_expression = new InputExpression($expression);
        $latex_matrix_instance = new LatexMatrix();
        $input_expression -> validate();
        $matches = $input_expression -> matches();
        $latex_matrix = $latex_matrix_instance -> create($matches);
        $transposed_matrix = $latex_matrix_instance -> transpose($latex_matrix);
        $input_file = fopen("tmp/circuit.tex","w");
        $tex_file = new TexFile($input_file);
        $translator_response = $tex_file -> translator($transposed_matrix);
        $translator_response = $tex_file -> control($transposed_matrix[0], $transposed_matrix[1]);
        $output_file = fopen("tmp/circuit.tex","w");
        $this -> assertFalse($input_file === $output_file);
    }

    public function testBottom(){
        $input_file = fopen("tmp/circuit.tex","w");
        $tex_file = new TexFile($input_file);
        $translator_response = $tex_file -> bottom();
        $output_file = fopen("tmp/circuit.tex","w");
        $this -> assertFalse($input_file === $output_file);
    }
}
?>