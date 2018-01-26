<?php

require_once "../Security.php";

$token = Security::createToken();

echo json_encode(array("token" => $token));
