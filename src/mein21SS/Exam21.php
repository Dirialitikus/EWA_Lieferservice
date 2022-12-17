<?php declare(strict_types=1);
// UTF-8 marker äöüÄÖÜß€

require_once './Page.php';

class Exam21 extends Page
{
    public int $id;

    protected function __construct()
    {
        parent::__construct();
    }


    public function __destruct()
    {
        parent::__destruct();
    }

    protected function getViewData():array
    {
        $games = array();
        $sql = "SELECT * FROM games  ORDER BY datetime ASC";
        $recordset = $this->_database->query($sql);
        if (!$recordset) {
            throw new DBException("Fehler in Abfrage: " . $this->_database->error);
        }
        while ($record = $recordset->fetch_assoc()) {
            $games[] = $record;
        }
        $recordset->free();
        return $games;
    }

    protected function generateView():void
    {
        $this->generatePageHeader("Spielplanung");
        $games =array();
        $games = $this->getViewData();

        $nextGame = "";
        $gameId = 0;

        foreach($games as $index){
            if((int)$index["status"] == 1 || (int)$index["status"] == 2)
            {
                $nextGame = $index["datetime"] . " gegen ". $index["opposingTeam"];
                $gameId = $index["id"];
                break;
            }

        }

        echo<<<EOT
        <header id="headerId">
        <img src="Logo.png" alt="">
        <h1 id="headlineId">Spielplanung</h1>   
        </header>
        <body onload="pollData()">
            <section>
            <form method="post" action="">
            <p>$nextGame</p>
           
            <div>Zusage der Spielerinnen <span id="playerAmount" name="playerAmount"> ? </span></div>
            <input type="hidden" id= "gameId" name="gameId" value="$gameId">
            <input type="submit" alt=""  value="Planung abschließen">
            </form>
            </section>    
            <section>
           <table>
           <caption>Spiele</caption>
  <tr>
    <th>Datum</th>
    <th>Team</th>
    <th>Status</th>
  </tr>
EOT;

        foreach($games as $index){
            $date = $index["datetime"];
            $opposingTeam= $index["opposingTeam"];
            $status = $index["status"];
            echo<<<EOF
<tr>
    <td>$date</td>
    <td>$opposingTeam</td>
    <td>$status</td>
  </tr>
EOF;

        }

        echo<<<EOT
</table>
    
</section>
        </body>
EOT;
        $this->generatePageFooter();
    }

    protected function processReceivedData():void
    {
        //parent::processReceivedData();
        if(isset($_POST["gameId"])){
            $id = $this->_database->real_escape_string($_POST["gameId"]);
            $sql= "UPDATE games SET status = 2 WHERE id = $id";
            if (!$this->_database->query($sql)) {
                throw new Exception("Update failed: " . $this->_database->error);
            }
            header('Location:Exam21.php');
            //header();
            die();

        }
    }

    public static function main():void
    {
        try {
            $page = new Exam21();
            $page->processReceivedData();
            $page->generateView();
        } catch (Exception $e) {
            header("Content-type: text/html; charset=UTF-8");
            echo $e->getMessage();
        }
    }
}


Exam21::main();