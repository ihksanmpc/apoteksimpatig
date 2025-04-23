<?php

if (isset($_GET['view'])) $view = $_GET['view'];
else $view = "admin";

if ($view == "admin") include("script/beranda-admin-js.php");
