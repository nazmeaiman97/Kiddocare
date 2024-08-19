<?php

function responseAPI($status, $message, $data = null, $statusCode = 200)
{
    return response()->json(['status' => $status, 'message' => $message, 'data' => $data], $statusCode);
}
