<?php
namespace Src\Utility;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
/**
 * Helper class for making API requests using GuzzleHttp.
 */
class ApiHelper {
    /**
     * The HTTP client instance.
     * @var Client
     */
    private $client;
    /**
     * Custom headers for the HTTP request.
     * @var array
     */
    private $headers;

    /**
     * Constructor.
     * @param string $baseUri Base URI for the HTTP client.
     */
    public function __construct($baseUri = '') {
        $this->client = new Client(['base_uri' => $baseUri]);
        $this->headers = [];
    }

    /**
     * Sets the authentication for the API request.
     * @param string $type Type of authentication (basic, oauth, bearer).
     * @param mixed $credentials Credentials for authentication.
     */
    public function setAuth($type, $credentials) {
        $config = [
            'base_uri' => $this->client->getConfig('base_uri'),
            // Add other default configurations as needed
        ];
    
        switch ($type) {
            case 'basic':
                $config['auth'] = $credentials; // credentials is an array ['username', 'password']
                break;
    
            case 'oauth':
                // Assuming OAuth 2.0
                $config['headers'] = [
                    'Authorization' => 'OAuth ' . $credentials, // credentials is the OAuth token
                ];
                break;
    
            case 'bearer':
                $config['headers'] = [
                    'Authorization' => 'Bearer ' . $credentials, // credentials is the bearer token
                ];
                break;
        }
    
        $this->client = new Client($config);
    }
    /**
     * Sets a header for the API request.
     * @param string $key Header name.
     * @param string $value Header value.
     */

    public function setHeader($key, $value) {
        $this->headers[$key] = $value;
    }

    /**
     * Sends a GET request to the specified URI.
     * @param string $uri URI to send the request to.
     * @param array $query Query parameters for the request.
     * @return ResponseInterface
     */

    public function get($uri, $query = []) {
        try {
            return $this->client->request('GET', $uri, [
                'headers' => $this->headers,
                'query' => $query
            ]);
        } catch (GuzzleException $e) {
            // Handle exception or rethrow it
            throw $e;
        }
    }
    
    /**
     * Sends a POST request to the specified URI.
     * @param string $uri URI to send the request to.
     * @param array $data Data to send in the request body.
     * @return ResponseInterface
     */
    public function post($uri, $data = []) {
        try {
            return $this->client->request('POST', $uri, [
                'headers' => $this->headers,
                'form_params' => $data
            ]);
        } catch (GuzzleException $e) {
            // Handle exception or rethrow it
            throw $e;
        }
    }
    /**
     * Sends a PUT request to the specified URI.
     * @param string $uri URI to send the request to.
     * @param array $data Data to send in the request body.
     * @return ResponseInterface
     */
    public function put($uri, $data = []) {
        try {
            return $this->client->request('PUT', $uri, [
                'headers' => $this->headers,
                'json' => $data // Assuming JSON payload. Use 'form_params' for form data.
            ]);
        } catch (GuzzleException $e) {
            // Handle exception or rethrow it
            throw $e;
        }
    }
    /**
     * Sends a PATCH request to the specified URI.
     * @param string $uri URI to send the request to.
     * @param array $data Data to send in the request body.
     * @return ResponseInterface
     */
    public function patch($uri, $data = []) {
        try {
            return $this->client->request('PATCH', $uri, [
                'headers' => $this->headers,
                'json' => $data // Assuming JSON payload. Use 'form_params' for form data.
            ]);
        } catch (GuzzleException $e) {
            // Handle exception or rethrow it
            throw $e;
        }
    }
    /**
     * Sends a DELETE request to the specified URI.
     * @param string $uri URI to send the request to.
     * @return ResponseInterface
     */
    public function delete($uri) {
        try {
            return $this->client->request('DELETE', $uri, [
                'headers' => $this->headers
            ]);
        } catch (GuzzleException $e) {
            // Handle exception or rethrow it
            throw $e;
        }
    }
    /**
     * Checks if a string is a valid JSON format.
     * @param string $string The string to check.
     * @return bool Returns true if the string is valid JSON, false otherwise.
     */
    public function isJson($string) {
        json_decode($string);
        return json_last_error() == JSON_ERROR_NONE;
    }
    /**
     * Validates the response object.
     * @param ResponseInterface $response The response to validate.
     * @return bool Returns true if the response is valid, false otherwise.
     */
    public function isValidResponse($response) {
        // Implement your own logic to validate the response
        // For example, checking HTTP status code, response format, etc.
        return $response->getStatusCode() == 200;
    }
    /**
     * Parses the JSON response body and returns the data.
     *
     * @param ResponseInterface $response
     * @return mixed
     */
    public function parseJsonResponse(ResponseInterface $response) {
        $body = (string) $response->getBody();
        return json_decode($body, true); // Returns an array
    }

    /**
     * Checks if the response status code is successful (200-299).
     *
     * @param ResponseInterface $response
     * @return bool
     */
    public function isSuccess(ResponseInterface $response) {
        return $response->getStatusCode() >= 200 && $response->getStatusCode() < 300;
    }

    /**
     * Logs a message to a log file.
     *
     * @param string $message
     */
    public function log($message) {
        // Path to log file
        $logFile = __DIR__ . '/api.log';
        file_put_contents($logFile, date('Y-m-d H:i:s') . ' - ' . $message . PHP_EOL, FILE_APPEND);
    }
}
/* $apiHelper = new ApiHelper('https://jsonplaceholder.typicode.com');
$response = $apiHelper->get('/todos/1'); // Assuming the endpoint is /api/data

// Check if the response is successful
if ($apiHelper->isSuccess($response)) {
    // Parse JSON response
    $data = $apiHelper->parseJsonResponse($response);
    print_r($data);
} */