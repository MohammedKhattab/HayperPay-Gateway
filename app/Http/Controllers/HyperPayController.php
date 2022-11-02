<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HyperPayController extends Controller
{
    
    public function pay()
    {
        $url = "https://test.oppwa.com/v1/checkouts";
        $data = "entityId=8ac7a4c883eac73a0183ead1c3850011" .
                    "&amount=92.00" .
                    "&currency=SAR" .
                    "&paymentType=DB";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Authorization:Bearer OGFjN2E0Yzg4M2VhYzczYTAxODNlYWQwNmE1ZTAwMGN8bTV5MjgyYVdiVw=='));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if(curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        $response_decode = json_decode($responseData);
        // $response = collect(['script' =>  $response_decode->id]);
        // $response = "<script src='https://test.oppwa.com/v1/paymentWidgets.js?checkoutId=".$response_decode->id."></script>";
        $response = collect(["script" =>  "<script src='https://test.oppwa.com/v1/paymentWidgets.js?checkoutId=".$response_decode->id."'></script>"]);
        // dd($response);
        return view('hyper',compact('response'));
    }

    public function resultPay(Request $request)
    {
        // return($request);
        $url = "https://test.oppwa.com/v1/checkouts/$request->id/payment";
        $url .= "?entityId=8ac7a4c883eac73a0183ead1c3850011";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Authorization:Bearer OGFjN2E0Yzg4M2VhYzczYTAxODNlYWQwNmE1ZTAwMGN8bTV5MjgyYVdiVw=='));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if(curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        return $responseData;
       return view('hyper');

    }

}//end of class
