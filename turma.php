<?php
//category.php
include 'connect.php';
include 'header.php';

//first select the category based on $_GET['cat_id']
$sql = "SELECT
			cat_id,
			cat_name,
			cat_description
		FROM
			categories
		WHERE
			cat_id = " . mysql_real_escape_string($_GET['id']);

$result = mysql_query($sql);

if (!$result) {
	echo 'Esta turma não está disponível, por favor tente mais tarde.' . mysql_error();
} else {
	if (mysql_num_rows($result) == 0) {
		echo 'Esta turma não existe!';
	} else {
		//display category data
		while ($row = mysql_fetch_assoc($result)) {
			echo '<h2>Recados para &prime;' . $row['cat_name'] . '&prime;</h2><br />';

			//funcao excluir turma (exclusiva coordenador)
			if (isset($_SESSION['signed_in'])) {

				if ($_SESSION['user_level'] == 1) {
					//the user is not an admin
					echo '
					<form action="" method="POST">
						<button name="btn_excluir" class="btn btn-mini btn-danger" type="submit" style="margin-bottom: 10px; float:right;">Excluir Turma</button>
					</form>';

					if (isset($_POST['btn_excluir'])) {

						$id = $_GET['id'];

						$sql2 = "DELETE FROM categories WHERE cat_id='$id'";

						if (mysql_query($sql2)) {

							echo 'Turma Excluida com Sucesso! <br>';
						} else {
							echo 'Não foi possível Excluir! <br>';
						}
					}
				}
			}

		}

		//do a query for the topics
		$sql = "SELECT	
					topic_id,
					topic_subject,
					topic_date,
					topic_cat
				FROM
					topics
				WHERE
					topic_cat = " . mysql_real_escape_string($_GET['id']);

		$result = mysql_query($sql);

		if (!$result) {
			echo 'Esta turma não pode ser exibida, tente mais tarde.';
		} else {
			if (mysql_num_rows($result) == 0) {
				echo 'Não há recados para esta turma.';
			} else {
				//prepare the table
				echo '<table border="1">
					  <tr>
						<th>Recado</th>
						<th>Data</th>
					  </tr>';

				while ($row = mysql_fetch_assoc($result)) {
					echo '<tr>';
					echo '<td class="leftpart">';
					echo '<h3><a href="recado.php?id=' . $row['topic_id'] . '">' . $row['topic_subject'] . '</a><br /><h3>';
					echo '</td>';
					echo '<td class="rightpart">';
					echo date('d-m-Y', strtotime($row['topic_date']));
					echo '</td>';
					echo '</tr>';

				}
				echo '</table>';
			}
		}
	}
}

include 'footer.php';
?>
