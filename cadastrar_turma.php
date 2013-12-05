<?php


//create_cat.php
include 'connect.php';
include 'header.php';

echo '<h3>Criar uma Nova Turma</h3><br />';
if (isset ($_SESSION['signed_in']) == false | isset ($_SESSION['user_level']) != 1) {
	//the user is not an admin
	echo 'Desculpe, você não tem permissão para acessar esta página.';
} else {
	//the user has admin rights
	if ($_SERVER['REQUEST_METHOD'] != 'POST') {
		//the form hasn't been posted yet, display it
		echo '<form class="form-horizontal" method="post" action="">
														    		<div class="control-group">								    			
																	 	 <label class="control-label">Nome: </label> 
																	 	 	<div class="controls">
																	 	 		<input class="span5" type="text" name="cat_name" placeholder="Ex: 1º Semestre"/>
																	 	 	</div>
																	 </div>
																	 <div class="control-group">
																	 		<label class="control-label">Descrição:</label>
																	 		<div class="controls"> 
																	 			<textarea rows="3" name="cat_description"></textarea>
																	 		</div>
																	 </div>					 					 			
																	<div class="control-group">			
																			<div class="controls"> 
																			<button class="btn" type="submit">Cadastrar</button> 
																			</div>		
																	</div>									
														 	 </form>';
	} else {

		/* Validação	*/

		$errors = array (); /* array para erros */

		if (isset ($_POST['cat_name'])) {
			//the user name exists
			if ($_POST['cat_name'] == "") {
				$errors[] = 'O Nome da Turma não pode ser vazio.';
			}
			if (strlen($_POST['cat_name']) > 30) {
				$errors[] = 'O Nome da Turma deve ser menor que 30 caracteres.';
			}
			if ($_POST['cat_description'] == "") {
				$errors[] = 'A Descrição não pode ser vazia.';
			}
		}

		if (!empty ($errors)) /*verifica se o array esta vazio, se existe erros eles estao aqui*/ {
			echo 'Alguns erros foram encontrados..<br /><br />';
			echo '<ul>';
			foreach ($errors as $key => $value) /* ande pelo array e exiba caso tenha erros */ {
				echo '<li>' . $value . '</li>'; /* gera lista de erros */
			}
			echo '</ul>';
			echo '<input type="button" class="btn btn-mini" value="Voltar" onClick="JavaScript: window.history.back();">';
		} else {

			//the form has been posted, so save it
			$sql = "INSERT INTO categories(cat_name, cat_description)
																	   VALUES('" . mysql_real_escape_string($_POST['cat_name']) . "',
																			 '" . mysql_real_escape_string($_POST['cat_description']) . "')";
			$result = mysql_query($sql);
			if (!$result) {
				//mostra o erro!
				echo 'Erro: ' . mysql_error();
			} else {
				echo 'Nova turma criada com sucesso!';
			}
		}
	}
}

include 'footer.php';
?>
