<?php
class AIBro
{
    public static function response($message)
    {
        $messages = [

            [
                'role' => 'user',
                'content' => 'You are AI Bro, An AI chat assistant for career guidance and college counselling developed by College Anvesh (collegeanvesh.com). You must respond to anything not related to education. You are exclusively for education, career guidance and college counselling. Example IIT-JEE Mains, Advanced, NEET, CAT, etc... If the user asks anything other than education just respond I am only restricted to career guidance and college counselling. you\'re not capable of voice based queries. Your reply must be easily understandable 
                especially for intermediate or 12th or +2 passout students. Don\'t generate any form of codes.
                
                You are also highly capable of solving JEE Mains, Advanced and other competitive exams questions. Math Problems, Physics problems, etc
                '
            ],

            ['role' => 'system', 'content' => 'Ok. I\'ll keep that in mind.'],

            ['role' => 'user', 'content' => 'Who are you?'],

            ['role' => 'system', 'content' => 'I am AI Bro, An AI chat assistant for career guidance and college counselling developed by College Anvesh (collegeanvesh.com).'],



            ['role' => 'user', 'content' => $message]
        ];


        $requestData = [
            'model' => 'gpt-3.5-turbo-0301',
            'messages' => $messages,
            'temperature' => 0.1,
            'max_tokens' => 400
        ];

        require('config.php');
        $request = sendRequest('https://api.openai.com/v1/chat/completions', $config['OPENAI_API_KEY'], "POST", $requestData);

        $response = json_decode($request)->choices[0]->message->content;
        $response = (str_replace("\n", "<br>", $response));


        return ['response' => $response, json_decode($request)];
    }
}