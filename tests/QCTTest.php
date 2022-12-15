<?php
namespace QCT\Tests;

use QCT\QCT;

/**
 * @covers QCT\QCT
 */
class QCTTest extends \PHPUnit\Framework\TestCase{
    public function testConstructor(){
        $qct = new QCT();
        $this -> assertFalse(empty($qct -> expression));
    }

    public function testExecute(){
        $qct = new QCT();
        $qct -> execute();
        $input_expression = $qct -> expression;
        $this -> assertSame($qct -> expression, $input_expression);
    }
}
?>