<?php
require_once __DIR__ . '/vendor/autoload.php';

use Gemini\Client;
use GeminiAPI\Resources\ModelName;
use GuzzleHttp\Client as GuzzleClient;
use Gemini\Transporter\GuzzleTransporter;

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('users/includes/config.php');

// Redirect if user is not logged in
if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    try {
        // Initialize variables
        $uid = $_SESSION['id'];
        $category = $_POST['category'] ?? '';
        $subcat = $_POST['subcategory'] ?? '';
        $complaintype = $_POST['complaintype'] ?? '';
        $tolename = $_POST['tolename'] ?? '';
        $complaintdetails = $_POST['complaindetails'] ?? '';
        $compfile = $_FILES['compfile']['name'] ?? '';

        // Validate inputs
        if (empty($category) || empty($subcat) || empty($complaintype) || empty($tolename) || empty($complaintdetails)) {
            throw new Exception("All fields are required.");
        }

        // Handle file upload
        if (!empty($compfile)) {
            $uploadPath = "complaintdocs/" . basename($compfile);
            if (!move_uploaded_file($_FILES['compfile']['tmp_name'], $uploadPath)) {
                throw new Exception("Failed to upload file.");
            }
        }

        // Insert complaint into database
        $query = "INSERT INTO tblcomplaints(userId, category, subcategory, complaintType, toleName, complaintDetails, complaintFile) 
                  VALUES ('$uid', '$category', '$subcat', '$complaintype', '$tolename', '$complaintdetails', '$compfile')";
        if (!mysqli_query($bd, $query)) {
            throw new Exception("Database insertion failed: " . mysqli_error($bd));
        }

        // Create a Guzzle client and configure it with your API key
        $httpClient = new GuzzleClient([
            'base_uri' => 'https://api.gemini.com', // Base API URL
            'headers' => [
                'Authorization' => 'Bearer AIzaSyD2nRsPOSX3hgSqzl98x8xQYojwZj5vIUA',
                'Content-Type' => 'application/json',
            ],
        ]);

        // Use the GuzzleTransporter (if it exists in the SDK)
        $transporter = new GuzzleTransporter($httpClient);

        // Initialize the Gemini Client
        $client = new Client($transporter);

        // Define hotlines based on category
        $hotlines = [
            'Electricity' => [
                'Transmitter burst' => 'Electricity Hotline: 1800-123-456',
                'Cut-off wire' => 'Electricity Hotline: 1800-123-456',
                'Pole fall' => 'Electricity Hotline: 1800-123-456',
                'Half-cut electricity' => 'Electricity Hotline: 1800-123-456',
            ],
            'Water' => [
                'Dirty water' => 'Water Hotline: 1800-654-321',
                'No schedule time water' => 'Water Hotline: 1800-654-321',
                'Pipe burst' => 'Water Hotline: 1800-654-321',
            ],
            'Garbage' => [
                'No schedule time' => 'Garbage Hotline: 1800-789-012',
                'Overload garbage' => 'Garbage Hotline: 1800-789-012',
            ],
        ];

        $hotline = $hotlines[$category][$subcat] ?? 'General Emergency: 101';

        // Use the API client to send the complaint data to the LLM model
        $response = $client->generativeModel(ModelName::GEMINI_PRO)->generateContent(
            "The user submitted a complaint under the category '$category' and subcategory '$subcategory'. 
Complaint: '$complaintdetails'. Please provide any additional insights."
        );

        // Get the response from the LLM
        $llm_response = $response->text();

        echo "Complaint: " . htmlspecialchars($complaintdetails) . "<br>";
        echo "Category: " . htmlspecialchars($category) . "<br>";
        echo "Subcategory: " . htmlspecialchars($subcat) . "<br>";
        echo "Hotline: " . htmlspecialchars($hotline) . "<br>";
        echo "LLM Response: " . htmlspecialchars($llm_response) . "<br>";
    } catch (Exception $e) {
        // Handle errors gracefully
        echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
    }
}
