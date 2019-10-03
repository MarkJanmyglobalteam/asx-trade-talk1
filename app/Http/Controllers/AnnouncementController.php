<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class AnnouncementController extends Controller
{
     public function getSymbols(){
    	   $symbols = [
                [
	                'id' => 1,
	                'abbr' => 'AAC',
	                'name' => 'AUSTRALIAN AGRICULTURAL COMPANY LIMITED.',
	                'price' => '$1.56',
	                'rate' => '1.27%',
	                'rate_type' => 'label-danger'
            	],
            	[
	                'id' => 2,
	                'abbr' => 'A88',
	                'name' => 'AdvanceTC Limited',
	                'price' => '$0.82',
	                'rate' => '0%',
	                'rate_type' => 'label-success'
            	],
            	[
	                'id' => 3,
	                'abbr' => 'A2M',
	                'name' => 'THE A2 MILK COMPANY LIMITED',
	                'price' => '$6.78',
	                'rate' => '1.88%',
	                'rate_type' => 'label-success'
            	],
            	[
	                'id' => 4,
	                'abbr' => '1AG',
	                'name' => 'ALTERRA LIMITED',
	                'price' => '3.8¢',
	                'rate' => '0%',
	                'rate_type' => 'label-success'
            	],
            	[
	                'id' => 5,
	                'abbr' => 'A3D',
	                'name' => 'AURORA LABS LIMITED',
	                'price' => '83.0¢',
	                'rate' => '8.79%',
	                'rate_type' => 'label-success'
            	],
            	[
	                'id' => 6,
	                'abbr' => '1AD',
	                'name' => 'ADALTA LIMITED',
	                'price' => '23.5¢',
	                'rate' => '6.82%',
	                'rate_type' => 'label-success'
            	],
            	[
	                'id' => 7,
	                'abbr' => '4WD',
	                'name' => 'AUTOMOTIVE SOLUTIONS GROUP LTD',
	                'price' => '33.5¢',
	                'rate' => '0.74%',
	                'rate_type' => 'label-danger'
            	],
            	[
	                'id' => 8,
	                'abbr' => 'BAR',
	                'name' => 'BARRA RESOURCES LIMITED',
	                'price' => '5.8¢',
	                'rate' => '7.94%',
	                'rate_type' => 'label-danger'
            	],
            	[
	                'id' => 9,
	                'abbr' => 'BAS',
	                'name' => 'BASS OIL LIMITED',
	                'price' => '0.4¢',
	                'rate' => '14.3%',
	                'rate_type' => 'label-success'
            	],
            	[
	                'id' => 10,
	                'abbr' => 'BAU',
	                'name' => 'BAUXITE RESOURCES LIMITED',
	                'price' => '8.1¢',
	                'rate' => '1.22%',
	                'rate_type' => 'label-danger'
            	],
    	   ];


    	   return response()->json($symbols);
    }

    public function getAnnouncements(){

    	 $announcement = [
    	 	[
    	 		'tags' => 'SXA',
    	 		'summary' => 'Notice of Annual General Meeting/Proxy Form',
    	 		'release_date' => Carbon::now()->format('d/m/Y H:i'),
    	 		'download' => '-',
    	 		'price_sensitive' => 'N',
    	 		'views' => '0'
    	 	],
    	 	[
    	 		'tags' => 'NVL',
    	 		'summary' => 'Becoming a substantial holder',
    	 		'release_date' => Carbon::now()->format('d/m/Y H:i'),
    	 		'download' => '-',
    	 		'price_sensitive' => 'N',
    	 		'views' => '0'
    	 	],
    	 	[
    	 		'tags' => 'MLA',
    	 		'summary' => 'AMENDED ANNEXURE TO ANNOUNCEMENT RE SCHEME MEETING',
    	 		'release_date' => Carbon::now()->format('d/m/Y H:i'),
    	 		'download' => '-',
    	 		'price_sensitive' => 'N',
    	 		'views' => '4'
    	 	],
    	 	[
    	 		'tags' => 'EHL',
    	 		'summary' => 'Change in substantial holding - Brookfield',
    	 		'release_date' => Carbon::now()->format('d/m/Y H:i'),
    	 		'download' => '-',
    	 		'price_sensitive' => 'N',
    	 		'views' => '3'
    	 	],
    	 	[
    	 		'tags' => 'LCT',
    	 		'summary' => 'Results of Annual General Meeting',
    	 		'release_date' => Carbon::now()->format('d/m/Y H:i'),
    	 		'download' => '-',
    	 		'price_sensitive' => 'N',
    	 		'views' => '26'
    	 	],
    	 	[
    	 		'tags' => 'SRG',
    	 		'summary' => 'SRG 2017 AGM Results',
    	 		'release_date' => Carbon::now()->format('d/m/Y H:i'),
    	 		'download' => '-',
    	 		'price_sensitive' => 'N',
    	 		'views' => '7'
    	 	],
    	 	[
    	 		'tags' => 'MPX',
    	 		'summary' => 'Results of Meeting',
    	 		'release_date' => Carbon::now()->format('d/m/Y H:i'),
    	 		'download' => '-',
    	 		'price_sensitive' => 'N',
    	 		'views' => '7'
    	 	],
    	 	[
    	 		'tags' => 'WOR',
    	 		'summary' => 'Appendix 3B',
    	 		'release_date' => Carbon::now()->format('d/m/Y H:i'),
    	 		'download' => '-',
    	 		'price_sensitive' => 'N',
    	 		'views' => '11'
    	 	],
    	 	[
    	 		'tags' => 'MMJ',
    	 		'summary' => 'Section 708 Notice and Appendix 3B',
    	 		'release_date' => Carbon::now()->format('d/m/Y H:i'),
    	 		'download' => '864.4KB',
    	 		'price_sensitive' => 'N',
    	 		'views' => '144'
    	 	],
    	 ];


    	 return response()->json($announcement);
    }
}
