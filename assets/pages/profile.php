<section id="custom-page">

<div class="container">
<div class="row">

<div class="col-md-12" >
<div class="panel panel-default" id="duh">
<div class="panel-body">

<h2>Profile. <span class="text-muted"><b><?php echo $user_data['user_name']; ?>.</b></span></h2>

<big>

<img src="<?php echo loadAvatar($user_data['user_id']); ?>" alt="<?php echo $user_data['user_name']?>'s avatar">

<br>
<br>

<b>Username:</b> <?php echo $user_data['user_name']; ?>
<br>
<b>Last Log-in:</b> <?php echo $user_data['last_logged_in']; ?>
<br>
<b>Account Group:</b> <?php echo accountGroup($user_data['account_group'],"name"); ?>
<br>
<b>Account Status:</b> <?php if($user_data['account_status'] == 1) { echo 'Active'; } else { echo 'Suspended'; } ?>

</big>

</div>
</div>
</div>


</div>
</div>

</section>