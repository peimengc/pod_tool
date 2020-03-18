<?php


namespace App\Helpers\Api;


use Illuminate\Support\Facades\Response;

trait ApiResponse
{
    public function suc($msg = '', $code = 0)
    {
        return $this->response(compact('code', 'msg'));
    }

    public function sucWithData($data, $msg = '', $code = 0)
    {
        return $this->response(compact('code', 'msg') + $data);
    }

    public function err($err_msg, $code = 1)
    {
        return $this->response(compact('code', 'err_msg'));
    }

    public function response($data, $status = 200, $headers = [])
    {
        return Response::json($data, $status, $headers);
    }

    public function authErr()
    {
        return $this->err('需要登陆', 2);
    }
}
