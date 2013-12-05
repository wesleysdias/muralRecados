<?php
//create_cat.php
include 'connect.php';
include 'header.php';

$sql = "SELECT
			topic_id,
			topic_subject
		FROM
			topics
		WHERE
			topics.topic_id = " . mysql_real_escape_string($_GET['id']);

$result = mysql_query($sql);

if (!$result) {
	echo 'Os recados não poderam ser exibidos, por favor tente mais tarde.';
} else {
	if (mysql_num_rows($result) == 0) {
		echo 'Este recado não existe!';
	} else {
		while ($row = mysql_fetch_assoc($result)) {
			//display post data
			echo '<table class="topic" border="1">
					<tr>
						<th colspan="2">' . $row['topic_subject'] . '</th>
					</tr>';

			//fetch the posts from the database
			$posts_sql = "SELECT
						posts.post_topic,
						posts.post_content,
						posts.post_date,
						posts.post_by,
						users.user_id,
						users.user_name
					FROM
						posts
					LEFT JOIN
						users
					ON
						posts.post_by = users.user_id
					WHERE
						posts.post_topic = " . mysql_real_escape_string($_GET['id']);

			$posts_result = mysql_query($posts_sql);

			if (!$posts_result) {
				echo '<tr><td>Os recados não poderam ser exibidos, por favor tente mais tarde.</tr></td></table>';
			}
			 else {

				while ($posts_row = mysql_fetch_assoc($posts_result)) {
					echo '<tr class="topic-post">
							<td class="user-post">' . $posts_row['user_name'] . '<br/>' . date('d-m-Y H:i', strtotime($posts_row['post_date'])) . '</td>
							<td class="post-content">' . htmlentities(stripslashes($posts_row['post_content'])) . '</td>
						  </tr>';
				}
			}

			if (!isset($_SESSION['signed_in'])) {
				echo '<tr><td colspan=2>Você precisa ter acesso ao sitema para responder, <a href="entrar.php">Clique aqui</a> para entrar. 
				Se ainda não tem uma conta, <a href="cadastrar.php">Clique aqui</a> para cria-la.';
			} else {
				//show reply box
				echo '<tr><td colspan="2"><h2>Resposta:</h2><br />
					<form method="post" action="resposta.php?id=' . $row['topic_id'] . '">
						<textarea name="reply-content"></textarea><br /><br />
						<input type="submit" class="btn" value="Enviar Resposta" />
					</form></td></tr>';
			}

			//finish the table
			echo '</table>';
		}
	}
}

include 'footer.php';
?>