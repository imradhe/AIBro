<?php
controller('AIBro');
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $data = AIBro::response($_POST['message']);
    
    if (!empty($data)) {
        $res['status'] = '200';
        $res['message'] = 'Success';
        $res['data'] = $data;
    } else {
        $res['status'] = '500';
        $res['message'] = "No Data";
        $res['data'] = $data;
    }

http_response_code($res['status']);
header('Content-Type: application/json');
echo json_encode($res);

}
else unauthorized();

// I want to know bes institutes for GATE coaching in Chennai