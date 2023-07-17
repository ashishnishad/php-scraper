<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once __dir__.'/vendor/autoload.php';
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

?>
<table width="500" border="1">
   <tbody>
     <tr>
         <th>Name</th>
         <th colspan="4">CALLS</th>
         <th colspan="4">PUTS</th>
      </tr>
      <?php $res = getByType("NIFTY"); ?>
      <tr>
         <td></td>
         <td>Vol</td>
         <td>OI</td>
         <td>Status</td>
         <td>Action</td>
         <td>Vol</td>
         <td>OI</td>
         <td>Status</td>
         <td>Action</td>
      </tr>
       <tr>
         <td>NIFTY</td>
         <td><?php echo $res['ce_oi']; ?></td>
         <td><?php echo $res['ce_vo']; ?></td>
         <td></td>
         <td></td>
          <td><?php echo $res['pe_oi']; ?></td>
         <td><?php echo $res['pe_vo']; ?></td>
         <td></td>
         <td></td>
      </tr>
       <?php $res = getByType("FINNIFTY"); ?>
      <tr>
         <td>FIN-NITY</td>
         <td><?php echo $res['ce_oi']; ?></td>
         <td><?php echo $res['ce_vo']; ?></td>
         <td></td>
         <td></td>
          <td><?php echo $res['pe_oi']; ?></td>
         <td><?php echo $res['pe_vo']; ?></td>
         <td></td>
         <td></td>
      </tr>
       <?php $res = getByType("BANKNIFTY"); ?>
        <tr>
	     	<td>BANKNIFTY</td>
	      <td><?php echo $res['ce_oi']; ?></td>
         <td><?php echo $res['ce_vo']; ?></td>
         <td></td>
         <td></td>
          <td><?php echo $res['pe_oi']; ?></td>
         <td><?php echo $res['pe_vo']; ?></td>
         <td></td>
         <td></td>
	  </tr>
   </tbody>
</table>

<?php 

function getByType($type="NIFTY"){

	$option_chain_ind = "/api/option-chain-indices?symbol=".$type;

	$httpClient = new \GuzzleHttp\Client([
				    'base_uri' => 'https://www.nseindia.com',
				    'defaults' => [
				        'exceptions' => false
				    ]
				]);

	$request = new Request('GET', $option_chain_ind, [
							'headers' => [
								'Accept' => 'application/json'
							]
						]);

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
	$ce_oi 				 = 0;
	$ce_vo 				 = 0;

	$pe_oi 				 = 0;
	$pe_vo 				 = 0;
//	echo '<pre>'; print_r($response_body->records->data); die;
	foreach ($response_body->records->data as $key => $value) {

		if(isset($value->CE->openInterest)){
			$ce_oi = $ce_oi+$value->CE->openInterest;
		}

		if(isset($value->CE->totalTradedVolume)){
			$ce_vo = $ce_vo+$value->CE->totalTradedVolume;
		}

		if(isset($value->PE->openInterest)){
			$pe_oi = $pe_oi+$value->PE->openInterest;
		}

		if(isset($value->PE->totalTradedVolume)){
			$pe_vo = $pe_vo+$value->PE->totalTradedVolume;
		}
	}

	$res = ["ce_oi"=>$ce_oi, "ce_vo"=>$ce_vo, "pe_oi"=>$pe_oi, "pe_vo"=>$pe_vo];
	return $res;
	//echo '<pre>'; print_r($ce_vo); die;
}

?>