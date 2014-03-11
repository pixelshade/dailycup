<?php

function error_html($caption, $title = "Warning!"){
echo '<div class="alert alert-warning alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
echo "<strong> ".$title." </strong> ".$caption;
echo "</div>";
}
