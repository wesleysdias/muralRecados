<?php 
session_start();
//connect.php
$server	    = 'localhost';
$username	= 'root';
$password	= '';
$database	= 'mural';

if(!mysql_connect($server, $username, $password))
{
 	exit('Erro: Não foi possível estabelecer uma conexão com o Bando de Dados');
}
if(!mysql_select_db($database))
{
 	exit('Erro: Não foi possível selecionar o Bando de Dados');
}
?>