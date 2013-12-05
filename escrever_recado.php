<?php
//create_topic.php
include 'connect.php';
include 'header.php';

echo '<h3>Enviar Recado</h3><br />';
if(isset($_SESSION['signed_in']) == false)
{
	//usuario nao esta logado...
	echo 'Para enviar um recado acesse o sistema <a href="entrar.php">Clique aqui</a>.';
}
else
{
	//usuario logado
	if($_SERVER['REQUEST_METHOD'] != 'POST')
	{	
		//form ainda não foi postado, mostrar
		//select nas turmas criadas
		$sql = "SELECT
					cat_id,
					cat_name,
					cat_description
				FROM
					categories";
		
		$result = mysql_query($sql);
		
		if(!$result)
		{
			//erro banco, uh-oh :-(
			echo 'Erro ao selecionar o Banco de Dados, tente novamente.';
		}
		else
		{
			if(mysql_num_rows($result) == 0)
			{
				//Não turmas para enviar mensagem
				if($_SESSION['user_level'] == 1)
				{
					echo 'Não existe turma cadastrada.';
				}
				else
				{
					echo 'Antes de enviar um recado, aguarde a turma ser criada.';
				}
			}
			else
			{
		
				echo '<form name="form" onsubmit="return valida(this);" class="form-horizontal" method="post" action="">
								    		<div class="control-group">
								    			<label class="control-label">Assunto: </label> 
											 		<div class="controls">
											 			<input class="span5" type="text" name="topic_subject" />
											 		</div>
										    </div>'; 
				
				echo ' <div class="control-group">
						<label class="control-label">Turma: </label>
								  <div class="controls">						
								<select name="topic_cat">';
					while($row = mysql_fetch_assoc($result))
					{
						echo '<option value="' . $row['cat_id'] . '">' . $row['cat_name'] . '</option>';
					}
				echo '</select>
						</div>
						</div>';	
				
					
				echo '<div class="control-group">
						<label class="control-label">Recado: </label>
						<div class="controls">		
						<textarea name="post_content" /></textarea><br /><br />
					<input class="btn" type="submit" value="Enviar Recado" />
					</div>
					</div>				
				 </form>';
			}		
		
		}
	}
	
	
	else
	{
		 /* Validação	*/
		 
			$errors = array(); /* array para erros */
			
			if(isset($_POST['topic_subject']))
			{
				//the user name exists
				if($_POST['topic_subject']=="")
				{
					$errors[] = 'O Assunto não pode ser vazio.';
				}
				if(strlen($_POST['topic_subject']) > 30)
				{
					$errors[] = 'O Assunto deve ser menor que 30 caracteres.';
				}
				if($_POST['post_content']=="")
				{
					$errors[] = 'O Recado não pode ser vazio.';
				}
			}
			
				
		//começo da transação
		$query  = "BEGIN WORK;";
		$result = mysql_query($query);
		
		if(!$result)
		{
			//Damn! falha na consulta
			echo 'Erro ao enviar o recado. Por favor, tente mais tarde.';
			
		}
		if(!empty($errors)) /*verifica se o array esta vazio, se existe erros eles estao aqui*/
		{
			echo 'Alguns erros foram encontrados..<br /><br />';
			echo '<ul>';
			foreach($errors as $key => $value) /* ande pelo array e exiba caso tenha erros */
			{
				echo '<li>' . $value . '</li>'; /* gera lista de erros */
			}
			echo '</ul>';
			echo '<input type="button" class="btn btn-mini" value="Voltar" onClick="JavaScript: window.history.back();">';
		}
		else
		{
			
	
			//o form foi postado, salve!
			//insira o recado primeiro na tabela, depois salveremos na tabela post
			$sql = "INSERT INTO 
						topics(topic_subject,
							   topic_date,
							   topic_cat,
							   topic_by)
				   VALUES('" . mysql_real_escape_string($_POST['topic_subject']) . "',
							   NOW(),
							   " . mysql_real_escape_string($_POST['topic_cat']) . ",
							   " . $_SESSION['user_id'] . "
							   )";
					 
			$result = mysql_query($sql);
			if(!$result)
			{
				//algo deu errado, mostre o erro.
				echo 'Erro ao enviar o recado. Por favor, tente mais tarde.<br /><br />' . mysql_error();
				$sql = "ROLLBACK;";
				$result = mysql_query($sql);
			}
			else
			{
				//the first query worked, now start the second, posts query
				//retrieve the id of the freshly created topic for usage in the posts query
				$topicid = mysql_insert_id();
				
				$sql = "INSERT INTO
							posts(post_content,
								  post_date,
								  post_topic,
								  post_by)
						VALUES
							('" . mysql_real_escape_string($_POST['post_content']) . "',
								  NOW(),
								  " . $topicid . ",
								  " . $_SESSION['user_id'] . "
							)";
				$result = mysql_query($sql);
				
				if(!$result)
				{
					//algo deu errado, mostre o erro.
					echo 'Erro ao enviar o recado. Por favor, tente mais tarde.<br /><br />' . mysql_error();
					$sql = "ROLLBACK;";
					$result = mysql_query($sql);
				}
				else
				{
					$sql = "COMMIT;";
					$result = mysql_query($sql);
					
					//recado enviado com secesso!
					echo '<a href="recado.php?id='. $topicid . '">Recado</a> enviado com sucesso!';
				}
			}
		}
		
	}
	
}

include 'footer.php';
?>
