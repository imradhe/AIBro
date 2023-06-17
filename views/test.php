<?php
errors();
define('OPENAI_API_KEY', $config['OPENAI_API_KEY']);
define('MODEL_ID', 'curie'); // The base model to be fine-tuned


$apiKey = OPENAI_API_KEY;
$modelId = MODEL_ID;

$baseUrl = 'https://api.openai.com/v1';

$trainingUrl = $baseUrl . '/fine-tunes';

$trainingPayload = [
    'model' => $modelId,
    'training_file' => 'training_data.csv',
    'n_epochs' => 3,
    'batch_size' => 4,
    // Additional fine-tuning parameters can be added here
];

$trainingHeaders = [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $apiKey,
];

$trainingOptions = [
    'http' => [
        'header' => implode("\r\n", $trainingHeaders),
        'method' => 'POST',
        'content' => json_encode($trainingPayload),
    ],
];


$trainingResponse = sendRequest($trainingUrl, $config['OPENAI_API_KEY'], "POST", $trainingPayload);

if ($trainingResponse === false) {
    die('Error occurred while fine-tuning the model.');
}

$trainingResult = json_decode($trainingResponse, true);
print_r(($trainingResult));
//$fineTunedModelId = $trainingResult['id'];

//echo 'Fine-tuning successful. Fine-tuned model ID: ' . $fineTunedModelId;
?>
