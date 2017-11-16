<?php
class q3query {
 
    private $address;
    private $port;
    private $rconpassword = false;
    private $fp;
    private $lastPing = false;
 
    public function __construct($address, $port, &$success = NULL, &$errno = NULL, &$errstr = NULL) {
        $this->address = $address;
        $this->port = $port;
 
        $this->fp = fsockopen("udp://$address", $port, $errno, $errstr, 5);
        if (!$this->fp) {
            $success = false;
        }
        else {
            $success = true;
        }
    }
 
    public function setRconpassword($pw) {
        $this->rconpassword = $pw;
    }
 
    public function rcon($str) {
        if (!$this->rconpassword) {
            return false;
        }
        $this->send("rcon " . $this->rconpassword . " $str");
        return $this->getResponse();
    }
 
    private function send($str) {
        fwrite($this->fp, "\xFF\xFF\xFF\xFF$str\x00");
    }
 
    private function getResponse() {
        stream_set_timeout($this->fp, 0, 7e5);
        $s = '';
        $start = microtime(true);
        do {
            $read = fread($this->fp, 9999);
            $s .= substr($read, strpos($read, "\n") + 1);
            if (!isset($end)) {
                $end = microtime(true);
            }
            $info = stream_get_meta_data($this->fp);
        }
        while (!$info["timed_out"]);
 
        $this->lastPing = round(($end - $start) * 1000);
                   
        return $s;
    }
 
    public function quit() {
        if (is_resource($this->fp)) {
            fclose($this->fp);
            return true;
        }
        return false;
    }
 
    public function reconnect() {
        $this->quit();
        $this->__construct($this->address, $this->port);
    }
 
    public function getGameStatus() {
        $this->send("getstatus");
        $response = $this->getResponse();
 
        list($dvarslist, $playerlist) = explode("\n", $response, 2);
 
        $dvarslist = explode("\\", $dvarslist);
        $dvars = array();
        for ($i = 1; $i < count($dvarslist); $i += 2) {
            $dvars[$dvarslist[$i]] = $dvarslist[$i + 1];
        }
 
        $playerlist = explode("\n", $playerlist);
        array_pop($playerlist);
        $players = array();
        foreach ($playerlist as $value) {
            list($score, $ping, $name) = explode(" ", $value, 3);
            $players[] = array(
                "name" =>substr($name, 1, -1),
                "score" => $score,
                "ping" => $ping
            );
        }
 
        return array($dvars, $players);
    }
 
    public function getGameInfo() {
        $this->send("getinfo");
        $response = $this->getResponse();
 
        $dvarslist = explode("\\", $response);
        $dvars = array();
        for ($i = 1; $i < count($dvarslist); $i += 2) {
            $dvars[$dvarslist[$i]] = $dvarslist[$i + 1];
        }
 
        return $dvars;
    }
 
    public function getLastPing() {
        return $this->lastPing;
    }
}
 
?>