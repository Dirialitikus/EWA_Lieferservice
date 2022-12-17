<?php declare(strict_types=1);
// UTF-8 marker äöüÄÖÜß€

require_once './Page.php';

class Forward extends Page
{
    private string $hashValue;

    protected function __construct()
    {
        parent::__construct();
    }


    public function __destruct()
    {
        parent::__destruct();
    }

    protected function getViewData():void
    {
        $sql = "select url from hash2URL where hash = '$this->hashValue'";
        $recordSet =   $this->_database->query($sql);
        $rec = $recordSet->fetch_assoc(); // rec = array("url"=>"www.google.com")
        if ($rec){
            $location = (string)$rec['url'];
            header("HTTP/1.1 303 See Other");
            header("Location: " .$location);
            die(); // hier ausnahmsweise ok !
        }
    }

    protected function generateView():void
    {
        $this->getViewData();
    }

    protected function processReceivedData():void
    {
        parent::processReceivedData();

        if (isset($_GET['Hash'])){
            $this->hashValue = $this->_database->real_escape_string((string) $_GET['Hash']);

        }
    }

    public static function main():void
    {
        try {
            $page = new Forward();
            $page->processReceivedData();
            $page->generateView();
        } catch (Exception $e) {
            header("Content-type: text/html; charset=UTF-8");
            echo $e->getMessage();
        }
    }
}


Forward::main();

