    <div id="upload_div">
        <div>
            <button id="upload_btn" type="button" class="btn btn-success btn-circle btn-xl"><i class="glyphicon glyphicon-upload"></i></button>
            <h1 class="noblock">Upload</h1>

            <div id="upload" class="well">
                <h4>Title:</h4>
                <p><?php echo $video_title; ?></p>
                <input type="hidden" name="video_title" value="<?php echo $video_title; ?>">
                <h4>Description:</h4>
                <p><?php echo $video_description; ?></p>
                <input type="hidden" name="video_description" value="<?php echo $video_description; ?>">
                <form action="<?php echo( $response->url ); ?>?nexturl=<?php echo( urlencode( $nexturl ) ); ?>" method="post" enctype="multipart/form-data">
                    <p class="block">
                        <label>Upload Video</label>
                        <span class="youtube-input">
                            <input id="file" type="file" name="file" />
                        </span>                        
                    </p>
                    <input type="hidden" name="token" value="<?php echo( $response->token ); ?>"/>
                    <input type="submit" value="Upload Video" class="btn btn-primary" />
                </form>
            </div>
        </div>
    </div>