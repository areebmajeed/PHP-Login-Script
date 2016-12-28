<?php

function UserLoggedIn() {

if(!empty($_SESSION['user_name']) && ($_SESSION['user_logged_in'] == 1)) {

return true;
	
} else {
	
return false;

}
	
}

function fetch_content($url) {

$ch = curl_init();
$timeout = 5;
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
$data = curl_exec($ch);
curl_close($ch);
return $data;

}

function verifyCaptcha() {

$recaptcha_secret = settings("googleRecaptcha_SECRETkey");
$response = fetch_content("https://www.google.com/recaptcha/api/siteverify?secret=". $recaptcha_secret . "&response=" . $_POST['g-recaptcha-response']);
$response = json_decode($response, true);	

if($response["success"] === true) {
	
return true;
	
} else {
	
return false;
	
}
	
}

function settings($config) {

global $con;
$con_f = $con;

$query = mysqli_query($con_f,"SELECT value FROM settings WHERE name = '{$config}'");
$data = mysqli_fetch_array($query);

return $data['value'];

}

function filterData($input) {
	
global $con;
$con_f = $con;
 
$search = array(
'@<script[^>]*?>.*?</script>@si',  
'@<[\/\!]*?[^<>]*?>@si',           
'@<style[^>]*?>.*?</style>@siU',   
'@<![\s\S]*?--[ \t\n\r]*>@'       
);

$wipe = array(

"+union+",
"%20union%20",
"/union/*",
' union ',
"union",
"sql",
"mysql",
"database",
"cookie",
"coockie",
"select",
"from",
"where",
"benchmark",
"concat",
"table",
"into",
"by",
"values",
"exec",
"shell",
"truncate",
"wget",
"/**/"

);
 
$output = preg_replace($search, '', $input);
$output = str_replace($wipe,'',$output);

return mysqli_real_escape_string($con_f,trim($output));

}

function get_IP() {
    // check for shared internet/ISP IP
    if (!empty($_SERVER['HTTP_CLIENT_IP']) && validate_ip($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    }

    // check for IPs passing through proxies
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        // check if multiple ips exist in var
        if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ',') !== false) {
            $iplist = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            foreach ($iplist as $ip) {
                if (validate_ip($ip))
                    return $ip;
            }
        } else {
            if (validate_ip($_SERVER['HTTP_X_FORWARDED_FOR']))
                return $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
    }
    if (!empty($_SERVER['HTTP_X_FORWARDED']) && validate_ip($_SERVER['HTTP_X_FORWARDED']))
        return $_SERVER['HTTP_X_FORWARDED'];
    if (!empty($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']) && validate_ip($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']))
        return $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
    if (!empty($_SERVER['HTTP_FORWARDED_FOR']) && validate_ip($_SERVER['HTTP_FORWARDED_FOR']))
        return $_SERVER['HTTP_FORWARDED_FOR'];
    if (!empty($_SERVER['HTTP_FORWARDED']) && validate_ip($_SERVER['HTTP_FORWARDED']))
        return $_SERVER['HTTP_FORWARDED'];

    // return unreliable ip since all else failed
    return $_SERVER['REMOTE_ADDR'];
}


function validate_ip($ip) {
    if (strtolower($ip) === 'unknown')
        return false;

    // generate ipv4 network address
    $ip = ip2long($ip);

    // if the ip is set and not equivalent to 255.255.255.255
    if ($ip !== false && $ip !== -1) {
        // make sure to get unsigned long representation of ip
        // due to discrepancies between 32 and 64 bit OSes and
        // signed numbers (ints default to signed in PHP)
        $ip = sprintf('%u', $ip);
        // do private network range checking
        if ($ip >= 0 && $ip <= 50331647) return false;
        if ($ip >= 167772160 && $ip <= 184549375) return false;
        if ($ip >= 2130706432 && $ip <= 2147483647) return false;
        if ($ip >= 2851995648 && $ip <= 2852061183) return false;
        if ($ip >= 2886729728 && $ip <= 2887778303) return false;
        if ($ip >= 3221225984 && $ip <= 3221226239) return false;
        if ($ip >= 3232235520 && $ip <= 3232301055) return false;
        if ($ip >= 4294967040) return false;
    }
    return true;
}

function sendMail($to,$subject,$body) {
	
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
$address = $to;
$mail->AddAddress($address);
$mail->Send();
	
}

function showto($list) {
	
$status = false;

if(UserLoggedIn() == true) {
	
$group = loadAccDetails("user_id",$_SESSION['user_id'],"account_group");
	
if(in_array($group,$list) == true) {
	
$status = true;
	
}

}

return $status;
	
}

function checkAdmin() {
	
$status = false;

if(UserLoggedIn() == true) {
	
$powers = loadAccDetails("user_id",$_SESSION['user_id'],"admin_powers");
	
if($powers == 1) {
	
$status = true;
	
}

}

return $status;
	
}

function checkForumMod() {
	
$status = false;

if(UserLoggedIn() == true) {
	
$powers = loadAccDetails("user_id",$_SESSION['user_id'],"forum_powers");
	
if($powers == 1) {
	
$status = true;
	
}

}

return $status;
	
}

function loadAccDetails($input_field,$input,$output_field) {

global $con;
$con_f = $con;

$query = mysqli_query($con_f,"SELECT $output_field FROM users WHERE $input_field = '{$input}'");
$data = mysqli_fetch_array($query);

return $data[$output_field];
	
}

function loadAvatar($user) {

global $con;
$con_f = $con;

if(settings("avatarUploads") == 1) {
	
$load = mysqli_query($con,"SELECT avatar_url,user_email FROM users WHERE user_id = '{$user}'");
$load = mysqli_fetch_array($load);

if($load['avatar_url'] != "") {
	
return $load['avatar_url'];

} else {
	
return $url = "https://www.gravatar.com/avatar/" . md5($load['user_email']) . "?d=&r=g";
	
}
	
} else {
	
$load = mysqli_query($con,"SELECT user_email FROM users WHERE user_id = '{$user}'");
$load = mysqli_fetch_array($load);

return $url = "https://www.gravatar.com/avatar/" . md5($load['user_email']) . "?d=&r=g";
	
}
	
}

function accountGroup($id,$config) {

global $con;
$con_f = $con;

$query = mysqli_query($con_f,"SELECT $config FROM account_groups WHERE id = '{$id}'");
$data = mysqli_fetch_array($query);

return $data[$config];

}

function slug($slug) {

$lettersNumbersSpacesHyphens = '/[^\-\s\pN\pL]+/u';
$spacesDuplicateHypens = '/[\-\s]+/';
$slug = preg_replace($lettersNumbersSpacesHyphens, '', $slug);
$slug = preg_replace($spacesDuplicateHypens, '-', $slug);
$slug = trim($slug, '-');
return mb_strtolower($slug, 'UTF-8');

}

function ifRead($topic,$uid) {

global $con;

$get_cc = mysqli_query($con,"SELECT * FROM read_history WHERE topic_id = '$topic' AND user_id = '$uid'");

if(mysqli_num_rows($get_cc) > 0.99) {
return 'Already read';
} else {	
return "It's new";	
}

}

function getTopicName($name) {

global $con;
$con_f = $con;

$get_nm = mysqli_query($con_f,"SELECT topic_name FROM topics WHERE topic_id = '$name'");
$topic_nm = mysqli_fetch_array($get_nm);
return $topic_nm['topic_name'];

}

function dbSlug($name) {

global $con;
$con_f = $con;

$db_slug = mysqli_query($con_f,"SELECT topic_slug FROM topics WHERE topic_id = '{$name}'");
$topic_nm = mysqli_fetch_array($db_slug);
return $topic_nm['topic_slug'];

}

function getReplies($name) {

global $con;
$con_f = $con;

$get_nm = mysqli_query($con_f,"SELECT replies FROM topics WHERE topic_id = '$name'");
$topic_nm = mysqli_fetch_array($get_nm);
return $topic_nm['replies'];

}

function encrypt($text,$key) {

return trim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $text, MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND))));

}

function decrypt($text,$key) {

return trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, base64_decode($text), MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND)));

}
