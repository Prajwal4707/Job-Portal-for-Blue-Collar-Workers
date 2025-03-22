<?php
session_start();
session_destroy();
header("Location: /Jobportal/Worker/emp_login.html");
exit;
