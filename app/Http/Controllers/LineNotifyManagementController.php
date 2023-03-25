<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;

class LineNotifyManagementController extends Controller
{
	/**
	 * Step 
	 * 1. run https://xxxxxx/line-management/authorization เลือก กลุ่มหรือแชทเพื่อเอา accesstoken
	 * 2. copy access token ที่ได้จาก dd() เก็บไว้
	 * 3. เอา access token ไปใช้ตอนส่ง
     * 4. ดึง Line Notify เข้ากลุ่ม
	 * * ถ้าจะลบก็ run https://xxxxxx/line-management/revoke เปลี่ยน access token ที่ต้องการลบ
	 */
	 	
    public function authorization()
    {	
        $endpointUrl = 'https://notify-bot.line.me/oauth/authorize?';
        $callbackUrl = route('line-notify-callback');

        $query = [
            'response_type' => 'code',
            'client_id'     => env('LINE_NOTIFY_CLIENT_ID'),
            'redirect_uri'  => $callbackUrl,
            'scope'         => 'notify',
            'state'         => env('LINE_NOTIFY_STATE')
        ];
        
    	return redirect($endpointUrl . http_build_query($query));
    }

    public function callback()
    {
    	if (request()->has('code')) {
    		
    		$response = Curl::to('https://notify-bot.line.me/oauth/token')
    			->withHeader('Content-Type: application/x-www-form-urlencoded')
    			->withData([
    				'grant_type' => 'authorization_code',
    				'code' => request('code'),
    				'redirect_uri' => route('line-notify-callback'),
    				'client_id' => env('LINE_NOTIFY_CLIENT_ID'),
    				'client_secret' => env('LINE_NOTIFY_CLIENT_SECRET'),
    			])
    			->post();

    		dd($response);
    	}
    }

    public function send()
    {
    	$response = Curl::to('https://notify-api.line.me/api/notify')
			->withHeader('Content-Type: application/x-www-form-urlencoded')
			// ->withHeader('Authorization: Bearer xxxxxxxx')
            ->withHeader('Authorization: Bearer xxxxxxxx')
			->withData([
				'message' => "\nDetail: ทดสอบ\nLink: https://google.co.th\nดดดดด"
			])
			->post();
		dd($response);
    }

    public function revoke()
    {
    	$response = Curl::to('https://notify-api.line.me/api/revoke')
			->withHeader('Content-Type: application/x-www-form-urlencoded')
			->withHeader('Authorization: Bearer 2A39VZNK9eag0692FClvxt0BqanVqJvfMUWQzFXeSst')
			->post();

		dd($response);
    }
}
