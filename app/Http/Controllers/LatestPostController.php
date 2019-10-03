<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class LatestPostController extends Controller
{
    public function index(){
    	 $latest_post = [
    	 	 [
       			'forum' => 'ASX - By Stocks',
       			'tags' => 'TNG',
       			'subject' => 'Re:Baby Sister',
       			'view_as' => 'Thread >>',
       			'poster' => 'scooter99',
       			'views' => '834',
       			'rating' => '',
       			'date' =>  Carbon::now()->format('H:i')
       		 ],
       		 [
       			'forum' => 'ASX - By Stocks',
       			'tags' => 'CR8',
       			'subject' => 'Re:Live webiner',
       			'view_as' => 'Thread >>',
       			'poster' => 'Tunedups',
       			'views' => '4,373',
       			'rating' => '',
       			'date' =>  Carbon::now()->format('H:i')
       		 ],
       		 [
       			'forum' => 'ASX - By Stocks',
       			'tags' => 'ASN',
       			'subject' => 'Re:Anv: Ansons Porosity Results Higher than Prev...',
       			'view_as' => 'Thread >>',
       			'poster' => 'Davekali',
       			'views' => '10,775',
       			'rating' => '',
       			'date' =>  Carbon::now()->format('H:i')
       		 ],
       		 [
       			'forum' => 'Humour',
       			'tags' => '',
       			'subject' => 'Re: How to keep hubby happy',
       			'view_as' => 'Thread >>',
       			'poster' => 'pintohoo',
       			'views' => '60',
       			'rating' => '',
       			'date' =>  Carbon::now()->format('H:i')
       		 ],
       		 [
       			'forum' => 'Charts',
       			'tags' => 'A2M',
       			'subject' => 'Re: Chart Update',
       			'view_as' => 'Thread >>',
       			'poster' => 'ndl3ss',
       			'views' => '1,823,202',
       			'rating' => '',
       			'date' =>  Carbon::now()->format('H:i')
       		 ],
       		 [
       			'forum' => 'ASX - Day Trading',
       			'tags' => '',
       			'subject' => 'Re: Afternoon Trading Nov 10',
       			'view_as' => 'Thread >>',
       			'poster' => 'valvesound',
       			'views' => '4,958',
       			'rating' => '',
       			'date' =>  Carbon::now()->format('H:i')
       		 ],
       		 [
       			'forum' => 'ASX - By Stock',
       			'tags' => 'DEG',
       			'subject' => 'Re: Options Pricing',
       			'view_as' => 'Thread >>',
       			'poster' => 'razar',
       			'views' => '3,204',
       			'rating' => '',
       			'date' =>  Carbon::now()->format('H:i')
       		 ],
       		 [
       			'forum' => 'Charts',
       			'tags' => 'S32',
       			'subject' => 'Re:S32',
       			'view_as' => 'Thread >>',
       			'poster' => '4SHADOW',
       			'views' => '5,326',
       			'rating' => '',
       			'date' =>  Carbon::now()->format('H:i')
       		 ],
       		 [
       			'forum' => 'Charts',
       			'tags' => 'AVZ',
       			'subject' => 'Re:Running Commentary on the SP Movements',
       			'view_as' => 'Thread >>',
       			'poster' => 'lecram',
       			'views' => '1,818,076',
       			'rating' => '1',
       			'date' =>  Carbon::now()->format('H:i')
       		 ],
       		 [
       			'forum' => 'ASX - By Stock',
       			'tags' => 'WBT',
       			'subject' => 'Re:Ann: Appendix 3B',
       			'view_as' => 'Thread >>',
       			'poster' => 'Soup.',
       			'views' => '9,404',
       			'rating' => '',
       			'date' =>  Carbon::now()->format('H:i')
       		 ],
       		 [
       			'forum' => 'ASX - By Stock',
       			'tags' => 'FGF',
       			'subject' => 'Re: FGF Chart',
       			'view_as' => 'Thread >>',
       			'poster' => 'Divine Inferno',
       			'views' => '1,818,076',
       			'rating' => '1',
       			'date' =>  Carbon::now()->format('H:i')
       		 ],
       		 [
       			'forum' => 'ASX - Day Trading',
       			'tags' => '',
       			'subject' => 'Re: Afternoon trading Nov 10',
       			'view_as' => 'Thread >>',
       			'poster' => 'razor11',
       			'views' => '4,958',
       			'rating' => '',
       			'date' =>  Carbon::now()->format('H:i')
       		 ],
       		 [
       			'forum' => 'ASX - Day Trading',
       			'tags' => '',
       			'subject' => 'Re: Afternoon trading Nov 10',
       			'view_as' => 'Thread >>',
       			'poster' => 'shift',
       			'views' => '4,958',
       			'rating' => '',
       			'date' =>  Carbon::now()->format('H:i')
       		 ],
       		 [
       			'forum' => 'Charts',
       			'tags' => 'BRU',
       			'subject' => 'Re: TA 2.0, the reboot',
       			'view_as' => 'Thread >>',
       			'poster' => 'h00ts',
       			'views' => '53,477',
       			'rating' => '',
       			'date' =>  Carbon::now()->format('H:i')
       		 ],
       		 [
       			'forum' => 'ASX - By Stock',
       			'tags' => 'EYM',
       			'subject' => 'Re: Ann: Everblu Research Report on Elysium Resources',
       			'view_as' => 'Thread >>',
       			'poster' => 'hirise',
       			'views' => '1,107',
       			'rating' => '',
       			'date' =>  Carbon::now()->format('H:i')
       		 ],
       		 [
       			'forum' => 'Forex',
       			'tags' => '',
       			'subject' => 'Re: Forex Monthly Trading Thread and setup ideas',
       			'view_as' => 'Thread >>',
       			'poster' => 'specgoldbug',
       			'views' => '86,842',
       			'rating' => '',
       			'date' =>  Carbon::now()->format('H:i')
       		 ],
       		 [
       			'forum' => 'ASX - By Stock',
       			'tags' => 'MSM',
       			'subject' => 'Re: Much more than a Million prizemoney',
       			'view_as' => 'Thread >>',
       			'poster' => 'Quinten',
       			'views' => '222',
       			'rating' => '',
       			'date' =>  Carbon::now()->format('H:i')
       		 ],
       		 [
       			'forum' => 'ASX - By Stock',
       			'tags' => 'NRT',
       			'subject' => 'Re: Nice work Jame Garner',
       			'view_as' => 'Thread >>',
       			'poster' => 'dunover',
       			'views' => '7,087',
       			'rating' => '1',
       			'date' =>  Carbon::now()->format('H:i')
       		 ],
    	 ];

    	 return response()->json($latest_post);
    }
}
