<?php declare(strict_types=1);
// UTF-8 marker äöüÄÖÜß€

require_once './Page.php';

class GenerateLink extends Page
{
    private string $url;

    protected function __construct()
    {
        parent::__construct();
    }


    public function __destruct()
    {
        parent::__destruct();
    }


    protected function generateView():void
    {

        $this->generatePageHeader("GenerateLink");
        echo <<<EOF

<ul>
<li><a href="">Home</a></li>
<li><a href="">Products</a></li>
<li><a href="">Company</a></li>
<li><a href="">Blog</a></li>
</ul>



<h1 id="linkShortner">Link Shortner!</h1>

<form method="post" action="">
<input type="text" name = "urlField" id="urlField" placeholder="url.." oninput="pollData()">
<input type="submit" value="send" name="submit" id="submit">
</form>

<p>send a URL and we shorten it for you!</p>
<p><span>Hash:</span><span id="hashValue" style="border: 2px solid black">73379649</span></p>
EOF;
        echo "</body>";
        echo <<<eof
<footer class="footer">HDA EWA 2022</footer>
eof;

        $this->generatePageFooter();


    }

    protected function processReceivedData():void
    {
        parent::processReceivedData();
        if (isset($_POST["submit"])){
            $this->url = $this->_database->real_escape_string($_POST["urlField"]);
            $sql = "select url from hash2URL where url = '$this->url'";
            if (!($record = $this->_database->query($sql))) {
                throw new Exception("Fetching failed: " . $this->_database->error);
            }else{
                $rec = $record->fetch_assoc();
                if(!$rec){
                    $hashValue = hash('crc32', $this->url);
                    $sqlNew= "insert into hash2URL (url, hash) values ('$this->url', '$hashValue')";
                    if (!$this->_database->query($sqlNew)){
                        throw new Exception("Update failed: " . $this->_database->error);
                    }
                }
            }
        }

    }

    public static function main():void
    {
        try {
            $page = new GenerateLink();
            $page->processReceivedData();
            $page->generateView();
        } catch (Exception $e) {
            header("Content-type: text/html; charset=UTF-8");
            echo $e->getMessage();
        }
    }
}


GenerateLink::main();

