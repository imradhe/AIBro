<?php
controller('AIBro');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {


    if (($_POST['count'] >= 10 || $_POST['tokens'] >= 4000) && App::getSession()) {
        $data = "Limit exceeded. Try again after 2 hrs\n";
        $res['status'] = '200';
        $res['message'] = 'Limit Exceeded';
        $res['data'] = $data;
    }elseif(($_POST['count'] >= 3 || $_POST['tokens'] >= 800) && !App::getSession()){
        $data = "Limit exceeded. Try again after 2 hrs\n";
        $res['status'] = '200';
        $res['message'] = 'Limit Exceeded';
        $res['data'] = $data;
    } else {
        $res['status'] = '200';
        $res['message'] = "Success";
        $res['data'] = AIBro::response($_POST['message']);
    }
    if($res['message'] == "Success") {

        
        $data = ($res['data']);
       $data = array(
            'id' => $data[0]->id,
            'email' => (App::getUser())? App::getUser()['email'] : '',
            'prompt' => $_POST['message'],
            'created' => $data[0]->created,
            'message' => $data[0]->choices[0]->message->content,
        );
        DB::connect();
        $insert = DB::insert('aibro', $data);
        DB::close();
    }
    http_response_code($res['status']);
    header('Content-Type: application/json');
    echo json_encode($res);

} else
    unauthorized(); 