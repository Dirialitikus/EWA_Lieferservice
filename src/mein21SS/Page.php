<?php

abstract class Page
{
    protected $_database;
    public  $nextGameId = 0;
    protected function __construct()
    {
        $this->_database = new MySQLi("mariadb", "public", "public", "2021_TeamSport");
        if (mysqli_connect_errno()) {
            throw new Exception(mysqli_connect_error());
        }
        if (!$this->_database->set_charset("utf8")) {
            throw new Exception($this->_database->error);
        }
    }

    public function __destruct()
    {
        $this->_database->close();
    }


    protected function generatePageHeader($headline = "")
    {
        header("Content-type: text/html; charset=UTF-8");
        $headline = htmlspecialchars($headline);
        echo <<<EOT
<!DOCTYPE html>
<html lang="de" >
<head>
<meta charset="UTF-8" />
<title>$headline</title>
<link rel="stylesheet" type="text/css" href="MEISTER.css"/>
	<script type="text/javascript" src="Exam21.js"></script>
</head>

EOT;
    }

    protected function generatePageFooter()
    {
        echo <<<EOT
	</html>
EOT;
    }

    protected function processReceivedData()
    {
    }
}
