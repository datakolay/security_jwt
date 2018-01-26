<?php

require_once "../Security.php";

$payload = Security::validateToken();

echo json_encode(array("data" => "Your welcome.", "payload" => $payload));