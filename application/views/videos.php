<?php
if($user_profile != NULL){
	?>
	<?php if($error != null) error_html($error,"");?>
	<div id="upload_div">
	<div>
	<button id="upload_btn" type="button" class="btn btn-success btn-circle btn-xl"><i class="glyphicon glyphicon-upload"></i></button>
	<h1 class="noblock">Upload</h1>
	
	<div id="upload" class="well">
		<!-- <h1>Upload File</h1> -->
		<?php echo form_open_multipart('/video/upload_file');?>
		<p>
			<input type="text" class="form-control" placeholder="Video name" name="name" id="name" size="20"><br />
			<input type="file" name="userfile" id="userfile" size="20"><br />
			(max. 47MB) zatial<br/>
			<input type="submit" class="btn btn-primary" name="submit" id="submit" value="upload" />
		</p>
		</form>
		</div>
	</div>
	</div>


<div class="page-header">
	<h1 id="timeline">Daily cup of...</h1>
</div>
<ul class="timeline">



	<?php

//<iframe width="480" height="360" src="//www.youtube.com/embed/'.$video["filename"].'" frameborder="0" allowfullscreen></iframe>

	if(!empty($videos)){
		$left = true;
		foreach ($videos as $video) {

			if($left){
				echo '<li>';		
			} else {
				echo '<li class="timeline-inverted">';
			}
			echo '	<div class="timeline-badge"><img src="http://graph.facebook.com/'. $video["uploader"].'/picture?type=small&height=72&width=72" alt="'. $user_profile['username'].'" class="img-circle"></div>';
			echo '	<div class="timeline-panel">';
			echo '		<div class="timeline-heading">';
			echo '			<h4 class="timeline-title">'.$video["name"].'</h4>';
			echo '			<p><small class="text-muted"><i class="glyphicon glyphicon-time"></i>'.$video['date'].' by '.$video['uploader'].'</small></p>';
			echo '		</div>';
			echo '		<div class="timeline-body">';
			echo '			<p>';
			echo '				<a class="btn btn-success" href="/app_content/'.$video['filename'].'"><i class="fa fa-play"></i> Play</a>';
			if($user_profile['id'] == $video["uploader"]) echo '<a class="btn btn-danger pull-right" href="/video/delete_file/'.$video['id'].'"><i class="fa fa-trash-o fa-lg"></i> Delete</a>';		
			echo '			</p>';
			echo '			<p>';		
			echo '<video id="'.$video['filename'].'" class="video-js vjs-default-skin vjs-big-play-centered"
			controls preload="auto" width="100%" height="264"			
			data-setup=\'{ "controls": true, "autoplay": false, "preload": "auto" }\'>';

			echo '<source src="/app_content/'.$video['filename'].'" type=\'video/mp4\'/>';
			echo '</video>';
			echo '			</p>';
			echo '			<p>Content?</p>';
			echo '		</div>';
			echo '	</div>';
			echo '</li>';

			$left = !$left;


		}
	}
	?>

</ul>

<?


} else {
	?>

	<div class="jumbotron">
		<h1 class="hidden">Your daily cup of..</h1>
		<p>
		<img src="/assets/img/CoffeeArmy-banner3.jpg" alt="banner" width="100%" />
		</p>
		<p class="lead"><h3>Whatevr!</h3> Natočte krátke video, alebo si pozrite ostatné. </p>
		<p><h3>O čo sa jedná? </h3>
		Kedže sa už všetci tak často nestretávame, tak vzniká tento virtuálny denník, kde možme rageovať, tešiť sa, vzdelavať alebo len povedať čo ste jedli na raňajky a že vám chutí.</p>
		<p><a class="btn btn-lg btn-success" href="<?php echo $login_url; ?>" role="button">Login via Fb</a></p>

	</div>



	<?php

}


