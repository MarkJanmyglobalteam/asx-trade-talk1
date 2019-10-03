<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AsxCompany;
use DB;
use App\Events\SendChat;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class TestController extends Controller
{
     public function index(){
     	  return DB::table("asx_companies")->paginate(10);
     }

     public function triggerEvent(Request $request){
          $data = $request->all();
          event(new SendChat($data));
          return response()->json(['success' => true]);
     }

     public function getAsxDetailsUsingFileContents(){
     	
     	$url = "https://www.alphavantage.co/query?function=TIME_SERIES_DAILY_ADJUSTED&symbol=ACB&apikey=EDYE98D5GTFTA1VC";
     	$data = json_decode(file_get_contents($url), true);
     	dd($data);
     
     }

     public function getAsxDetailsUsingCurl(){
        
           
            $data_list = array();
            $asx = DB::table("asx_companies")->paginate(1)->toArray();
            foreach ($asx['data'] as $key => $item) {
                $symbol = $item->asx_code;
                $url = "https://www.alphavantage.co/query?function=TIME_SERIES_DAILY_ADJUSTED&symbol=$symbol&apikey=EDYE98D5GTFTA1VC";
                $ch = curl_init();
    	     	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    	     	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    	     	curl_setopt($ch, CURLOPT_URL, $url);
    	     	$result = curl_exec($ch);
    	     	$data = json_decode($result, true);
                $data_list[$key]  = $data;
            }

	     return response()->json($data_list); 
	
     }

    private function getUrl($provider, $symbol){
        
         $apikey = "EDYE98D5GTFTA1VC";    

         if($provider == "xignite"){
               return "https://www.xignite.com/xGlobalHistorical.json/GetEndOfDayQuotes?IdentifierType=Symbol&Identifiers=$symbol.XASX&AdjustmentMethod=SplitAndProportionalCashDividend&EndOfDayPriceMethod=LastTrade&AsOfDate=11%2F20%2F2017&_token=E13A590AE883420E876E9172C7D9180D";
         }else if($provider == "alphaadvantage"){
             return "https://www.alphavantage.co/query?function=TIME_SERIES_DAILY_ADJUSTED&symbol=$symbol&apikey=$apikey";
         }else{
            return "https://www.quandl.com/api/v3/datasets/WIKI/FB/data.json?api_key=YTFx4W3WiKvNPFaKHMxB;";
         }
    
    }

    public function getData($item){

            $client = new \GuzzleHttp\Client();
            $data_list = array();
            $asx = DB::table("asx_companies")->paginate($item)->toArray();
            
            foreach ($asx['data'] as $key => $item) {
                // Send an asynchronous request.
                $symbol = $item->asx_code;
                
                $request = new \GuzzleHttp\Psr7\Request("GET", $this->getUrl("alphaadvantage",$symbol));
                
                $promise = $client->sendAsync($request)->then(function ($response) {
                    $result = $response->getBody();
                    $data = json_decode($result, true);
                    return $data;
                });

                $result = $promise->wait();
                $data_list[$key] = $result;
            
            } 

            return response()->json($data_list);
    }

}
