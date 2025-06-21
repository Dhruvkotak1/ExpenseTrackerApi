<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function sendResponse($msg,$data=null){
        $response = [
            'status' => true,
            'msg' => $msg,
            'data' => $data,
        ];
        return response()->json($response,200);
    }

    public function sendError($msg,$errors = [],$code = 400){
        $response = [
            'status' => false,
            'msg' => $msg
        ];

        if(!empty($errors)){
            $response['data'] = $errors;
        }

        return response()->json($response,$code);
    }
}

