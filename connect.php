<?php

date_default_timezone_set('Asia/Jakarta');
cli_set_process_title("BCAC v0.1");

echo "Broadband Connection Auto Connect v0.1\nby willhendyan (github.com/willhendyan)\n\n";

do{
$configFile = readline(date("[h:i:s A]") . " => Broadband config? ");
/* read config from ini */
$config = parse_ini_file(dirname(__FILE__) . "/" . $configFile, true);
if($config==null){
echo date("[h:i:s A]") . " => Invalid broadband config file!\n";
}
}while($config==null);

$broadbandName = $config['BCAC']['broadbandName'];
$user = $config['BCAC']['user'];
$pass = $config['BCAC']['pass'];

echo date("[h:i:s A]") . " => <$configFile> loaded!\n";
cli_set_process_title("BCAC v0.1 - <$configFile>");
echo date("[h:i:s A]") . " => [NAME:$broadbandName] [USER:$user] [PASS:$pass]\n";

function checkPing(){
    return exec("ping -n 1 google.com");
}

function getStr($start, $end, $string) {
    if (!empty($string)) {
    $setring = explode($start,$string);
    $setring = explode($end,$setring[1]);
    return $setring[0];
    }
}
echo date("[h:i:s A]") . " => Starting engine...\n";
while(1){
$check = checkPing();
    if(strpos($check, "could not find host")){
        echo date("[h:i:s A]") . " => Broadband connection are not connected or disconnected!\n";
        echo date("[h:i:s A]") . " => Connecting to $broadbandName...\n";
        $result = exec("rasdial $broadbandName $user $pass");
    }else if(strpos($check, "Average = ")){
        $ms = getStr("Average = ", "ms", $check);
        echo date("[h:i:s A]") . " => You're connected. Reply from google.com: time=$ms" . "ms\n";
    }
sleep(1);
}
?>