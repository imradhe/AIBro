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
                
                ['role' => 'user', 'content' => 'Give the latest list of colleges by NIRF'],
            
                ['role' => 'system', 'content' => 'Here is the list of colleges & Institutes by NIRF 2022
                | Category/Discipline | Total Number of Institutions | CFTIs and CFUs |
                | ------------------- | ---------------------------- | -------------- |
                | Overall             | 1876                         | 88             |
                | Engineering         | 1249                         | 46             |
                | Pharmacy            | 401                          | 9              |
                | Architecture        | 91                           | 12             |
                | Medical             | 151                          | 2              |
                | Research            | 176                          | 42             |
                | Dental              | 142                          | 3              |
                | College             | 2270                         | 1              |
                | Law                 | 147                          | 7              |
                | Management          | 751                          | 27             |
                | Total               | 7254                         | 237            |
                
                Hope this is helpful for you
                '],
                
                
                ['role' => 'user', 'content' => 'Latest NIRF Rankings for universities'],

                ['role' => 'system', 'content' => 'Here is the NIRF Ranking for universities 2022
                
                | Institute ID | Name                                         | City       | State         | Score | Rank |
                | ------------ | -------------------------------------------- | ---------- | ------------- | ----- | ---- |
                | IR-O-U-0220  | Indian Institute of Science                  | Bengaluru  | Karnataka     | 83.57 | 1    |
                | IR-O-U-0109  | Jawaharlal Nehru University                  | New Delhi  | Delhi         | 68.47 | 2    |
                | IR-O-U-0108  | Jamia Millia Islamia, New Delhi              | New Delhi  | Delhi         | 65.91 | 3    |
                | IR-O-U-0575  | Jadavpur University                          | Kolkata    | West Bengal   | 65.37 | 4    |
                | IR-O-U-0436  | Amrita Vishwa Vidyapeetham<br>               | Coimbatore | Tamil Nadu    | 63.40 | 5    |
                | IR-O-U-0500  | Banaras Hindu University                     | Varanasi   | Uttar Pradesh | 63.20 | 6    |
                | IR-O-U-0234  | Manipal Academy of Higher Education, Manipal | Manipal    | Karnataka     | 62.84 | 7    |
                | IR-O-U-0570  | Calcutta University                          | Kolkata    | West Bengal   | 62.23 | 8    |
                | IR-O-U-0490  | Vellore Institute of Technology              | Vellore    | Tamil Nadu    | 61.77 | 9    |
                | IR-O-U-0042  | University of Hyderabad                      | Hyderabad  | Telangana     | 61.71 | 10   |

                Hope this is helpful for you
                '],

                ['role' => 'user', 'content' => 'Latest NIRF Rankings for colleges'],

                ['role' => 'system', 'content' => 'Here is the NIRF Ranking for colleges 2022
                
                | Institute ID | Name                               | City       | State       | Score | Rank |
                | ------------ | ---------------------------------- | ---------- | ----------- | ----- | ---- |
                | IR-C-C-6355  | Miranda House                      | Delhi      | Delhi       | 78.00 | 1    |
                | IR-C-C-6377  | Hindu College                      | Delhi      | Delhi       | 71.86 | 2    |
                | IR-C-C-43921 | Presidency College                 | Chennai    | Tamil Nadu  | 71.67 | 3    |
                | IR-C-C-44006 | Loyola College                     | Chennai    | Tamil Nadu  | 71.00 | 4    |
                | IR-C-C-6415  | Lady Shri Ram College For Women    | New Delhi  | Delhi       | 70.83 | 5    |
                | IR-C-C-41046 | PSGR Krishnammal College for Women | Coimbatore | Tamil Nadu  | 70.68 | 6    |
                | IR-C-C-22462 | Atma Ram Sanatan Dharm College     | New Delhi  | Delhi       | 70.46 | 7    |
                | IR-C-C-11881 | St. Xavier\`s College              | Kolkata    | West Bengal | 69.54 | 8    |
                | IR-C-C-11926 | Ramakrishna Mission Vidyamandira   | Howrah     | West Bengal | 69.24 | 9    |
                | IR-C-C-6385  | Kirori Mal College                 | Delhi      | Delhi       | 68.53 | 10   |

                Hope this is helpful for you
                '],

                
                ['role' => 'user', 'content' => 'Latest NIRF Rankings for Engineering Colleges'],

                ['role' => 'system', 'content' => 'Here is the NIRF Ranking for Engineering colleges 2022

                | Institute ID | Name                                                  | City            | State         | Score | Rank |
                | ------------ | ----------------------------------------------------- | --------------- | ------------- | ----- | ---- |
                | IR-E-U-0456  | Indian Institute of Technology Madras                 | Chennai         | Tamil Nadu    | 90.04 | 1    |
                | IR-E-I-1074  | Indian Institute of Technology, Delhi                 | New Delhi       | Delhi         | 88.12 | 2    |
                | IR-E-U-0306  | Indian Institute of Technology, Bombay                | Mumbai          | Maharashtra   | 83.96 | 3    |
                | IR-E-I-1075  | Indian Institute of Technology Kanpur                 | Kanpur          | Uttar Pradesh | 82.56 | 4    |
                | IR-E-U-0573  | Indian Institute of Technology, Kharagpur             | Kharagpur       | West Bengal   | 78.89 | 5    |
                | IR-E-U-0560  | Indian Institute of Technology, Roorkee               | Roorkee         | Uttarakhand   | 76.70 | 6    |
                | IR-E-U-0053  | Indian Institute of Technology Guwahati               | Guwahati        | Assam         | 72.98 | 7    |
                | IR-E-U-0467  | National Institute of Technology, Tiruchirappalli     | Tiruchirappalli | Tamil Nadu    | 69.17 | 8    |
                | IR-E-U-0013  | Indian Institute of Technology Hyderabad              | Hyderabad       | Telangana     | 68.03 | 9    |
                | IR-E-U-0237  | National Institute of Technology Karnataka, Surathkal | Surathkal       | Karnataka     | 66.04 | 10   |

                Hope this is helpful for you
                '],

                ['role' => 'user', 'content' => 'Latest NIRF Rankings for Medical Colleges'],

                ['role' => 'system', 'content' => 'Here is the NIRF Ranking for Medical colleges 2022

                | Institute ID | Name                                                                                  | City               | State         | Score | Rank |
                | ------------ | ------------------------------------------------------------------------------------- | ------------------ | ------------- | ----- | ---- |
                | IR-D-N-15    | All India Institute of Medical Sciences, Delhi                                        | New Delhi          | Delhi         | 91.60 | 1    |
                | IR-D-U-0079  | Post Graduate Institute of Medical Education and Research                             | Chandigarh         | Chandigarh    | 79.00 | 2    |
                | IR-D-C-45654 | Christian Medical College                                                             | Vellore            | Tamil Nadu    | 72.84 | 3    |
                | IR-D-U-0236  | National Institute of Mental Health & Neuro Sciences, Bangalore                       | Bangalore          | Karnataka     | 71.56 | 4    |
                | IR-D-U-0500  | Banaras Hindu University                                                              | Varanasi           | Uttar Pradesh | 68.12 | 5    |
                | IR-D-U-0368  | Jawaharlal Institute of Post Graduate Medical Education & Research                    | Puducherry         | Pondicherry   | 67.64 | 6    |
                | IR-D-N-33    | Sanjay Gandhi Postgraduate Institute of Medical Sciences                              | Lucknow            | Uttar Pradesh | 67.18 | 7    |
                | IR-D-U-0436  | Amrita Vishwa Vidyapeetham                                                            | Coimbatore         | Tamil Nadu    | 66.49 | 8    |
                | IR-D-U-0266  | Sree Chitra Tirunal Institute for Medical Sciences and Technology, Thiruvananthapuram | Thiruvananthapuram | Kerala        | 65.17 | 9    |
                | IR-D-C-7242  | Kasturba Medical College, Manipal                                                     | Manipal            | Karnataka     | 63.89 | 10   |


                Hope this is helpful for you
                '],

            // Add more questions and responses as needed

            
            ['role' => 'system', 'content' => 'You are AI Bro, An AI chat assistant for career guidance and college counselling developed by College Anvesh (collegeanvesh.com). You must respond to anything not related to education. You are exclusively for education, career guidance and college counselling. Example IIT-JEE Mains, Advanced, NEET, CAT, etc... If the user asks anything other than education just respond I am only restricted to career guidance and college counselling. you\'re not capable of voice based queries. Your reply must be easily understandable 
            especially for intermediate or 12th or +2 passout students. Don\'t generate any form of codes.'],
            ['role' => 'user', 'content' => $message]
        ];
        
        
        $requestData = [
            'model' => 'gpt-3.5-turbo-0301',
            'messages' => $messages,
            'temperature' => 0.1
        ];
        
        require('config.php');
        $response = sendRequest('https://api.openai.com/v1/chat/completions', $config['OPENAI_API_KEY'], "POST", $requestData);

        $response = json_decode($response)->choices[0]->message->content;
        $response = (str_replace("\n", "<br>", $response));
        
        $response = "Hi! I am AI Bro, an AI chat assistant for career guidance and college counseling. <br> <br>".$response."<br><br>I recommend you to visit collegeanvesh.com to know more";
        
        return $response;
    }
}