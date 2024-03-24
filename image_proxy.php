<?php
// Get the question from the query parameters
$question = $_GET['question'];

// Construct the URL for the API endpoint with the provided question as the prompt
$apiUrl = 'https://hercai.onrender.com/v3/text2image?prompt=' . urlencode($question);

// Initialize a cURL session
$curl = curl_init();

// Set cURL options
curl_setopt_array($curl, [
    CURLOPT_URL => $apiUrl,  // Set the API URL
    CURLOPT_RETURNTRANSFER => true, // Return the response as a string
    CURLOPT_FOLLOWLOCATION => true, // Follow redirects
    CURLOPT_HTTPGET => true, // Use GET request method
]);

// Execute the cURL request
$response = curl_exec($curl);

// Check for errors
if(curl_error($curl)) {
    // If there's an error, create an error response
    $errorResponse = [
        'error' => 'Failed to fetch image response: ' . curl_error($curl)
    ];
    echo json_encode($errorResponse);
} else {
    // Decode the JSON response
    $responseData = json_decode($response, true);
    
    // Check if the response contains the image URL
    if (isset($responseData['url'])) {
        // If an image URL is found, echo the URL
        $imageUrl = $responseData['url'];
        echo $imageUrl;
    } else {
        // If no image URL is found, return an error response
        $errorResponse = [
            'error' => 'No image URL found in the response'
        ];
        echo json_encode($errorResponse);
    }
}

// Close cURL session
curl_close($curl);
?>
