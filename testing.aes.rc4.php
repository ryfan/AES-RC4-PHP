<?php 

	include "crypto/AES.php";
	include "crypto/RC4.php";

	$key 		= substr(md5($_POST['key']), 0,16);
	$message 	= $_POST['message']; 

	### ENCRYPT PROCESS ###
	$loop 		= (strlen($message) % 16 == 0) ? strlen($message)/16 : intVal(strlen($message)/16) + 1;

	$cipherText	= "";
	for ($i=0; $i<$loop; $i++) {
		$start    = $i * 16;
		$txt	  = substr($message, $start, 16);

		$aes 	 = new AES($key);
		$enkrip  = $aes->encrypt($txt);

		$rc4 	 = new rc4($key);
		$enkrip2 = $rc4->encrypt($enkrip);

		$cipherText	.= $enkrip2;		
	}
	echo $cipherText;
	echo "<br>";

	### DECRYPT PROCESS ###
	$loop 	= (strlen($cipherText) % 16 == 0) ? strlen($cipherText)/16 : intVal(strlen($cipherText)/16) + 1;
	
	$plainText = "";
	for ($i=0; $i<$loop; $i++) {
		$start    = $i * 16;
		$txt	  = substr($cipherText, $start, 16);

		$rc4 	 = new rc4($key);
		$decrypt = $rc4->decrypt($txt);

		$aes 	 = new AES($key);
		$decrypt2  = $aes->decrypt($decrypt);

		$plainText		.= $decrypt2;
		
	}
	echo $plainText;

 ?>