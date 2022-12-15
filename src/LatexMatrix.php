<?php
namespace QCT;

class LatexMatrix{
    public function create($input_expression){
        $latex_matrix=array();
        array_push($latex_matrix, explode(",", array_pop($input_expression[1])));
        foreach (array_reverse($input_expression[1]) as $column) {
            array_push($latex_matrix, explode(";", $column));
        }
        return $latex_matrix;
    }

    public function transpose($latex_matrix){
        $transposed_matrix = array();
        foreach ($latex_matrix as $row_index => $rows) {
            foreach ($rows as $column_index => $columns) {
                $transposed_matrix[$column_index][$row_index] = $columns;
            }
        }
        return $transposed_matrix;
    }
}
?>