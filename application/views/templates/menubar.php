<div class="subnav" style="margin-bottom: 10px;">
   <ul class="nav nav-pills">
      <li <? if(is_active()): ?>class="active"<? endif; ?>><a href="<?= site_url() ?>"><? echo $user_profile['name'] ?></a></li>
      <li><a href="./user_visit/">visits</a></li>
     <!--  <li class="dropdown">
         <a class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
         <ul class="dropdown-menu">
            <li><a href="">Item</a></li>
         </ul>
      </li>   -->
      <ul class="nav nav-pills pull-right">
         <li>
            <?php
            echo $login_link;
            ?>            
         </li>
      </ul>
   </ul>
</div>


<!-- 
      <div class="header">
        <ul class="nav nav-pills pull-right">
          <li class="active"><a href="#">Home</a></li>
          <li><a href="#">About</a></li>
          <li>
          <?php
            echo $login_link;
          ?>
          </li>
        </ul>
        <h3 class="text-muted">Daily cup of...</h3>
      </div> -->