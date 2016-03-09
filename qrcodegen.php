<?php

//Require the library and common functions.
require 'functions.php';
require 'vendor/endroid/qrcode/src/QrCode.php';

use Endroid\QrCode\QrCode;

//set some default values for GET variables if they are not sent on the http call.
$aurvalue = getGet("aur","0.000000");
$iskvalue = getGet("isk","0.000000");
$address = getGet("walletaddress","walletaddress_missing");
$qrcodesize = getGet("qrsize","250");
$substring = getGet("showlabel","yes");


//set value to chosen output, either calculated from isk or straight to aur from input.
//If both inputs are missing, AUR will be 0 and pure address QRcode is generated. If both are set, AUR will dominate.
if ($aurvalue <> "0.000000"){
        $value = number_format((float)$aurvalue, 6, '.', '');
    } else {
//get the price from ISX market and store as $isxrate
         $url = 'https://beta.isx.is/api/stats';
         $json = file_get_contents($url);
         $json = json_decode($json);
         $isxrate = $json->stats->last_price;
//calculate the AUR from ISK input and ISKVALUE from ISX market
         $iskvalue = ($iskvalue / $isxrate);
//round to 6 decimal places
         $iskvalue = number_format((float)$iskvalue, 6, '.', '');
         $value = "$iskvalue";
}


//if no value sent, make a neautral QR-code with only the address. Else make a QR-code with value.
if ($value == "0.000000"){
	$qrcodetxt = "auroracoin:$address";
    } else {
        $qrcodetxt = "auroracoin:$address" . "?amount=" . "$value";
}

//Hide label if it is not required
if ($substring == "yes") {
      $qrlabel = "$value AUR";
   }else{
      $qrlabel = "";
}


//Build the QR code with help from ENDROID qrcode generator library.
header('Content-Type: image/png');
$qrCode = new QrCode();
$qstring = $qrCode
    ->setText("$qrcodetxt")
    ->setSize($qrcodesize)
    ->setPadding(10)
    ->setErrorCorrection('low')
    ->setForegroundColor(array('r' => 0, 'g' => 0, 'b' => 0, 'a' => 0))
    ->setBackgroundColor(array('r' => 255, 'g' => 255, 'b' => 255, 'a' => 0))
    ->setLabel("$qrlabel")
    ->setLabelFontSize($qrcodesize/10)
    ->render()
;


?>


