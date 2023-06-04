<?php
controller('AIBro');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {


    if ($_POST['count'] >= 5 || $_POST['tokens'] >= 2000) {
        $data = "Daily Limit of 5 conversations or 2000 tokens exceeded. Try again after 24 hrs\n";
        $res['status'] = '200';
        $res['message'] = 'Limit Exceeded';
        $res['data'] = $data;
    } else {
        $res['status'] = '200';
        $res['message'] = "Success";
        $res['data'] = AIBro::response($_POST['message']);
    }

    http_response_code($res['status']);
    header('Content-Type: application/json');
    echo json_encode($res);

} else
    unauthorized();