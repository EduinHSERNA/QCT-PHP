#!/bin/bash
#Author: EHS(11.28.19)

echo "********************************************************************"
echo "*                                                                  *"
echo "*          QCT v0.1 Script: Requirements Installation              *"
echo "*                                                                  *"
echo "********************************************************************"
 
 sudo apt install apache2
 sudo apt-get install texlive-latex-base
 sudo apt-get install poppler-utils
 sudo apt-get install php-xml
 sudo apt-get install php-mbstring
 sudo apt-get update
 sudo mkdir tmp
 sudo chmod 777 -R ./tmp

echo ""
echo ""
echo "Requirements installed!!"
echo ""
echo "" 
