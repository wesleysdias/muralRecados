<?php
//create_cat.php
include 'connect.php';
include 'header.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
	//someone is calling the file directly, which we don't want
	echo 'This file cannot be called directly.';
} else {
	//check for sign in status
	if (!$_SESSION['signed_in']) {
		echo 'Acesse o sistema para responder o recado.';
	}
	/* Validação	*/

	$errors = array();
	/* array para erros */

	if (isset($_POST['reply-content'])) {
		//the user name exists
		if ($_POST['reply-content'] == "") {
			$errors[] = 'A Resposta não pode ser vazia.';
		}

	}

	if (!empty($errors))/*verifica se o array esta vazio, se existe erros eles estao aqui*/
	{
		echo 'Alguns erros foram encontrados..<br /><br />';
		echo '<ul>';
		foreach ($errors as $key => $value)/* ande pelo array e exiba caso tenha erros */
		{
			echo '<li>' . $value . '</li>';/* gera lista de erros */
		}
		echo '</ul>';
		echo '<input type="button" class="btn btn-mini" value="Voltar" onClick="JavaScript: window.history.back();">';
	} else {
		//a real user posted a real reply
		$sql = "INSERT INTO 
					posts(post_content,
						  post_date,
						  post_topic,
						  post_by) 
				VALUES ('" . $_POST['reply-content'] . "',
						NOW(),
						" . mysql_real_escape_string($_GET['id']) . ",
						" . $_SESSION['user_id'] . ")";

		$result = mysql_query($sql);

		if (!$result) {
			echo 'Sua resposta não foi enviada, por favor tente mais tarde.';
		} else {
			echo 'Resposta enviada, para ver o histórico <a href="recado.php?id=' . htmlentities($_GET['id']) . '">Clique aqui</a>.';
		}
	}
}

include 'footer.php';
?>