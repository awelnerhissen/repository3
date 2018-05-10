<?php
session_start();
define('conString', 'mysql:host=localhost;dbname=nejashiDb');
define('dbUser', 'root');
define('dbPass', 'rootpass');

$memberManagement = new MemberManagement();
$memberManagement->dbConnect(conString, dbUser, dbPass);
?>