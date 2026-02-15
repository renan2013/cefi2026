<?php
$new_password = 'admin';
$hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
echo $hashed_password;
?>