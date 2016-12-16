
<section id="custom-page">
<div class="container">
<div class="row">

<div class="col-md-6">
<div class="panel panel-default" id="duh" style="margin-bottom: 0px;">
<div class="panel-body">

<h2>Public users. <span class="text-muted">No login required.</span></h2>

Hello, hey! Since, this element of this page is set in the public mode, you can view this without any hassle in spite of the fact whether you're logged in or not. <b>Public content can be seen by anyone.</b>

</div>
</div>
</div>

<div class="col-md-6">
<div class="panel panel-default" id="duh">
<div class="panel-body">

<h2>Logged-in users. <span class="text-muted">Login required.</span></h2>

<?php

if(UserLoggedIn() == true) {

?>

This element has been set in the mode that allows only logged-in users to view the content despite of your their account group. You are seeing this message since you're logged in. <b>Nothing fancy here.</b>

<?php

} else { 

?>

<div class="alert alert-dismissable alert-warning">
Please login into to see the content of this element.
</div>

<?php

}

?>

</div>
</div>
</div>

<div class="col-md-6">
<div class="panel panel-default" id="duh">
<div class="panel-body">

<h2>Special users. <span class="text-muted">(Groups: 2,3,4 only)</span></h2>


<?php

if(showto(array(2,3,4)) == true) {

?>

This element has been set in the mode that allows only logged-in users in the groups (2,3,4) to view. You are seeing this message since you're in one of these groups. <b>Nothing fancy here.</b>

<?php

} else { 

?>

<div class="alert alert-dismissable alert-warning">
You don't have sufficient rights to view this content.
</div>

<?php

}

?>
</div>
</div>
</div>

<div class="col-md-6">
<div class="panel panel-default" id="duh">
<div class="panel-body">

<h2>Only admins. <span class="text-muted">With tremendous powers.</span></h2>


<?php

if(checkAdmin() == true) {

?>

Hey, admin! You can view this as you're an admin. Hope, you knew it.

<?php

} else { 

?>

<div class="alert alert-dismissable alert-warning">
You don't have sufficient rights to view this content.
</div>

<?php

}

?>
</div>
</div>
</div>

</div>
</div>
</section>