<?

function readStrLine($str, $n) {
    $lines = explode(PHP_EOL, $str);
    return $lines[$n-1];
}
if (isset($_GET['kelas'])):
$kelas = $_GET['kelas'];
else:
$kelas ="2ka01";
endif;
$kelas = strtoupper($kelas);


$ssd = "cari=".$kelas."&bywhat=kelas&search_button.x=0&search_button.y=0&substep=search";

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL,"http://baak.gunadarma.ac.id/index.php?stateid=jadkul");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,$ssd);
curl_setopt($ch, CURLOPT_USERAGENT,"PungBearBot: pungbear.blogspot.co.id");


curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$filenya = curl_exec ($ch);


curl_close ($ch);




$hasild ="<html><body>";
$hasild .= readStrLine($filenya, 303);
$hasild .= "</body></html>";
include("simple_html_dom.php");
$html = str_get_html($hasild);

$cells = $html->find('td');
$arg1 = array();
$kelas = array();
$hari = array();
$matkul = array();
$waktu = array();
$ruang = array();
$dosen = array();
$nomor =1;
foreach($cells as $cell) {
    
    
        array_push($arg1, $cell->plaintext);

        
    }
    

foreach ($arg1 as $p) {
  
    switch ($nomor) {
        case 1: array_push($kelas,$p);
        break;
        case 2: array_push($hari, $p);
        break;
        case 3: array_push($matkul, $p);
        break;
        case 4: array_push($waktu, $p);
        break;
        case 5: array_push($ruang, $p);
        break;
        case 6: array_push($dosen, $p);
        break;
    }
      $nomor+=1;
    
    if ($nomor > 6):
    $nomor =1;
    endif;
}
$response["response_code"] = 200;
$response["data"]   = array();
$response["pungbear"] = "v.1.0";
array_push($response["data"],$kelas,$hari,$matkul,$waktu,$ruang,$dosen);
echo json_encode($response);

?>
