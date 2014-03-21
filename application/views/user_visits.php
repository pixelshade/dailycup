


	<div class="page-header">
		<h1 id="timeline">Daily cup of...</h1>
	</div>
	

	<table class="table table-striped">
		
			<tr><th>id</th><th>user</th><th>name</th><th>time</th></tr>


		<?php

//<iframe width="480" height="360" src="//www.youtube.com/embed/'.$user_visit["filename"].'" frameborder="0" allowfullscreen></iframe>

		if(!empty($user_visits)){	
			foreach ($user_visits as $user_visit) {				
			echo "<tr><td>".$user_visit['id']."</td>";
			echo '<td><img src="http://graph.facebook.com/'. $user_visit["user_id"].'/picture?type=small&height=72&width=72" alt="'. $user_visit["user_id"].'" class="img-round">'.$user_visit["user_id"].'</td>';
			echo "<td>".$user_visit['name']."</td>";
			echo "<td>".$user_visit['visited']."</td></tr>";

		

			}
		}
		?>

	
		
	</table>





