<?php

// hapus session
session_destroy();

// redirect ke index
echo "<meta http-equiv='refresh' content='0.1, url=../index.php'>";
