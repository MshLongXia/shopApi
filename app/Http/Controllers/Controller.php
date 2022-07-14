<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function jsonSuccess($data = [],$msg = 'success',$code = 0)
    {
        return response()->json([
            'code' => $code,
            'msg' =>$msg,
            'data'=> $data,
        ]);
    }
    public function jsonError($msg = 'error',$data = [],$code = -1)
    {
        return response()->json([
            'code' => $code,
            'msg' =>$msg,
            'data'=> $data,
        ]);
    }
}
