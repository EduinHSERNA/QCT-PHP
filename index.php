<?php
require('vendor/autoload.php');
use QCT\QCT;
use QCT\LinuxCommands;

$qct = new QCT();
$qct -> execute();
$linux_commands = new LinuxCommands();
$linux_commands -> execute();
$cirucit_name = htmlspecialchars($qct -> expression);
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
    <title>QCT- Quantum Circuit Tensor </title>
  </head>
  <body>
    <div style="text-align:center;">

      <p style="font-size:37pt; padding:15px">
        Quantum Circuit Tensor
      </p>

      <form  method="get">
        <input type="text" name="expression" placeholder="Enter the circuit" size="50" style="font-size:23pt;"/>
      </form>

      <p>
        Quantum Gate:
        <a href="?expression=[X][0]">Pauli-X  </a> |
	      <a href="?expression=[Y][0]">Pauli-Y  </a> |
	      <a href="?expression=[Z][0]">Pauli-Z  </a> |
        <a href="?expression=[\sqrt{X}][0]">Square root of NOT </a> |
        <a href="?expression=[CONTROL(2);U][i_1,i_2]">Controlled-U</a> |
      	<a href="?expression=[CONTROL(3);CONTROL(3);X][i_1,i_2,i_3]">Toffoli</a>
      </p>
      <p>
        Some circuit examples:
	      <a href="?expression=[X;CONTROL(1)][CONTROL(2);X][X;CONTROL(1)][i_1,i_2]"> Swap</a> |
	<a href="?expression=[H^{\otimes n}][0^{\otimes n}]"> Hadamard n</a> |
        <a href="?expression=[CONTROL(2);X][H;I][i,j]">Bell states</a> |
	<a href="?expression=[H;I][CONTROL(2);X][X;I][CONTROL(2);X][H;I][i,j]">Superdense Codings</a> |
	<a href="?expression=[I;CONTROL(3);X][CONTROL(2);X;I][H;I;I][i,j,k]">GHZ states</a>

      </p>

      <p>
        Some quantum algorithms:
	<a href="?expression=[H;I;I][CONTROL(2);R_\frac{\pi}{2};I][CONTROL(3);I;R_\frac{\pi}{4}][I;H;I][I;CONTROL(3);R_\frac{\pi}{2}][I;I;H][x_3,x_2,x_1]">
		Three-qubit Quantum Fourier Transform
	</a> |
	<a href="?expression=[CONTROL(4);I;I;X][I;CONTROL(4);I;X][I;I;CONTROL(4);X][I;I;I;e^{-i \bigtriangleup tZ}][I;I;CONTROL(4);X][I;CONTROL(4);I;X][CONTROL(4);I;I;X][,,,0]">
		Digital Quantum Simulation of k-local Hamiltonian
	 </a> |
	
	<a href="?expression=[R^\dagger;I;I][CONTROL(2);X;I][I;CONTROL(3);R_y\left(\theta\right)][CONTROL(2);X;I][R;I;I][b,0,1]">
		The simplest case for solving systems of linear equations
	 </a> 
      </p>

      <br>
      <hr>
      <br>

      <p style="font-size:15pt;"><?=$cirucit_name ?></p>

      <div style="padding:15px">
       <img src='tmp/circuit-1.png' alt="Circuit"/>
      </div>

      Select format to download:
      <a href="tmp/circuit.tex" target="_blank">tex</a> |
      <a href="tmp/circuit.pdf" target="_blank">pdf</a>

    <div>
  </body>
</html>
