<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class ArticleController extends Controller
{
    
     public function index(){
        $data = [
            [
              'img' => 'HotCopper_FB_Top_10_June.png',
              'title' => 'Which stocks were our members most interested in in June?',
              'content' => 'We’ve checked our stats from June and can reveal the stocks generating the most investor interest on HotCopper. 1.[B] 88E - [/B]88 ENERGY LIMITED Energy [url]https://hotcopper.com...',
              'views' => '4,357',
              'date' => Carbon::now()->format('l jS \\of F Y')
            ],
            [
              'img' => 'Woman-on-ASX-board-chart.JPG',
              'title' => 'ASX Boards Gender Diversity Report: The Facts',
              'content' => 'New information released this month reveals that there are still 13 companies in the ASX 200 that have zero female representation on their boards. With 17 female appointments compared to 40 male appointments so far this year, there are serious concerns that the ASX 200 won’t reach the targeted 30% representation by the end of 2018...',
              'views' => '1,030',
              'date' => Carbon::now()->format('l jS \\of F Y')
            ]
        ];

        return response()->json($data);
     }


     public function stock(){

      
     }
}
