<?php
namespace QCT;

class LinuxCommands{
    function execute(){
        shell_exec("cd tmp;pdflatex circuit.tex;chmod 777 circuit.tex;printf executed;");
        shell_exec("cd tmp;pdftoppm circuit.pdf -png circuit;printf executed;");
    }
}
?>