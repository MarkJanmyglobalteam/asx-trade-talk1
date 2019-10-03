<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Stream;


class StreamController extends Controller
{
    public function createPost(Request $request){

    	$data = $request->all();

    	if(!Stream::create($data)){
    		return response()->json([
    			'success' => false,
    			'msg' => 'Something went wrong.'
    		], 500);
    	}
    	return response()->json([
    		'success' => true,
    		'msg' => 'Stream successfully posted!'
    	], 200);

    }

    public function getPost(){
    	$streams = Stream::all();
    	return response()->json($streams);
    }
}
