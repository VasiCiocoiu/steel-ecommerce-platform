<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AnalyticsControllerTest extends WebTestCase
{
    public function testCount404()
    {
        // Create a client to make requests
        $client = static::createClient();

        try {
            // Send the GET request to count all the entries with status 404
            $client->request('GET', '/count404');

            // Assert that the response is successful
            $this->assertResponseIsSuccessful();

            // Add assertion for the response content
            $responseContent = $client->getResponse()->getContent();
            $this->assertJson($responseContent);
        } catch (\Exception $e) {
            $this->fail('An unexpected exception was thrown: ' . $e->getMessage());
        }
    }
    public function testCreateEntry()
    {
        // Create a client to make requests
        $client = static::createClient();

        // JSON data to send in the request
        $data = [
            'userIpAddress' => '127.0.0.1',
            'accessDate' => '20-02-2024',
            'accessTime' => '12:00:00',
            'status' => '200',
            'url' => 'http://example.com',
            'userAgent' => 'Mozilla/5.0'
        ];

        try {
            // Send the POST request with JSON payload
            $client->request(
                'POST',
                '/create_entry',
                [],
                [],
                ['CONTENT_TYPE' => 'application/json'],
                json_encode($data)
            );

            // Assert that the response is successful
            $this->assertResponseIsSuccessful();

            // Add assertion for the response content
            $responseContent = $client->getResponse()->getContent();
            $this->assertStringContainsString('id', $responseContent);
        } catch (\Exception $e) {
            $this->fail('An unexpected exception was thrown: ' . $e->getMessage());
        }
    }
    public function testShow()
    {
        $client = static::createClient();

        try {
            $client->request('GET', '/get/analytics/66925937b42b39a8570646b6');

            // Assert that the response is successful
            $this->assertResponseIsSuccessful();

            // Add assertion for the response content
            $responseContent = $client->getResponse()->getContent();
            $this->assertJson($responseContent);
        } catch (\Exception $e) {
            $this->fail('An unexpected exception was thrown: ' . $e->getMessage());
        }
    }

    public function testListUrl()
    {
        // Create a client to make requests
        $client = static::createClient();

        try {
            // Send the GET request to list all URLs
            $client->request('GET', '/listUrl');

            // Assert that the response is successful
            $this->assertResponseIsSuccessful();

            // Add assertion for the response content
            $responseContent = $client->getResponse()->getContent();
            $this->assertJson($responseContent);
        } catch (\Exception $e) {
            $this->fail('An unexpected exception was thrown: ' . $e->getMessage());
        }
    }

    public function testCountUrl()
    {
        // Create a client to make requests
        $client = static::createClient();

        try {
            // Send the GET request to count the number of times a URL has been accessed
            $client->request('GET', '/countUrlAccess/{url}', ['url' => 'http://example.com']);

            // Assert that the response is successful
            $this->assertResponseIsSuccessful();

            // Add assertion for the response content
            $responseContent = $client->getResponse()->getContent();
            $this->assertJson($responseContent);
        } catch (\Exception $e) {
            $this->fail('An unexpected exception was thrown: ' . $e->getMessage());
        }
    }



    public function testListUrlAccess()
    {
        // Create a client to make requests
        $client = static::createClient();

        try {
            // Send the GET request to list all the IDs of the entries for a given URL
            $client->request('GET', '/listIpForUrl/{url}', ['url' => '/test1']);

            // Assert that the response is successful
            $this->assertResponseIsSuccessful();

            // Add assertion for the response content
            $responseContent = $client->getResponse()->getContent();
            $this->assertJson($responseContent);
        } catch (\Exception $e) {
            $this->fail('An unexpected exception was thrown: ' . $e->getMessage());
        }
    }



    public function testListByStatus()
    {
        // Create a client to make requests
        $client = static::createClient();

        try {
            // Send the GET request to list all the entries with a specific status
            $client->request('GET', '/listByStatus/{status}', ['status' => '200']);

            // Assert that the response is successful
            $this->assertResponseIsSuccessful();

            // Add assertion for the response content
            $responseContent = $client->getResponse()->getContent();
            $this->assertJson($responseContent);
        } catch (\Exception $e) {
            $this->fail('An unexpected exception was thrown: ' . $e->getMessage());
        }
    }

    public function testCountHour()
    {
        // Create a client to make requests
        $client = static::createClient();

        try {
            // Send the GET request to count the number of entries for a specific hour
            $client->request('GET', '/countHour/{hour}', ['hour' => '12']);

            // Assert that the response is successful
            $this->assertResponseIsSuccessful();

            // Add assertion for the response content
            $responseContent = $client->getResponse()->getContent();
            $this->assertJson($responseContent);
        } catch (\Exception $e) {
            $this->fail('An unexpected exception was thrown: ' . $e->getMessage());
        }
    }

    public function testCountDate()
    {
        // Create a client to make requests
        $client = static::createClient();

        try {
            // Send the GET request to count the number of entries for a specific date
            $client->request('GET', '/countDate/{day}-{month}-{year}', ['day' => '01', 'month' => '10', 'year' => '2024']);

            // Assert that the response is successful
            $this->assertResponseIsSuccessful();

            // Add assertion for the response content
            $responseContent = $client->getResponse()->getContent();
            $this->assertJson($responseContent);
        } catch (\Exception $e) {
            $this->fail('An unexpected exception was thrown: ' . $e->getMessage());
        }
    }

    // public function testDelete()
    // {
    //     // Create a client to make requests
    //     $client = static::createClient();

    //     try {
    //         // Send the DELETE request to delete an entry based on ID
    //         $client->request('DELETE', '/delete/analytics/66925937b42b39a8570646b6');

    //         // Assert that the response is successful
    //         $this->assertResponseIsSuccessful();

    //         // Add assertion for the response content
    //         $responseContent = $client->getResponse()->getContent();
    //         $this->assertEquals('Access deleted successfully', $responseContent);
    //     } catch (\Exception $e) {
    //         $this->fail('An unexpected exception was thrown: ' . $e->getMessage());
    //     }
    // }
}
