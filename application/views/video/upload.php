<h1>Upload File</h1>
<?php echo $error;?>
<?php echo form_open_multipart('/video/upload_file');?>
<p>
<input type="file" name="userfile" id="userfile" size="20"><br />
<input type="submit" class="btn btn-primary" name="submit" id="submit" value="upload" />
</p>
</form>

<h2>Files</h2>
<div id="files">
    <table class="table table-striped">
    <thead>
        <tr>
            <th>Filename</th>      
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>   
        <?php foreach ($content_files as $content_files_item): ?>
            <tr>
                <td><?php echo anchor($content_dir.$content_files_item['filename'], $content_files_item['filename']); ?></td>
                <td>
                    <?php echo anchor("video/delete_video/". $content_files_item['id'], "Delete", 'class="btn btn-primary"'); ?>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>
</div>
