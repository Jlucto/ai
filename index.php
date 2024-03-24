<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChatBot ni Lucto</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Font Awesome for icons -->
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .chat-container {
            width: 700px;
            background-color: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
        }

        .message-container {
            height: 550px;
            overflow-y: auto;
            padding: 15px;
        }

        .message {
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 8px;
        }

        .user-message {
            background-color: #007bff;
            color: #fff;
            align-self: flex-end;
        }

        .bot-message {
            background-color: #f2f2f2;
            color: #333;
        }

        .message p {
            margin: 0;
            font-size: 16px;
            line-height: 1.4;
        }

        #questionForm {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            background-color: #f9f9f9;
            border-top: 1px solid #ccc;
        }

        #question {
            flex: 1;
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
        }

        #submit-btn {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        #submit-btn:hover {
            background-color: #0056b3;
        }

        .bot-message img {
            max-width: 100%; /* Ensure the image does not exceed its container width */
            height: auto; /* Maintain aspect ratio */
            display: block; /* Prevent inline image alignment issues */
            margin: 0 auto; /* Center the image horizontally */
            margin-top: 10px; /* Add some space above the image */
        }

        .bot-message .small-img {
            max-width: 300px; /* Define maximum width for small images */
            height: auto; /* Maintain aspect ratio */
        }
    </style>
</head>
<body>
    <div class="chat-container">
        <div class="message-container" id="response-container">
            <p class="bot-message message"> This Chatbot is Created by <br>
        Lucto Jericson <br> 
    *answer simple question <br>
*can generate image </p>
        </div> <!-- Response container -->
        <form id="questionForm">
            <input type="text" id="question" name="question" placeholder="Type your question...">
            <button type="submit" id="submit-btn"><i class="fas fa-paper-plane"></i></button>
        </form>
    </div>

    <script>
    document.getElementById("questionForm").addEventListener("submit", function(event) {
        event.preventDefault(); // Prevent default form submission
        var questionInput = document.getElementById("question");
        var submitButton = document.getElementById("submit-btn");
        questionInput.disabled = true; // Disable input field
        submitButton.disabled = true; // Disable submit button

        var question = questionInput.value;
        var userQuestion = document.createElement("div");
        userQuestion.classList.add("message", "user-message");
        userQuestion.innerHTML = `<p>You: ${question}</p>`;
        var responseContainer = document.getElementById("response-container");
        responseContainer.appendChild(userQuestion);

        // Scroll to the bottom of the message container after appending the user's question
        responseContainer.scrollTop = responseContainer.scrollHeight;
        
        // Check if the question contains the word "image"
        var isImageQuestion = question.toLowerCase().includes("image");

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4) {
                questionInput.disabled = false; // Re-enable input field
                submitButton.disabled = false; // Re-enable submit button
                if (this.status == 200) {
                    if (isImageQuestion && this.responseText) {
                        // If it's an image question and response is not empty
                        var botResponse = document.createElement("div");
                        botResponse.classList.add("message", "bot-message");
                        var smallImgElement = document.createElement("img");
                        smallImgElement.src = this.responseText;
                        smallImgElement.alt = "Small Image Response";
                        smallImgElement.classList.add("small-img"); // Apply small image class
                        botResponse.appendChild(smallImgElement);
                        responseContainer.appendChild(botResponse);
                    } else {
                        // If it's not an image question or no response is received
                        var botResponse = document.createElement("div");
                        botResponse.classList.add("message", "bot-message");
                        botResponse.innerText = `Bot: ${this.responseText || "No reply received."}`;
                        responseContainer.appendChild(botResponse);
                    }
                } else {
                    var errorMessage = document.createElement("div");
                    errorMessage.classList.add("message", "bot-message");
                    errorMessage.innerHTML = `<p>Bot: Error: ${this.status} - ${this.statusText}</p>`;
                    responseContainer.appendChild(errorMessage);
                }

                // Scroll to the bottom of the message container after receiving the response
                responseContainer.scrollTop = responseContainer.scrollHeight;
            }
        };
        // Modify the request URL based on whether it's an image question or not
        var requestUrl = isImageQuestion ? "image_proxy.php?question=" : "proxy.php?question=";
        xhttp.open("GET", requestUrl + encodeURIComponent(question), true);
        xhttp.send();
        questionInput.value = ''; // Clear input field
    });
</script>


</body>
</html>
