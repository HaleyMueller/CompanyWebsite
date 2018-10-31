<?php
if (session_status() == PHP_SESSION_NONE) {
    session_set_cookie_params(0);
    session_start();
}
ob_start();
?>