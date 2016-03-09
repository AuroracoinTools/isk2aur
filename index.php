
<?php
require 'vendor/endroid/qrcode/src/QrCode.php';
require 'functions.php';
require 'isx-rates.php';
use Endroid\QrCode\QrCode;

//set default value at 0 for required value ISK, this will make a nutral QR code only showing the address. Fom functions.php
$iskvalue = getGet("isk",0);
//$iskvalue = number_format((float)$iskvalue, 6, '.', '');

//calculate ISK value to AUR using spot price from ISX market.
$tmpaur = ($iskvalue / $iskaur);
//round to 6 decimal places
$aur = number_format((float)$tmpaur, 6, '.', '');


//if address is given with GET, use that. else use address from formfield

#$postaddress = getPost("postaddress","Paste_Wallet_Address_Here");
#$address = getGet("address","$postaddress");

$address = getGet("address","Paste_Wallet_Address_Here");

//if this is no, or anything other than "yes" do not show address input field and rely on address from GET.
$addressfield = getGet("addressfield","yes");

#$address = "AcM8V615AM3dj1Xd93W43RrBMPFznggTgJ";

//below is the qr code generation and form input needed for calculation
?>
<html>
   <body>
      <div align="center">
         <p style="font-size:150%;">ISK to AUR QRcode</p>
         <?php  //display the qr code 
            echo '<a href="http://insight.auroracoin.tools/address/'.$address.'"  target="_blank"><img src="qrcodegen.php?aur='.$aur.'&walletaddress='.$address.'"></a>';
         ?>
         <form action = "<?php $_PHP_SELF ?>" method = "GET">
		<?php //hide input field if GET addressfield <> yes
		if ($addressfield == "yes") {
                  $string = '<input type = "text" name = "address" pattern="[a-zA-Z0-9]{20,34}" value = "'.$address.'" size = "34" Title="paste Wallet address here"> <br>';
		  echo $string;
		} else {
		   $string = '<input type = "hidden" name = "address" value = "'.$address.'"><input type = "hidden" name = "addressfield" value = "no"><a href="http://insight.auroracoin.tools/address/'.$address.'"  target="_blank">'.$address.'</a>';
		   echo $string;
		}
		?>
            ISK: <input type = "float" name = "isk" pattern="[0-9]+([,\.][0-9]+)?" value = "<?php echo $iskvalue ?>" size = "5" Title="Insert amount in Icelandic KRONA" autofocus/>
            <input type = "submit" value = "Display QR-Code" />
         </form>
         <a href="https://beta.isx.is" target="_blank">ISX</a>
         <?php echo " exchange rate: " . $iskaur . "kr./AUR<br>";
               echo "QRcode generated " . date("D j. M Y H:i")."<br>"; ?>
         <a href="info.htm" target="_blank"> info</a>
      </div>
   </body>
</html>


