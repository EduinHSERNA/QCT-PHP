<?php
namespace QCT;
class QCT{
    public $expression;
    
    public function __construct(){
        $this -> expression='[H;I;I][CONTROL(2);R_\frac{\pi}{2};I][CONTROL(3);I;R_\frac{\pi}{4}][I;H;I][I;CONTROL(3);R_\frac{\pi}{2}][I;I;H][x_3,x_2,x_1]';  
        if (array_key_exists('expression', $_GET)) {
            $this -> expression=$_GET['expression'];
        }
    }

    public function execute(){
        $circuit_expression = $this -> expression;
        $input_expression = new InputExpression($circuit_expression);
        $input_expression -> validate();
        if($input_expression -> input_expression == $circuit_expression){
            $tex_matrix = new LatexMatrix();
            $matches = $input_expression -> matches();
            $new_tex_matrix = $tex_matrix -> create($matches);
            $transposed_matrix = $tex_matrix -> transpose($new_tex_matrix);
            $file=fopen("tmp/circuit.tex","w");
            $tex_file = new TexFile($file);
            $tex_file -> top();
            [$control, $target]=$tex_file -> translator($transposed_matrix);
            $tex_file -> qubits($transposed_matrix);
            $tex_file -> control($control,$target);
            $tex_file -> bottom();
        }
        $this -> expression = $input_expression -> input_expression;
    }
}
?>
