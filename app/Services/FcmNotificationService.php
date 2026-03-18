<?php
namespace App\Services;
use Google\Auth\Credentials\ServiceAccountCredentials;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class FcmNotificationService
{
    protected $serviceAccountPath;
    protected $projectId;

    public function __construct()
    {
        // Path to your Firebase Service Account JSON file
        $this->serviceAccountPath = storage_path('/app/json/fcm-file.json');

        // Grab the Project ID from the JSON file automatically
        $config = json_decode(file_get_contents($this->serviceAccountPath), true);
        $this->projectId = $config['project_id'];
    }

    /**
     * Get OAuth2 Access Token
     */
    private function getAccessToken()
    {
        $scopes = ['https://www.googleapis.com/auth/firebase.messaging'];
        $credentials = new ServiceAccountCredentials($scopes, $this->serviceAccountPath);
        $token = $credentials->fetchAuthToken();

        return $token['access_token'];
    }

    /**
     * Send Push Notification
     */
    public function send($deviceToken, $title, $body, $data = [])
    {
        $url = "https://fcm.googleapis.com/v1/projects/{$this->projectId}/messages:send";
        $accessToken = $this->getAccessToken();

        $client = new Client();

        $payload = [
            'message' => [
                'token' => $deviceToken,
                'notification' => [
                    'title' => $title,
                    'body' => $body,
                ],
                'data' => $data, // Optional: items must be strings
            ],
        ];

        try {
            $response = $client->post($url, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Content-Type'  => 'application/json',
                ],
                'json' => $payload,
            ]);

            return json_decode($response->getBody(), true);
        } catch (GuzzleException $e) {
            // This will catch your 401 errors and provide details
            return [
                'status' => $e->getCode(),
                'response' => json_decode($e->getResponse()->getBody()->getContents(), true)
            ];
        }
    }
}
