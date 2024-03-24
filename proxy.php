<?php
// Hercai API endpoint
$hercaiApiUrl = 'https://hercai.onrender.com/v3/hercai';

// Get the question from the query string
$question = $_GET['question'];

// Set up cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $hercaiApiUrl . '?question=' . urlencode($question));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute the request
$response = curl_exec($ch);

// Check for errors
if(curl_errno($ch)) {
    echo 'Error: ' . curl_error($ch);
    exit;
}

// Close the cURL handle
curl_close($ch);

// Decode the JSON response
$responseData = json_decode($response, true);

// Check if response is valid JSON
if($responseData === null) {
    echo 'Error: Invalid JSON response';
    exit;
}

// Check if response contains the 'reply' field
if(isset($responseData['reply'])) {
    // Output only the 'reply' field
    echo $responseData['reply'];
} else {
    echo 'Error: Reply not found in response';
}
?>
