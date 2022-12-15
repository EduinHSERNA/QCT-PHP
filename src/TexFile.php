<?php
namespace QCT;

class TexFile{
    public $tex_file;
	
    function __construct($file){
		$this -> tex_file = $file;
	}

    function top(){
		$file = $this -> tex_file;
        fwrite($file, "\\documentclass[]{standalone}"."\n");
        fwrite($file, "\\usepackage{tikz}"."\n");
        fwrite($file, "\\usetikzlibrary{backgrounds,decorations.pathreplacing,calc}"."\n");
        fwrite($file, "\\newcommand{\\ket}[1]{\\ensuremath{\\left|#1\\right\\rangle}}"."\n");
        fwrite($file, "\\begin{document}"."\n");
        fwrite($file, "\\begin{tikzpicture}[thick]"."\n");
        fwrite($file, "\\tikzstyle{box} = [draw,fill=white,minimum size=1.5em]"."\n");
        fwrite($file, "\\tikzstyle{control} = [draw,fill,shape=circle,minimum size=5pt,inner sep=0pt]"."\n");
        fwrite($file, "\\matrix[row sep=0.4cm, column sep=0.8cm] (circuit)"."\n");
        fwrite($file, "{ ");
    }

    function translator($matrix){
		$file = $this -> tex_file;
		$control = array();
		$target = array();
		$row = 1;
		foreach ($matrix as $operations) {
			$column = 1;

			fwrite($file, "% ".$row." Qubit"."\n");

			if ($operations[0] == ''){
			fwrite($file, "\\node (qubit_".$row.") {".$operations[0]."};"."\n");
			}
			else{

			fwrite($file, "\\node (qubit_".$row.") {\\ket{".$operations[0]."}};"."\n");
			}

			foreach (array_slice($operations, 1) as $value) {
				if (substr($value, 0, 7) == "CONTROL") {
				$tmp_value = $value;
				$value = 'C';
				}
				switch ($value) {
					case "I":
					fwrite($file, "&\n");
					break;
					case "C":
					fwrite($file, "& \\node[control] (M".$row.$column.") {};"."\n");
					array_push($control, $row.$column);
					preg_match_all('#\((.*?)\)#', $tmp_value, $element);
					array_push($target, $element[1][0].$column);
					break;
					default:
					fwrite($file, "& \\node[box] (M".$row.$column.") {".'$'.$value.'$'."};"."");
					break;
				}
				$column++;
			}
			fwrite($file, "&\\coordinate (end".$row.");\\\\\n");
			$row++;
		}
		fwrite($file, " };"."\n");
		fwrite($file, "\\begin{pgfonlayer}{background} \\draw[thick]"."\n");

		return [$control, $target];
    }

    function qubits($matrix){
		$file = $this -> tex_file;
		for ($row = 1; $row < count($matrix) + 1; $row++) {
			fwrite($file, "(qubit_".$row.") -- (end".$row.")"."\n");
		}
    }

    function control($control, $target){
		$file = $this -> tex_file;
		for ($index = 0; $index < count($control); $index++) {
			fwrite($file, "(M".$control[$index].") -- (M".$target[$index].")"."\n");
		}
    }

    function bottom(){
		$file = $this -> tex_file;
		fwrite($file, ";\n");
        fwrite($file, "\\end{pgfonlayer}"."\n");
        fwrite($file, "\\end{tikzpicture}"."\n");
        fwrite($file, "\\end{document}\n");
        fclose($file);
    }


}


?>
