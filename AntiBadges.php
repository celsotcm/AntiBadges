<?php
require_once("TeamSpeak3.php"); //planetteamspeak.com
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//                         ~ Author ~                      |
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
// A: Dolo                                                 |
// B: Kick all clients with badges. (not Overwolf)         |
// C: Save the kicks in "log.txt".                         |
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//                          ~ Links ~                      |
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
// YouTube: [https://www.youtube.com/DoloDE]               |
// Github:  [https://www.Github.com/cydolo]                |
// Website: [https://www.cydolo.de/]                       |
// Discord: [https://discord.gg/VKYvJmQ]                   |
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//                          ~ Edit ~                       |
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//                         ^    -    ^                     
$a = "serveradmin"; //user                                       
$b = "PlmNfjsa"; //pass                                    
$c = "dolo.tv"; //host                                     
$d = "10011"; //queryport                                 
$e = "9987"; //serverport                                  
$f = "AntiBadges"; //nickname                              
$o = "Ouh!, no-no badges not allowed :c"; // kick message  
$y = "log.txt"; // log file
// to Activate set true 
// to Deactivate set false
$h = true; //AntiDuplicate
  $hm = "Badges duplication not allowed."; //AD - Message
$u = true; //AntiSpoof
  $um = "Badges Spoof not allowed.";  //AP - Message                                
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//                          ~ Source ~                     |
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
$con = "serverquery://".$a.":".$b."@".$c.":".$d."/?server_port=".$e."&nickname=".$f;
// http://yat.qa/ressourcen/abzeichen-badges/
$bb = array(
    "1cb07348-34a4-4741-b50f-c41e584370f7", // TeamSpeak Addon Author
    "50bbdbc8-0f2a-46eb-9808-602225b49627", // Gamescom 2016
    "d95f9901-c42d-4bac-8849-7164fd9e2310", // Paris Games Week 2016
    "62444179-0d99-42ba-a45c-c6b1557d079a", // Gamescom 2014
    "d95f9901-c42d-4bac-8849-7164fd9e2310", // Paris Games Week 2014
    "450f81c1-ab41-4211-a338-222fa94ed157", // TeamSpeak Addon Developer (Bronze)
    "c9e97536-5a2d-4c8e-a135-af404587a472", // TeamSpeak Addon Developer (Silver)
    "94ec66de-5940-4e38-b002-970df0cf6c94", // TeamSpeak Addon Developer (Gold)
    "534c9582-ab02-4267-aec6-2d94361daa2a", // Gamescom 2017
    "34dbfa8f-bd27-494c-aa08-a312fc0bb240", // Gamescom Hero 2017
    "7d9fa2b1-b6fa-47ad-9838-c239a4ddd116", // MIFCOM
    "f81ad44d-e931-47d1-a3ef-5fd160217cf8", // 4Netplayers
    "f22c22f1-8e2d-4d99-8de9-f352dc26ac5b"  // Rocket Beans TV
);
$spf = array(
    "450f81c1-ab41-4211-a338-222fa94ed157", // TeamSpeak Addon Developer (Bronze)
    "c9e97536-5a2d-4c8e-a135-af404587a472", // TeamSpeak Addon Developer (Silver)
    "94ec66de-5940-4e38-b002-970df0cf6c94" // TeamSpeak Addon Developer (Gold)
);
while (true) {
    try {
        $t = TeamSpeak3::factory($con);
        $t->clientListReset();
        foreach($t->clientList() as $l) {
            if (!$l['client_type']) {
                foreach($bb as $badges) {
                    if ($u || $h) {
                    if ($h) {
                    if (substr_count($l['client_badges'],$badges) > 1) {
                        $t->clientGetByName($l["client_nickname"])->kick(TeamSpeak3::KICK_SERVER, $hm);
                        sendlog($l['client_nickname']);
                        sleep(1);          
                    }
                }
                    if ($u) {
                        foreach($spf as $spoof) {
                            if(strstr($l['client_badges'],$spoof)) {
                                $t->clientGetByName($l["client_nickname"])->kick(TeamSpeak3::KICK_SERVER, $um);
                                sendlog($l['client_nickname']);
                                sleep(1);
                            }
                        }
                    }
                    }else {
                    if (strstr($l['client_badges'], $badges)) {
                        $t->clientGetByName($l["client_nickname"])->kick(TeamSpeak3::KICK_SERVER, $o);
                        sendlog($l['client_nickname']);
                        sleep(1);
                        }
                    }
                }
            }
        }
    } catch (Exception $x) {
        errlog($x);
    }
}

function sendlog($nickname) {
    global $y;
    $file = fopen($y, "a");
    $dn = "[".date("H:i:s")."]";
    sleep(1);
    fwrite($file, $dn." Client: ".$nickname." kicked from Server. [AntiBadges]\n");
    fclose($file);
}

function errlog($ms) {
    $file = fopen("err.txt", "a");
    fwrite($file, $ms."\n");
    fclose($file);
}
