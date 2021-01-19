
<?php
if(hasParam('query'))
{
  header('Content-Type: application/json');
  $cab = strtoupper($_REQUEST['query']);

  $csv = "https://raw.githubusercontent.com/WokeWorld/Australia-Telstra-Payphone-Number-Database/main/full-telstra-phonebox-database.csv";

 
 $lines = file($csv);
 $responseArr = array();
 $count = 0;
     foreach($lines as $line) { 
         if(strpos($line,$cab) !== false)
          {
               $items = explode('"',trim($line));
               $cid = str_replace(",","",trim($items[0]));
               $loc = trim(str_replace(',',"",trim($items[1])));
               $pc = trim(str_replace(',',"",trim($items[2])));
               $st = trim(str_replace(',',"",trim($items[4])));
               $addr = str_replace('  '," ",($loc.", ".$st.", ".$pc));
               $ph = trim($items[5]);
               $responseArr[$count] = array(
                          "Cabinet ID" => $cid,
                          "Address" => $addr ,
                          "Number" => $ph
               );
$count++;
           }
       
       
}

      header("HTTP/1.1 200 OK");
      http_response_code(200);

      echo json_encode($responseArr,JSON_PRETTY_PRINT); 
      exit();
}
else
{
  header("HTTP/1.1 300 ERROR");
      http_response_code(300);
      echo json_encode(array(
                          "Error" => "Invalid Query Provided",
               ),JSON_PRETTY_PRINT); 
      exit();

}


function hasParam($param) 
{
   return array_key_exists($param, $_REQUEST);
}
?>
