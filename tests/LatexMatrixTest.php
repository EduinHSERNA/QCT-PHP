<?php
namespace QCT\Tests;

use QCT\InputExpression;
use QCT\LatexMatrix;

/**
 * @covers QCT\LatexMatrix
 */
class LatexMatrixTest extends \PHPUnit\Framework\TestCase{
    const EXPRESSION='[CONTROL(3);CONTROL(3);X][i_1,i_2,i_3]';  
    
    public function testCreate(){
        $input_expression = new InputExpression(self::EXPRESSION);
        $latex_matrix = new LatexMatrix();
        $input_expression -> validate();
        $matches = $input_expression -> matches();
        $latex_matrix = $latex_matrix -> create($matches);
        $this -> assertIsArray($latex_matrix);
        $this -> assertCount(sizeof($matches[0]), $latex_matrix);
        $this -> assertIsArray($latex_matrix[0]);
        $this -> assertIsString($latex_matrix[0][0]);
    }
    
    public function testTranspose(){
        $input_expression = new InputExpression(self::EXPRESSION);
        $latex_matrix_instance = new LatexMatrix();
        $input_expression -> validate();
        $matches = $input_expression -> matches();
        $latex_matrix = $latex_matrix_instance -> create($matches);
        $transposed_matrix = $latex_matrix_instance -> transpose($latex_matrix);
        $this -> assertIsArray($transposed_matrix);
        foreach ($latex_matrix as $row_index => $rows) {
            foreach ($rows as $column_index => $columns) {
                $this -> assertSame($transposed_matrix[$column_index][$row_index], $latex_matrix[$row_index][$column_index]);
            }
        }
    }
}
?>
