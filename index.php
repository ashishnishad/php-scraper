<?php
require 'vendor/autoload.php';
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
$option_chain_ind = "https://www.nseindia.com/api/option-chain-indices?symbol=NIFTY";

$httpClient = new \GuzzleHttp\Client();


// $response = $httpClient->get('GET', $option_chain_ind);
$request = new Request('GET', $option_chain_ind);

$response = $httpClient->send($request, [
    'headers' => [
        'Pragma' => 'no-cache',
        'Cache-Control' => 'no-cache',
        'Upgrade-Insecure-Requests' => '1',
        'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.75 Safari/537.36',
        'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
        'Accept-Language' => 'en-US,en;q=0.9',
        'Accept-Encoding' => 'gzip, deflate, br'
    ]
]);
$response_body = $response->getBody();
$response_body = json_decode($response_body);

$ce = $response_body->filtered->CE;
$pe = $response_body->filtered->PE;
print_r($ce);
?>
<table width="500" border="1">
   <tbody>
     <tr>
         <th>Name</th>
         <th colspan="2">CALLS</th>
         <th colspan="2">PUTS</th>
      </tr>
       <tr>
         <td>NIFTY</td>
         <td><?php echo $ce->totVol; ?></td>
         <td><?php echo $ce->totOI; ?></td>
          <td><?php echo $pe->totVol; ?></td>
         <td><?php echo $pe->totOI; ?></td>
      </tr>
      <tr>
         <td>FIN-NITY</td>
         <td><?php echo $ce->totVol; ?></td>
         <td><?php echo $ce->totOI; ?></td>
          <td><?php echo $pe->totVol; ?></td>
         <td><?php echo $pe->totOI; ?></td>
      </tr>
        <tr>
	     <td>BANKNIFTY</td>
	     <td><?php echo $ce->totVol; ?></td>
         <td><?php echo $ce->totOI; ?></td>
          <td><?php echo $pe->totVol; ?></td>
         <td><?php echo $pe->totOI; ?></td>
	  </tr>
   </tbody>
</table>