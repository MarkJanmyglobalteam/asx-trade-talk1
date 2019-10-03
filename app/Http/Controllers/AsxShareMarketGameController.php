<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class AsxShareMarketGameController extends Controller
{
    public function getForums($list_type){
          $forums = [
          	[
          	  'forum' => 'ASX Sharemarket Game...',
          	  'tags' => '',
          	  'thread_subject' => 'HotCopper Nov. ASX Sharemarket Game',
          	  'poster' => 'zero2a$mill',
          	  'views' => '268',
          	  'posts' => '3',
          	  'date' => Carbon::now()->format('d/m/Y'),
          	  'last_poster' => 'Madmin',
          	  'last_post' => Carbon::now()->format('d/m/Y'),
          	],
          	[
          	  'forum' => 'ASX Sharemarket Game...',
          	  'tags' => '',
          	  'thread_subject' => 'HotCopper Oct ASX Sharemarket Game',
          	  'poster' => 'Tipping Comp',
          	  'views' => '3,332',
          	  'posts' => '41',
          	  'date' => Carbon::now()->format('d/m/Y'),
          	  'last_poster' => 'h00ts',
          	  'last_post' => Carbon::now()->format('d/m/Y'),
          	],
          	[
          	  'forum' => 'ASX Sharemarket Game...',
          	  'tags' => '',
          	  'thread_subject' => 'HotCopper Abbreviations help.',
          	  'poster' => 'KyleDZ',
          	  'views' => '3,332',
          	  'posts' => '41',
          	  'date' => Carbon::now()->format('d/m/Y'),
          	  'last_poster' => 'h00ts',
          	  'last_post' => Carbon::now()->format('d/m/Y'),
          	],
          ];

 
          return response()->json($forums);
    }
}
