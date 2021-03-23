<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Response, Route;

class MainController extends Controller
{
    protected function getResponse($code=200,$message='',$data=NULL)
    {
    	$status=($code==200)? 1 : 0;
    	if(is_array($data)){
    	    $data=$data;
    	}
    	else if($data==NULL){
    	    $data=(Object)[];
    	}
    	else{
    	     $data=$data;
    	}
        //$data=($data==NULL)? (Object)[] : $data;
        $this->resultFormat = [
            'message'  => $message,
            'data'     => $data,
            'status'   => $status,
        ];

        return Response::json($this->resultFormat,$code);
    }
	protected function getResponseMultipledata($code=200,$message='',$data=NULL,$data1=NULL)
    {
    	$status=($code==200)? 1 : 0;
    	if(is_array($data)){
    	    $data=$data;
    	}
    	else if($data==NULL){
    	    $data=(Object)[];
    	}
    	else{
    	     $data=$data;
    	}
		if(is_array($data1)){
    	    $data1=$data1;
    	}
    	else if($data1==NULL){
    	    $data1=(Object)[];
    	}
    	else{
    	     $data1=$data1;
    	}
        //$data=($data==NULL)? (Object)[] : $data;
        $this->resultFormat = [
            'message'  => $message,
            'data'     => $data,
            'records'     => $data1,
            'status'   => $status,
        ];

        return Response::json($this->resultFormat,$code);
    }
	protected function getResponsedataCount($code=200,$message='',$count='',$data=NULL)
    {
    	$status=($code==200)? 1 : 0;
    	if(is_array($data)){
    	    $data=$data;
    	}
    	else if($data==NULL){
    	    $data=(Object)[];
    	}
    	else{
    	     $data=$data;
    	}
		
        //$data=($data==NULL)? (Object)[] : $data;
        $this->resultFormat = [
            'message'  => $message,
            'total'     => $count,
            'data'     => $data,
            'status'   => $status,
        ];

        return Response::json($this->resultFormat,$code);
    }
}
