<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class IndexController extends Controller
{
    public function index(){
      
       $imagelist = [
	          [
	          	 'url' => 'volt-resources.jpg',
	          	 'alt' => 'volt_resources_logo',
	          	 'title' => 'Volt Resources Logo',
	          	 'abbr' => 'VRC'
	          ],
	          [
	          	 'url' => 'white-cliff-minerals-ltd.png',
	          	 'alt' => 'white_cliff_minerals_ltd_logo',
	          	 'title' => 'White Cliff Minerals LTD Logo',
	          	 'abbr' => 'WCN'
	          ],
	          [
	          	 'url' => 'impression_healthcare_limited.png',
	          	 'alt' => 'impression_healthcare_limited_logo',
	          	 'title' => 'Impression Healthcare Limited Logo',
	          	 'abbr' => 'IHL'
	          ],
	          [
	          	 'url' => 'panoramic_resources_limited.jpg',
	          	 'alt' => 'paronamic_resources_limited_logo',
	          	 'title' => 'Panoramic Resources Limited Logo',
	          	 'alt' => 'PAN'
	          ],
	          [
	          	 'url' => 'mustang_resources_limited.png',
	          	 'alt' => 'mustang_resources_limited_logoo',
	          	 'title' => 'Mustang Resources Limited Logo',
	          	 'abbr' => 'MUS'
	          ],
	          [
	          	 'url' => 'american_patriot_oil_and_gas.jpg',
	          	 'alt' => 'american_patriot_oil_and_gas_limited_logo',
	          	 'title' => 'American Patriot Oil & Gas Limited Logo',
	          	 'abbr' => 'AOW'
	          ],
	          [
	          	 'url' => 'finders_resources_limited.png',
	          	 'alt' => 'finders_resources_limited_logo',
	          	 'title' => 'Finders Resources Limited Logo',
	          	 'abbr' => 'FND'
	          ],
	          [
	          	 'url' => 'magnum_gas_and_power_limited.png',
	          	 'alt' => 'magnum_gas_and_power_limited_logo',
	          	 'title' => 'Magnum Gas & Power Limited Logo',
	          	 'abbr' => 'MPE'
	          ],
	          [
	          	 'url' => 'doray_minerals_limited.jpg',
	          	 'alt' => 'doray_minerals_limited_logo',
	          	 'title' => 'Doray Minerals Limited Logo',
	          	 'abbr' => 'DRM'
	          ],
	          [
	          	 'url' => 'middle_island_resources_limited.jpg',
	          	 'alt' => 'middle_island_resources_limited_logo',
	          	 'title' => 'Middle Island Resources Limited Logo',
	          	 'abbr' => 'MDI'
	          ],
	          [
	          	 'url' => 'crowd_mobile_limited.png',
	          	 'alt' => 'crowd_mobile_limited_logo',
	          	 'title' => 'Crowd Mobile Limited Logo',
	          	 'abbr' => 'CM8'
	          ]
       ];

       $rated_posts = [
       		 [
       			'forum' => 'ASX - By Stock',
       			'tags' => 'AUZ',
       			'subject' => 'Re: Unbelievable',
       			'view_as' => 'Thread >>',
       			'poster' => 'thaiinvest',
       			'views' => '14,536',
       			'rating' => '101',
       			'date' =>  Carbon::now()->format('Y-m-d')
       		 ],
       		 [
       			'forum' => 'ASX - By Stock',
       			'tags' => 'AUZ',
       			'subject' => 'Re: Unbelievable',
       			'view_as' => 'Thread >>',
       			'poster' => 'thaiinvest',
       			'views' => '14,536',
       			'rating' => '101',
       			'date' =>  Carbon::now()->format('Y-m-d')
       		 ],
       		 [
       			'forum' => 'ASX - By Stock',
       			'tags' => 'AUZ',
       			'subject' => 'Re: Unbelievable',
       			'view_as' => 'Thread >>',
       			'poster' => 'thaiinvest',
       			'views' => '14,536',
       			'rating' => '101',
       			'date' =>  Carbon::now()->format('Y-m-d')
       		 ],
       		 [
       			'forum' => 'ASX - By Stock',
       			'tags' => 'AUZ',
       			'subject' => 'Re: Unbelievable',
       			'view_as' => 'Thread >>',
       			'poster' => 'thaiinvest',
       			'views' => '14,536',
       			'rating' => '101',
       			'date' =>  Carbon::now()->format('Y-m-d')
       		 ],
       		 [
       			'forum' => 'ASX - By Stock',
       			'tags' => 'AUZ',
       			'subject' => 'Re: Unbelievable',
       			'view_as' => 'Thread >>',
       			'poster' => 'thaiinvest',
       			'views' => '14,536',
       			'rating' => '101',
       			'date' =>  Carbon::now()->format('Y-m-d')
       		 ],
                      
       ];

       $latest_posts = [
       		 [
       			'forum' => 'Political Debate',
       			'tags' => '',
       			'subject' => 'Re: The Turnbull govt is in crisis over citizenship',
       			'view_as' => 'Thread >>',
       			'poster' => 'Hairyback',
       			'views' => '',
       			'rating' => '',
       			'date' =>  Carbon::now()->format('Y-m-d')
       		 ],
       		 [
       			'forum' => 'Political Debate',
       			'tags' => '',
       			'subject' => 'Re: The Turnbull govt is in crisis over citizenship',
       			'view_as' => 'Thread >>',
       			'poster' => 'Hairyback',
       			'views' => '',
       			'rating' => '',
       			'date' =>  Carbon::now()->format('Y-m-d')
       		 ],
       		 [
       			'forum' => 'Political Debate',
       			'tags' => '',
       			'subject' => 'Re: The Turnbull govt is in crisis over citizenship',
       			'view_as' => 'Thread >>',
       			'poster' => 'Hairyback',
       			'views' => '',
       			'rating' => '',
       			'date' =>  Carbon::now()->format('Y-m-d')
       		 ],
       		 [
       			'forum' => 'Political Debate',
       			'tags' => '',
       			'subject' => 'Re: The Turnbull govt is in crisis over citizenship',
       			'view_as' => 'Thread >>',
       			'poster' => 'Hairyback',
       			'views' => '',
       			'rating' => '',
       			'date' =>  Carbon::now()->format('Y-m-d')
       		 ],
       		 [
       			'forum' => 'Political Debate',
       			'tags' => '',
       			'subject' => 'Re: The Turnbull govt is in crisis over citizenship',
       			'view_as' => 'Thread >>',
       			'poster' => 'Hairyback',
       			'views' => '',
       			'rating' => '',
       			'date' =>  Carbon::now()->format('Y-m-d')
       		 ],
       ];

       
       return response()->json(compact('imagelist','rated_posts','latest_posts'));
    }
}
