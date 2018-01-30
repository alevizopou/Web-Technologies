<?php
session_start();
$response = $_SESSION['response'];

 $con = mysql_connect("localhost","root","");
if (!$con)
	die('Could not connect: ' . mysql_error());
	
mysql_set_charset('utf8',$con);  
mysql_select_db("my_db", $con);
mysql_query("SET NAMES 'utf8'", $con);

$xml_file = "info.xml";
$flagg=0;

//elegxos an to arxeio info.xml yparxei ston fakelo pou doulevoume
$dir_album = opendir("./");
	
while (($list_file = readdir($dir_album)) !== false)
{
	$ffilename = iconv("CP737" ,"UTF-8", $list_file);
	//periptwsi pou yparxei
	if($ffilename==$xml_file)
	{	
		$flagg =1;
	}
}
closedir($dir_album);
	
//ean to info.xml yparxei idi, to diagrafoume
if($flagg==1){
	unlink($xml_file);
}

//dimiourgia arxeiou info.xml
$handle = fopen($xml_file, "a") or die('Cannot open file:  '.$xml_file);

$data = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
fwrite($handle,$data);
$data="<orders>";
fwrite($handle,$data);
$i=0;
for ($i=0;$i<count($response);$i++)
{
	$data = "<order>";
	fwrite($handle,$data);
	$data2 = mysql_query("SELECT * FROM item_in_order WHERE order_id LIKE'$response[$i]'"); 
	
	$flag = 0;
	
	while($result = mysql_fetch_array( $data2 )) {

	if($flag == 0){
	
	$data = "<date>";
	fwrite($handle,$data);
	$data = $result['order_date'];
	fwrite($handle,$data);
	$data = "</date>";
	fwrite($handle,$data);
	
	$data = "<waiter>";
	fwrite($handle,$data);
	$data = $result['waiter_name'];
	fwrite($handle,$data);
	$data = "</waiter>";
	fwrite($handle,$data);
	}
	
	$data = "<product>";
	fwrite($handle,$data);
	$data = $result['product_name'] . " " . $result['property_name'];
	fwrite($handle,$data);
	$data = "</product>";
	fwrite($handle,$data);
	
	$flag++;
	
}
	//to synoliko price to pairnoume apo to table orders
	$dataa = mysql_query("SELECT * FROM orders WHERE id LIKE '$response[$i]'"); 
	$result2 = mysql_fetch_array( $dataa );
	
	$data = "<price>";
	fwrite($handle,$data);
	$data = $result2['price'];
	fwrite($handle,$data);
	$data = "</price>";
	fwrite($handle,$data);
	
	$data = "</order>";
	fwrite($handle,$data);
}

$data="</orders>";
fwrite($handle,$data);

fclose($handle);

//kwdikas gia to download tou arxeiou sto pc tou user
if (file_exists($xml_file)) {
	
    // send headers that indicate file download
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename='.basename($xml_file));
    header('Content-Transfer-Encoding: binary');
    header('Content-Length: ' . filesize($xml_file));
    ob_clean();
    flush();
    readfile($xml_file);
	unlink($xml_file);
    exit;
}

?>