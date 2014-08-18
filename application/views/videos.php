	<?php if($error != null) error_html($error,"");?>

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=829214510425768&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

	<div class="page-header">
		<h1 id="timeline">Daily cup of...</h1>
	</div>
	<?php
echo $pagination;
?>
	<ul class="timeline">



		<?php

//<iframe width="480" height="360" src="//www.youtube.com/embed/'.$video["filename"].'" frameborder="0" allowfullscreen></iframe>

		if(!empty($videos)){
			
			foreach ($videos as $video) {
				$requests = file_get_contents("http://graph.facebook.com/".$video['uploader']);

				$fb_response = json_decode($requests);

				echo '<div id="'.$video['id'].'""></div>';

				// echo ' 		<div class="row">';
				// echo '		<div class="col-3-md">';
				echo '	<div class="timeline-badge center"><img src="http://graph.facebook.com/'. $video["uploader"].'/picture?type=small&height=72&width=72" alt="'.$fb_response->first_name.'" title="'.$fb_response->first_name.'" class="img-circle"></div>';
				echo '			<h2 class="timeline-title">'.$video["name"].'</h2>';
				if($user_profile['id'] == $video["uploader"]) echo '<a class="btn btn-danger" href="/video/delete_video/'.$video['id'].'"><i class="fa fa-trash-o fa-lg"></i> Delete</a>';		
				echo '			<p><small class="text-muted"><i class="glyphicon glyphicon-time"></i>'.$video['date'].' by '.$fb_response->first_name.' '.$fb_response->last_name.'</small></p>';
				// echo '		</div>';
				// echo '		<div class="col-5-md">';
				echo '			<p>'.$video['description'].'</p>';				
				// echo '		</div>';
				
				// echo '		</div>';
				echo '		<div class="timeline-body">';				

				echo '<div class="vid">';
				echo '<iframe width="480" height="360" src="//www.youtube.com/embed/'.$video["video_id"].'" frameborder="0" allowfullscreen></iframe>';
				echo '</div>';
				echo '			<p>';
				// echo '			<p>';
				echo '				<div class="fb-comments" data-href="http://dailycup.skeletopedia.sk/#'.$video['id'].'"  data-numposts="5" data-colorscheme="dark"></div>';
				// echo '			</p>';
				// echo '				<a class="btn btn-success" href="/app_content/'.$video['filename'].'"><i class="fa fa-play"></i> Play</a>';
				
				echo '			</p>';
				
				echo '		</div>';
				// echo '	</div>';
				
				

			}
		}
		?>

	</ul>
<?php
echo $pagination;
?>
	




