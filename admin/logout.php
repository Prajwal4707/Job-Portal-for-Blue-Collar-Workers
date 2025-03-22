<?php
session_start();
session_destroy();
header("Location: ../Worker/emp_login.html");
exit;
