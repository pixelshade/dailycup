	<?php if($error != null) error_html($error,"");?>



	<div class="page-header">
		<h1 id="timeline">Daily cup of...</h1>
	</div>
	<ul class="timeline">



		<?php

//<iframe width="480" height="360" src="//www.youtube.com/embed/'.$video["filename"].'" frameborder="0" allowfullscreen></iframe>

		if(!empty($videos)){
			$left = true;
			foreach ($videos as $video) {
				$requests = file_get_contents("http://graph.facebook.com/".$video['uploader']);

				$fb_response = json_decode($requests);

				// var_dump($fb_response);



				if($left){
					echo '<li>';		
				} else {
					echo '<li class="timeline-inverted">';
				}
				echo '	<div class="timeline-badge"><img src="http://graph.facebook.com/'. $video["uploader"].'/picture?type=small&height=72&width=72" alt="'. $user_profile['username'].'" class="img-circle"></div>';
				echo '	<div class="timeline-panel">';
				echo '		<div class="timeline-heading">';
				echo '			<h4 class="timeline-title">'.$video["name"].'</h4>';
				echo '			<p><small class="text-muted"><i class="glyphicon glyphicon-time"></i>'.$video['date'].' by '.$fb_response->first_name.' '.$fb_response->last_name.'</small></p>';
				echo '		</div>';
				echo '		<div class="timeline-body">';				

				echo '<div class="vid">';
				echo '<iframe width="480" height="360" src="//www.youtube.com/embed/'.$video["video_id"].'" frameborder="0" allowfullscreen></iframe>';
				echo '</div>';
				echo '			<p>'.$video['description'].'</p>';
				echo '			<p>';
				// echo '				<a class="btn btn-success" href="/app_content/'.$video['filename'].'"><i class="fa fa-play"></i> Play</a>';
				if($user_profile['id'] == $video["uploader"]) echo '<a class="btn btn-danger pull-right" href="/video/delete_video/'.$video['id'].'"><i class="fa fa-trash-o fa-lg"></i> Delete</a>';		
				echo '			</p>';
				echo '		</div>';
				echo '	</div>';
				echo '</li>';

				$left = !$left;


			}
		}
		?>

	</ul>





