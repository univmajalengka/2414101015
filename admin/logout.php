<?php
require_once __DIR__ . '/../koneksi.php';
session_destroy();
header('Location: login.php');
exit;
