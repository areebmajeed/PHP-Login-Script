<style>

.h5 {
	background-color: white;
}
</style>

<div class="container">

<?php

$page = filterData($_GET['page']);

if($page == "settings") { ?>
	
<div class="page-header">	
<h1>Settings:</h1>
</div>

<?php

if(isset($_POST['update_settings'])) {
	
foreach($_POST as $key => $value) {
	
$key = filterData($key);
$value = filterData($_POST[$key]);

mysqli_query($con,"UPDATE settings SET value = '{$value}' WHERE name = '{$key}'");

}

echo '<div class="alert alert-dismissable alert-success">
Updated the settings ^.^
</div>';	
	
}

?>

<form action="" method="post">

<h4>Website Name:</h4>
<input type="text" name="website_name" value="<?php echo settings('website_name'); ?>" class="form-control">
<br>
<h4>Website URL:</h4>
<input type="text" name="website_url" value="<?php echo settings('website_url'); ?>" class="form-control">
<br>
<h4>Remember-Me (Stay Logged-In) Length (in days):</h4>
<input type="text" name="StayLoggedDAYS" value="<?php echo settings('StayLoggedDAYS'); ?>" class="form-control">
<br>
<h4>Google ReCaptcha:</h4>
<select name="googleReCaptcha" class="form-control">
<option value="0">Disabled</option>
<?php
if(settings('googleReCaptcha') == 1) {
echo '<option value="1" selected>Enabled</option>';	
} else {
echo '<option value="1">Enabled</option>';
}
?>
</select>
<br>
<h4>Registration Email Confirmation:</h4>
<select name="emailConfirmation" class="form-control">
<option value="0">Disabled</option>
<?php
if(settings('emailConfirmation') == 1) {
echo '<option value="1" selected>Enabled</option>';	
} else {
echo '<option value="1">Enabled</option>';
}
?>
</select>
<br>
<h4>Avatar Uploads:</h4>
<select name="avatarUploads" class="form-control">
<option value="0">Disabled</option>
<?php
if(settings('avatarUploads') == 1) {
echo '<option value="1" selected>Enabled</option>';	
} else {
echo '<option value="1">Enabled</option>';
}
?>
</select>
<br>
<h4>Show Profiles:</h4>
<select name="showProfiles" class="form-control">
<option value="0">Disabled</option>
<?php
if(settings('showProfiles') == 1) {
echo '<option value="1" selected>Enabled</option>';	
} else {
echo '<option value="1">Enabled</option>';
}
?>
</select>
<br>
<h4>ReCaptcha Public (Site) Key:</h4>
<input type="text" name="googleRecaptcha_PUBLICkey" value="<?php echo settings('googleRecaptcha_PUBLICkey'); ?>" class="form-control">
<br>
<h4>ReCaptcha Secret (Server) Key:</h4>
<input type="text" name="googleRecaptcha_SECRETkey" value="<?php echo settings('googleRecaptcha_SECRETkey'); ?>" class="form-control">

<br>
<br>

<input type="submit" class="form-control btn-danger" value="Update" name="update_settings">

</form>
	
<?php } elseif($page == "all_users") { ?>

<div class="page-header">	
<h1>All Users:</h1>
</div>

<?php

$rc = mysqli_query($con,"SELECT COUNT(user_id) AS id FROM users ORDER BY user_id DESC");
$numrows = mysqli_fetch_array($rc);

$refs = 50;
$total_pages = ceil($numrows['id'] / $refs);

if(isset($_GET['offset']) && is_numeric($_GET['offset'])) {
$req_page = (int) filterData($_GET['offset']);
} else {
$req_page = 1;
}

if($req_page > $total_pages) {
   $req_page = $total_pages;
}

if($req_page < 1) {
   $req_page = 1;
}

$offset = ($req_page - 1) * $refs;

$query = mysqli_query($con,"SELECT user_id,user_name,user_email,registration_datetime FROM users ORDER BY user_id DESC LIMIT $offset, $refs");

if(mysqli_num_rows($query) > 0.9) {
	
echo '<table class="table table-striped table-hover">
  <thead>
    <tr class="danger">    
    <th>Username</th>
    <th>Email</th>
    <th>Registration Datetime</th>
    <th>Control</th>
    </tr>
  </thead>
  <tbody>';
  
while($usr = mysqli_fetch_array($query)) {	 
 
echo '<tr class="success">';
echo  '<td>' . $usr['user_name'] . '</td>';	
echo  '<td>' . $usr['user_email'] . '</td>';
echo  '<td>' . $usr['registration_datetime'] . '</td>';
echo '<td><a href="admin?fetchusrdetails=1&user=' . $usr['user_id'] . '&matcher=user_id">View</a> | <a href="admin?editusrdetails=1&user=' . $usr['user_id'] . '&matcher=user_id">Edit</a> | <a href="admin?deleteuser=1&user=' . $usr['user_id'] . '&matcher=user_id" onclick="return confirm(\'Are you sure that you want to delete this user?\');">Delete</a></td>';
echo '</tr>';
  
}
  
echo '</tbody>
</table>';

echo '<br>';
echo '<br>';

echo '<div align="center"><ul class="pagination">';

if($req_page > 1) {
	$prev = $req_page - 1;
  echo '<li><a href="?page=all_users&offset=' . $prev . '">Previous Page</a></li>';
}

echo '<li class="disabled active"><a href="?page=all_users&offset=' . $req_page . '">Current Page: ' . $req_page . '</a></li>';

if($req_page < $total_pages) {

$next = $req_page + 1;

echo '<li><a href="?page=all_users&offset=' . $next . '">Next Page</a></li>';

}
  
echo '</ul></div>';
	
} else {
	
echo '<div class="alert alert-dismissable alert-warning">
  <button type="button" class="close" data-dismiss="alert">X</button>
Bad thing! No user has registered.
</div>';
	
}

?>
	
<?php } elseif($page == "banned_users") { ?>

<div class="page-header">	
<h1>Banned Users:</h1>
</div>

<?php

$rc = mysqli_query($con,"SELECT COUNT(user_id) AS id FROM users WHERE account_status = 0 ORDER BY user_id DESC");
$numrows = mysqli_fetch_array($rc);

$refs = 50;
$total_pages = ceil($numrows['id'] / $refs);

if(isset($_GET['offset']) && is_numeric($_GET['offset'])) {
$req_page = (int) filterData($_GET['offset']);
} else {
$req_page = 1;
}

if($req_page > $total_pages) {
   $req_page = $total_pages;
}

if($req_page < 1) {
   $req_page = 1;
}

$offset = ($req_page - 1) * $refs;

$query = mysqli_query($con,"SELECT user_id,user_name FROM users WHERE account_status = 0 ORDER BY user_id DESC LIMIT $offset, $refs");

if(mysqli_num_rows($query) > 0.9) {
	
echo '<table class="table table-striped table-hover">
  <thead>
    <tr class="danger">    
    <th>Username</th>
    <th>Reason</th>
    <th>Control</th>
    </tr>
  </thead>
  <tbody>';
  
while($usr = mysqli_fetch_array($query)) {	 
 
echo '<tr class="success">';
echo  '<td>' . $usr['user_name'] . '</td>';
$load_reason = mysqli_query($con,"SELECT reason FROM ban_logs WHERE user_id = '{$usr['user_id']}'");
$reason = mysqli_fetch_array($load_reason);
echo  '<td>' . $reason['reason'] . '</td>';
echo '<td><a href="admin?unbanuser=1&user=' . $usr['user_id'] . '&matcher=user_id">Unban</a> | <a href="admin?editusrdetails=1&user=' . $usr['user_id'] . '&matcher=user_id">Edit</a> | <a href="admin?deleteuser=1&user=' . $usr['user_id'] . '&matcher=user_id" onclick="return confirm(\'Are you sure that you want to delete this user?\');">Delete</a></td>';
echo '</tr>';
  
}
  
echo '</tbody>
</table>';

echo '<br>';
echo '<br>';

echo '<div align="center"><ul class="pagination">';

if($req_page > 1) {
$prev = $req_page - 1;
echo '<li><a href="?page=banned_users&offset=' . $prev . '">Previous Page</a></li>';
}

echo '<li class="disabled active"><a href="?page=banned_users&offset=' . $req_page . '">Current Page: ' . $req_page . '</a></li>';

if($req_page < $total_pages) {

$next = $req_page + 1;

echo '<li><a href="?page=banned_users&offset=' . $next . '">Next Page</a></li>';

}
  
echo '</ul></div>';
	
} else {
	
echo '<div class="alert alert-dismissable alert-warning">
  <button type="button" class="close" data-dismiss="alert">X</button>
Good thing! No user has been banned.
</div>';
	
}

?>

<?php } elseif($page == "memberships") { ?>

<div class="page-header">	
<h1>Account Memberships:</h1>
</div>

<?php

$query = mysqli_query($con,"SELECT * FROM account_groups ORDER BY id DESC");

echo '<table class="table table-striped table-hover">
  <thead>
    <tr class="danger">
    <th>ID</th>
    <th>Name</th>
	<th>Control</th>
    </tr>
</thead>
<tbody>';

while($acc = mysqli_fetch_array($query)) {
	
echo '<tr class="success">';
echo  '<td>' . $acc['id']  . '</td>';	
echo  '<td>' . $acc['name'] . '</td>';	
echo  '<td><a onclick="return confirm(\'Are you sure?\');" href="admin_cmd?page=memberships&delete_membership=' . $acc['id'] . '">DELETE</a> | <a href="admin_cmd?page=memberships&edit=' . $acc['id'] . '">EDIT</a></td>';
echo '</tr>';	
	
}  

echo '</tbody></table>';

echo '<br>';
echo '<br>';

if(isset($_GET['delete_membership'])) {
	
$membership = filterData($_GET['delete_membership']);

if($membership == 1) {
	
echo '<div class="alert alert-dismissable alert-danger">
  <button type="button" class="close" data-dismiss="alert">X</button>
Level #1 cannot be deleted.
</div>';
	
} else {
	
mysqli_query($con,"UPDATE users SET type = 1 WHERE type = '{$membership}'");
mysqli_query($con,"DELETE FROM account_groups WHERE id = '{$membership}'");

echo '<div class="alert alert-dismissable alert-success">
  <button type="button" class="close" data-dismiss="alert">X</button>
Deleted successfully; users within this group downgraded to level 1.
</div>';	
	
}	
	
}

if(isset($_POST['submit'])) {
	
$name = filterData($_POST['name']);
$status = filterData($_POST['status']);
	
mysqli_query($con,"INSERT INTO account_groups (name,status) VALUES ('$name','$status')");
	
echo '<div class="alert alert-dismissable alert-success">
  <button type="button" class="close" data-dismiss="alert">X</button>
Kewl! Account membership created.
</div>';

}

elseif(isset($_GET['edit'])) {
	
$id = filterData($_GET['edit']);
$load = mysqli_query($con,"SELECT * FROM account_groups WHERE id = '{$id}'");
$load = mysqli_fetch_array($load);

if(isset($_POST['s_submit'])) {
	
$id = filterData($_POST['id']);
$name = filterData($_POST['name']);
$status = filterData($_POST['status']);
	
mysqli_query($con,"UPDATE account_groups SET name = '{$name}', status = '{$status}' WHERE id = '{$id}'");
	
echo '<div class="alert alert-dismissable alert-success">
  <button type="button" class="close" data-dismiss="alert">X</button>
Kewl! Account membership updated.
</div>';
	
}
	
echo '<form action="" method="post">';

echo '<input type="hidden" name="id" value="' . $id . '">';
echo '<input type="text" name="name" value="' . $load['name'] . '" class="form-control">';
echo '<br>';
echo '<select class="form-control" name="status">';
echo '<option value="1">Enabled</option>';
echo '<option value="0">Disabled (Users won\'t be able to login)</option>';
echo '</select>';
echo '<br>';
echo '<br>';
echo '<input type="submit" name="s_submit" value="Submit" class="form-control btn btn-danger">';
echo '</form>';	
	
} else {

echo '<form action="" method="post">';

echo '<input type="text" name="name" placeholder="Name of the account group" class="form-control">';
echo '<br>';
echo '<select class="form-control" name="status">';
echo '<option value="1">Enabled</option>';
echo '<option value="0">Disabled (Users won\'t be able to login)</option>';
echo '</select>';
echo '<br>';
echo '<br>';
echo '<input type="submit" name="submit" value="Submit" class="form-control btn btn-danger">';
echo '</form>';

}

?>

<?php } elseif($page == "forums") { ?>

<div class="page-header">
<h1>Forums</h1>
</div>

<?php 

$get_forums = mysqli_query($con,"SELECT * FROM categories ORDER BY sort_lvl DESC");

if(mysqli_num_rows($get_forums) < 1) {

echo '<div class="alert alert-dismissable alert-warning">
  <button type="button" class="close" data-dismiss="alert">X</button>
Ouch! No forum has been created.
</div>';

} else {
	
echo '<table class="table table-striped table-hover">
  <thead>
    <tr class="danger">
    <th>Name</th>
    <th>Description</th>
	<th>Topics</th>
	<th>Posts</th>
	<th>Sort Level</th>
	<th>Delete</th>
    </tr>
  </thead>
  <tbody>';

while($forum = mysqli_fetch_array($get_forums)) {	
	
echo '<tr class="success">';
echo '<td>' . $forum['name'] . '</td>';
echo '<td>' . $forum['description'] . '</td>';
echo '<td>' . $forum['topics'] . '</td>';
echo '<td>' . $forum['posts'] . '</td>';
echo '<td>' . $forum['sort_lvl'] . '</td>';
echo '<td><a onclick="return confirm(\'Are you sure?\');" href="admin_cmd?page=forums&delete_forum=' . $forum['id'] . '">Delete</a></td>';
echo '</tr>';	
	
}

echo '</tbody>
</table>';

}

if(isset($_POST['create_forum'])) {

$name = filterData($_POST['forum_name']);
$description = filterData($_POST['forum_description']);
$sort_lvl = filterData($_POST['forum_lvl']);

$find_duplicate = mysqli_query($con,"SELECT id FROM categories WHERE name = '$name'");

if($name == "") {
	
echo '<div class="alert alert-dismissable alert-warning">
  <button type="button" class="close" data-dismiss="alert">X</button>
Forum name is left blank.
</div>';
	
}

elseif(mysqli_num_rows($find_duplicate) > 0.9) {
	
echo '<div class="alert alert-dismissable alert-warning">
  <button type="button" class="close" data-dismiss="alert">X</button>
Forum with that name already exists.
</div>';
	
}

elseif($description == "") {
	
echo '<div class="alert alert-dismissable alert-warning">
  <button type="button" class="close" data-dismiss="alert">X</button>
Forum description is left blank.
</div>';		
	
}

elseif($sort_lvl == "") {
	
echo '<div class="alert alert-dismissable alert-warning">
  <button type="button" class="close" data-dismiss="alert">X</button>
Sort level is left blank.
</div>';	
	
}

elseif(is_numeric($sort_lvl) == false) {
	
echo '<div class="alert alert-dismissable alert-warning">
  <button type="button" class="close" data-dismiss="alert">X</button>
Only integers accepted in sort level.
</div>';		
	
} else {
	
$slug = slug($name) . '-' . mt_rand(1,1000);
	
mysqli_query($con,"INSERT INTO categories (name,slug,description,topics,posts,sort_lvl) VALUES ('$name','$slug','$description','0','0','$sort_lvl')");

echo '<div class="alert alert-dismissable alert-success">
  <button type="button" class="close" data-dismiss="alert">X</button>
Eureka! The forum has been created successfully.
</div>';	
	
}

}

if(isset($_GET['delete_forum'])) {
	
$id = filterData($_GET['delete_forum']);

mysqli_query($con,"DELETE FROM categories WHERE id = '$id'");
mysqli_query($con,"DELETE FROM topics WHERE topic_cat = '$id'");
mysqli_query($con,"DELETE FROM posts WHERE post_category = '$id'");
	
echo '<div class="alert alert-dismissable alert-success">
  <button type="button" class="close" data-dismiss="alert">X</button>
Eureka! The forum has been deleted successfully.
</div>';	
	
}

?>

<form method="post" action="admin_cmd?page=forums">

<b>Forum Name:</b>
<input type="text" name="forum_name" class="form-control" placeholder="Desired forum name.">
<br>
<b>Description:</b>
<input type="text" name="forum_description" class="form-control" placeholder="Desired forum description.">
<br>
<b>Sort Level:</b>
<input type="text" name="forum_lvl" class="form-control" placeholder="7">
<br>
<br>
<input type="submit" name="create_forum" class="form-control btn btn-danger" value="Create forum">

</form>

<?php } elseif($page == "eval") { ?>

<div class="page-header">
<h1>EVAL</h1>
</div>

<?php

if($eval_enabled == 1) { ?>

<div class="alert alert-dismissable alert-danger">
EVAL IS DANGEROUS AND DISASTROUS. IT IS ADVISED TO KEEP EVAL OFF (BY EDITING THE CONFIGURATION FILE), EVAL CAN CAUSE A GREAT DAMAGE AND COMPROMISE SITE AND SERVER'S SECURITY INCASE A BAD ADMIN TAKES OVER. PLEASE USE AND ENABLE IT AT YOUR OWN RISK, THE SCRIPT AUTHOR CANNOT BE HELD RESPONSIBLE FOR THE DAMAGES.
</div>

<br>

<?php

if(isset($_POST['submit'])) {
	
eval($_POST['command']);	
	
echo '<br>';	 
echo '<br>';	

}

?>

<h4>&lt;?php</h4>
<h4>$con = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);</h4>

<form action="admin_cmd?page=eval" method="post">

<textarea name="command" class="form-control" rows="5">echo 'Hello world!';</textarea>

<h4>mysqli_close($con);</h4>
<h4>?&gt;</h4>

<br>

<input type="submit" class="form-control btn btn-danger" name="submit" value="Submit">

</form>

<?php } else { ?>

<div class="alert alert-dismissable alert-success">
EVAL is disabled. Keep it disabled, it's a good practise.
</div>

<?php } ?>

<?php } elseif($page == "admins") { ?>

<div class="page-header">
<h1>Administrators</h1>
</div>

<?php

$load = mysqli_query($con,"SELECT user_id,user_name,forum_posts FROM users WHERE admin_powers = 1");

if(mysqli_num_rows($load) < 0.99) {
	
echo '<div class="alert alert-dismissable alert-success">
Whoops, no admin to show c:
</div>';
	
} else {

echo '<table class="table table-striped table-hover">
  <thead>
    <tr class="danger">
    <th>User ID</th>
    <th>User Name</th>
	<th>Forum Posts</th>
	<th>Manage</th>
    </tr>
</thead>
<tbody>';

while($mod = mysqli_fetch_array($load)) {	
	
echo '<tr class="success">';
echo '<td>' . $mod['user_id'] . '</td>';
echo '<td>' . $mod['user_name'] . '</td>';
echo '<td>' . $mod['forum_posts'] . '</td>';
echo '<td><a onclick="return confirm(\'Are you sure?\');" href="admin_cmd?page=admins&delete_mod=' . $mod['user_id'] . '">Downgrade</a></td>';
echo '</tr>';	
	
}

echo '</tbody>
</table>';

}

echo "<hr>";

if(isset($_GET['delete_mod'])) {
	
$id = filterData($_GET['delete_mod']);

mysqli_query($con,"UPDATE users SET admin_powers = 0 WHERE user_id = '{$id}' AND admin_powers = 1");

echo '<div class="alert alert-dismissable alert-success">
  <button type="button" class="close" data-dismiss="alert">X</button>
Eureka! The mod has been downgraded successfully.
</div>';	
	
}

if(isset($_POST['submit_new'])) {
	
$user_name = filterData($_POST['user_name']);
	
mysqli_query($con,"UPDATE users SET admin_powers = 1 WHERE user_name = '{$user_name}' AND admin_powers = 0");
	
echo '<div class="alert alert-dismissable alert-success">
  <button type="button" class="close" data-dismiss="alert">X</button>
Eureka! The user has been upgraded successfully.
</div>';	
	
}

echo '<br>';
echo '<br>';

echo '<form action="" method="post">';
echo '<input type="text" name="user_name" placeholder="What\'s the username you wish to upgrade to admin?" class="form-control">';
echo '<br>';
echo '<input type="submit" name="submit_new" value="Submit" class="form-control btn btn-danger">';
echo '</form>';

?>

<?php } elseif($page == "mass_mail") { ?>

<div class="page-header">
<h1>Mass-Mail</h1>
</div>

<?php

if(isset($_POST['submit_new'])) {

$subject = $_POST['subject'];
$body = $_POST['body'];

$q = mysqli_query($con,"SELECT user_email FROM users WHERE user_verified = 1");

$x = 0;

while($queue = mysqli_fetch_array($q)) {

$mail = new PHPMailer();

if(EMAIL_USE_SMTP) {

$mail->IsSMTP();

$mail->SMTPAuth = EMAIL_SMTP_AUTH;
if(defined(EMAIL_SMTP_ENCRYPTION)) {
$mail->SMTPSecure = EMAIL_SMTP_ENCRYPTION;
}

$mail->Host = EMAIL_SMTP_HOST;
$mail->Username = EMAIL_SMTP_USERNAME;
$mail->Password = EMAIL_SMTP_PASSWORD;
$mail->Port = EMAIL_SMTP_PORT;
} else {
$mail->IsMail();
}
  
$mail->Subject = $subject;
$mail->SMTPDebug = false;
$mail->do_debug = 0;
$mail->MsgHTML($body);
$address = $queue['user_email'];
$mail->AddAddress($address);
$mail->Send();

$x = $x + 1;

}

echo '<div class="alert alert-dismissable alert-success">
Email sent to ' . $x . ' users!
</div>';

}

echo '<form action="" method="post">';

echo '<input type="text" name="subject" placeholder="What\'s the subject?" class="form-control">';
echo '<br>';
echo '<textarea class="form-control" name="body" placeholder="Your message to the users" rows="6"></textarea>';
echo '<br>';
echo '<input type="submit" name="submit_new" value="Submit" class="form-control btn btn-danger">';
echo '</form>';

?>

<?php } elseif($page == "forum_mods") { ?>

<div class="page-header">
<h1>Forum Moderators</h1>
</div>

<?php

$load = mysqli_query($con,"SELECT user_id,user_name,forum_posts FROM users WHERE forum_powers = 1");

if(mysqli_num_rows($load) < 0.99) {
	
echo '<div class="alert alert-dismissable alert-success">
Whoops, no moderator to show c:
</div>';
	
} else {

echo '<table class="table table-striped table-hover">
  <thead>
    <tr class="danger">
    <th>User ID</th>
    <th>User Name</th>
	<th>Forum Posts</th>
	<th>Manage</th>
    </tr>
</thead>
<tbody>';

while($mod = mysqli_fetch_array($load)) {	
	
echo '<tr class="success">';
echo '<td>' . $mod['user_id'] . '</td>';
echo '<td>' . $mod['user_name'] . '</td>';
echo '<td>' . $mod['forum_posts'] . '</td>';
echo '<td><a onclick="return confirm(\'Are you sure?\');" href="admin_cmd?page=forum_mods&delete_mod=' . $mod['user_id'] . '">Downgrade</a></td>';
echo '</tr>';	
	
}

echo '</tbody>
</table>';

}

echo "<hr>";

if(isset($_GET['delete_mod'])) {
	
$id = filterData($_GET['delete_mod']);

mysqli_query($con,"UPDATE users SET forum_powers = 0 WHERE user_id = '{$id}' AND forum_mod = 1");

echo '<div class="alert alert-dismissable alert-success">
  <button type="button" class="close" data-dismiss="alert">X</button>
Eureka! The mod has been downgraded successfully.
</div>';	
	
}

if(isset($_POST['submit_new'])) {
	
$user_name = filterData($_POST['user_name']);
	
mysqli_query($con,"UPDATE users SET forum_powers = 1 WHERE user_name = '{$user_name}' AND forum_mod = 0");
	
echo '<div class="alert alert-dismissable alert-success">
  <button type="button" class="close" data-dismiss="alert">X</button>
Eureka! The user has been upgraded successfully.
</div>';	
	
}

echo '<br>';
echo '<br>';

echo '<form action="" method="post">';
echo '<input type="text" name="user_name" placeholder="What\'s the username you wish to upgrade to moderator?" class="form-control">';
echo '<br>';
echo '<input type="submit" name="submit_new" value="Submit" class="form-control btn btn-danger">';
echo '</form>';

}

?>

</div>