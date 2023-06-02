<?php
class AIBro{
   public static function response($message){
        $messages = [
                ['role' => 'user', 'content' => 'Which are the top IITs in India?'],
                ['role' => 'system', 'content' => 'The top IITs in India are IIT Bombay, IIT Delhi, IIT Madras, IIT Kanpur, IIT Kharagpur, and IIT Roorkee. These institutes are known for their quality education, research facilities, and placement opportunities. Each IIT has its unique strengths and areas of specialization, so it\'s advisable to explore more about each institute to find the best fit for your aspirations.'],

                ['role' => 'user', 'content' => 'What are the best colleges for medical (NEET) aspirants in India?'],
                ['role' => 'system', 'content' => 'Some of the top medical colleges in India for NEET aspirants include All India Institute of Medical Sciences (AIIMS), Christian Medical College (CMC Vellore), Armed Forces Medical College (AFMC), Maulana Azad Medical College (MAMC), and King George\'s Medical University (KGMU). These colleges are renowned for their medical programs and provide excellent learning opportunities for aspiring doctors.'],


                ['role' => 'user', 'content' => 'What are the entrance exams for MBA in India?'],
                ['role' => 'system', 'content' => 'The entrance exams for MBA in India include Common Admission Test (CAT), Xavier Aptitude Test (XAT), Management Aptitude Test (MAT), and Graduate Management Admission Test (GMAT). These exams are conducted by various institutions and play a crucial role in the admission process for MBA programs in top business schools. It\'s essential to prepare well and understand the exam pattern and syllabus for each exam to increase your chances of success.'],            
            
            // Add more questions and responses as needed

            
            ['role' => 'system', 'content' => 'You are AI Bro, An AI chat assistant for career guidance and college counselling developed by College Anvesh (collegeanvesh.com). You must respond to anything not related to education. You are exclusively for education, career guidance and college counselling. Example IIT-JEE Mains, Advanced, NEET, CAT, etc... If the user asks anything other than education just respond I amm only restricted to career guidance and college counselling. you\'re not capable of voice based queries. Your reply must be easily understandable 
            especially for intermediate or 12th or +2 passout students. Don\'t generate any form of codes.'],
            ['role' => 'user', 'content' => $message]
        ];
        
        
        $requestData = [
            'model' => 'gpt-3.5-turbo-0301',
            'messages' => $messages,
            'temperature' => 0.1,
            'max_tokens' => 500
        ];
        
        require('config.php');
        $response = sendRequest('https://api.openai.com/v1/chat/completions', $config['OPENAI_API_KEY'], "POST", $requestData);

        $response = json_decode($response)->choices[0]->message->content;
        $response = (str_replace("\n", "<br>", $response));
        
        $response = "Hi! I am AI Bro, an AI chat assistant for career guidance and college counseling. <br> <br>".$response."<br><br>I recommend you to visit collegeanvesh.com to know more";
        
        return $response;
    }
}