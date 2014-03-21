   <div class="footer">
   	<p>&copy; pejko 2014</p>
   </div> 
</div>


<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/lodash.js/1.3.1/lodash.min.js"></script>
<script src="<?php echo base_url('assets/js/bootstrap.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/custom.js') ?>"></script>

<link href="//vjs.zencdn.net/4.4/video-js.css" rel="stylesheet">
<script src="//vjs.zencdn.net/4.4/video.js"></script>


<script>
$(function(){
	if(<?php echo $hide_upload; ?>){
		$('#upload').hide();
	}
});

$('#upload_btn').click(function(){

	$( this ).slideUp();
	$('#upload').show('slow');
});
</script>

</body>
</html>
