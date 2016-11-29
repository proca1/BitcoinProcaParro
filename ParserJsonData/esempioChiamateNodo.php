 <?php


require_once ('easybitcoin.php');

$bitcoin = new Bitcoin('bitcoinrpc','meC3JFUOE3bAGV9cv5NI43hRBngW9NsGsc0IVZHbxFjXT','10.10.20.119','8332');

$getblockhash =  $bitcoin->getblockhash(240868);
$arraygetblockhash = array("result" => $getblockhash);
$jsongetblockhash = json_encode($arraygetblockhash, true);

$getblock = $bitcoin->getblock($getblockhash);
$arraygetblock = array("result" => $getblock);
$jsongetblock = json_encode($arraygetblock, true);

$getrawtransaction = $bitcoin->getrawtransaction("de02c794fae028e737a40a39e7e9759214fb5ef9a95e0b95f9dfc55b71eb8f3f",1);
$arraygetrawtransaction = array("result" => $getrawtransaction);
$jsongetrawtransaction = json_encode($arraygetrawtransaction, true);


echo("getblockhash");
echo("</br>");
echo("</br>");
echo("</br>");

print_r($jsongetblockhash);

echo("</br>");
echo("</br>");
echo("</br>");


echo("getblock");
echo("</br>");
echo("</br>");
echo("</br>");

print_r($jsongetblock);

echo("</br>");
echo("</br>");
echo("</br>");


echo("getrawtransaction");
echo("</br>");
echo("</br>");
echo("</br>");

print_r($jsongetrawtransaction);

echo("</br>");
echo("</br>");
echo("</br>");

