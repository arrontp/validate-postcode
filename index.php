<!DOCTYPE html>
<html>
<head>
    <title>UK Postcode Validation</title>
</head>
<body>
    <h2>UK Postcode Validation</h2>
    <form method="post" action="">
        <label for="postcode">Enter UK Postcode:</label>
        <input type="text" id="postcode" name="postcode" required>
        <button type="submit">Validate</button>
    </form>

    <?php

    // $postcode = 'ba214qh';
    // validateUKPostcode($postcode);

   // Function to validate and check the existence of a UK postcode
    function validateUKPostcode($postcode) {
        $postcode = str_replace(' ', '', strtoupper($postcode)); // Remove spaces and convert to uppercase
        $apiUrl = "https://api.postcodes.io/postcodes/{$postcode}";

        // Make the API request
        $curl = curl_init($apiUrl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if ($httpCode === 200) {
            $data = json_decode($response, true);
            if ($data && isset($data['result']) && !empty($data['result'])) {
                // Postcode exists
                return true;
            }
        }

        // Postcode does not exist or API error
        return false;
    }


    // Example usage:
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $inputPostcode = $_POST["postcode"];

        if (validateUKPostcode($inputPostcode)) {
            // echo "<p>Valid UK postcode and exists.</p>";
            header( "Location: https://app.actionfunder.org/explore/results?postcode={$postcode}" );
        } else {
            echo "<p>Invalid UK postcode or does not exist.</p>";
        }
    }
    ?>
</body>
</html>
