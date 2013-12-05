<?php
//signup.php
include 'connect.php';
include 'header.php';

echo '<h3>Criar um conta de usuário</h3><br />';

if($_SERVER['REQUEST_METHOD'] != 'POST')
{
    /*the form hasn't been posted yet, display it
	  note that the action="" will cause the form to post to the same page it is on */
    echo '<form class="form-horizontal" method="post" action="">
    		<div class="control-group">
    			
			 	 <label class="control-label">Nome: </label> 
			 	 	<div class="controls">
			 	 		<input type="text" name="user_name" />
			 	 	</div>
			 </div>

			 <div class="control-group">
			 		<label class="control-label">Senha:</label>
			 		<div class="controls"> 
			 			<input type="password" name="user_pass">
			 		</div>
			 </div>
			 <div class="control-group">
					<label class="control-label">Confirme a senha:</label>
					<div class="controls"> 
						<input type="password" name="user_pass_check">
					</div>
			</div>
			<div class="control-group">
					<label class="control-label">E-mail:</label>
					<div class="controls">  
						<input type="email" name="user_email">
					</div>
			</div>
			<div class="control-group">			
					<div class="controls"> 
					<button class="btn" type="submit">Criar Conta</button> 
					</div>		
			</div>	
				
 	 </form>';
}
else
{
    /* Validação	*/
	$errors = array(); /* array para erros */
	
	if(isset($_POST['user_name']))
	{
		//the user name exists
		if(!ctype_alnum($_POST['user_name']))
		{
			$errors[] = 'O Nome de usuário deve conter apenas letras.';
		}
		if(strlen($_POST['user_name']) > 30)
		{
			$errors[] = 'O Nome de usuário deve menor que 30 caracteres.';
		}
	}
	else
	{
		$errors[] = 'O Nome de usuário não pode ser vazio.';
	}
	
	
	if(isset($_POST['user_pass']))
	{
		if($_POST['user_pass'] != $_POST['user_pass_check'])
		{
			$errors[] = 'Senhas diferentes.';
		}
		if($_POST['user_pass'] == "")
		{
			$errors[] = 'O campo Senha não pode ser vazio.';
		}
	}
	else
	{
		$errors[] = 'O campo Senha não pode ser vazio';
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
	}
	else
	{
		//the form has been posted without, so save it
		//notice the use of mysql_real_escape_string, keep everything safe!
		//also notice the sha1 function which hashes the password
		$sql = "INSERT INTO
					users(user_name, user_pass, user_email ,user_date, user_level)
				VALUES('" . mysql_real_escape_string($_POST['user_name']) . "',
					   '" . sha1($_POST['user_pass']) . "',
					   '" . mysql_real_escape_string($_POST['user_email']) . "',
						NOW(),
						0)";
						
		$result = mysql_query($sql);
		if(!$result)
		{
			//something went wrong, display the error
			echo 'Algo de errado ocorreu ao tentar criar uma conta. Por favor tente mais tarde.';
			//echo mysql_error(); //debugging purposes, uncomment when needed
		}
		else
		{
			echo 'Conta criada com Sucesso. Agora você pode <a href="entrar.php">Entrar</a> e enviar/responder os recados! :-)';
		}
	}
}

include 'footer.php';
?>
