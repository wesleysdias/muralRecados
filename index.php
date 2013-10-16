	<?php
//create_cat.php
include 'connect.php';
include 'header.php';

$sql = "SELECT
			categories.cat_id,
			categories.cat_name,
			categories.cat_description,
			COUNT(topics.topic_id) AS topics
		FROM
			categories
		LEFT JOIN
			topics
		ON
			topics.topic_id = categories.cat_id
		GROUP BY
			categories.cat_name, categories.cat_description, categories.cat_id";

$result = mysql_query($sql);

if(!$result)
{
	echo 'As turmas não podem ser exibidas, tente mais tarde.';
}
else
{
	if(mysql_num_rows($result) == 0)
	{
		echo 'Não há Turmas cadastradas!';
	}
	else
	{
		//prepare the table
		echo '<table border="1">
			  <tr>
				<th>Mural de Recados</th>
				<th>Último recado enviado</th>
			  </tr>';	
			
		while($row = mysql_fetch_assoc($result))
		{				
			echo '<tr>';
				echo '<td class="leftpart">';
					echo '<h3><a href="category.php?id=' . $row['cat_id'] . '">' . $row['cat_name'] . '</a></h3>' . $row['cat_description'];
				echo '</td>';
				echo '<td class="rightpart">';
				
				//recupera ultimo recado enviado
					$topicsql = "SELECT
									topic_id,
									topic_subject,
									topic_date,
									topic_cat
								FROM
									topics
								WHERE
									topic_cat = " . $row['cat_id'] . "
								ORDER BY
									topic_date
								DESC
								LIMIT
									1";
								
					$topicsresult = mysql_query($topicsql);
				
					if(!$topicsresult)
					{
						echo 'Último recado não pode ser exibido.';
					}
					else
					{
						if(mysql_num_rows($topicsresult) == 0)
						{
							echo 'Não há recados para esta Turma';
						}
						else
						{
							while($topicrow = mysql_fetch_assoc($topicsresult))
							echo '<a href="topic.php?id=' . $topicrow['topic_id'] . '">' . $topicrow['topic_subject'] . '</a> no Dia: ' . date('d-m-Y', strtotime($topicrow['topic_date']));
						}
					}
					echo '</td>';
				echo '</tr>';
			echo '</table>';
		}
	}
}

include 'footer.php';
?>
