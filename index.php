<?php

$gb = isset($_REQUEST["gb"]) ? $_REQUEST["gb"] : "ko";

header("Location: /Hongik_/Intro/index.php?gb=".$gb."&code=INT");

?>