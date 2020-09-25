<?php declare(strict_types=1);

namespace Flow;

use Flow\Service\ProductService;
use GuzzleHttp\Psr7\Response;
use Nexagon\Model;
use PHPUnit\Framework\TestCase;

class FlowClientTestCase extends TestCase
{
    protected $client;
    private $mock;
    public function setUp(): void
    {
        $this->mock = new \GuzzleHttp\Handler\MockHandler();
        $this->client = new FlowClient('Fz6lVs1m.mU4z8kK9LMgY6iS2ejslQfdYcfdBQv11', 'http://localhost:8000/');
    }

    protected function addResponse($code = 200, $data = [])
    {
        $this->mock->append(new Response($code, ['Content-Type' => 'application/json'], json_encode($data)));
    }
}

final class FlowClientTest extends FlowClientTestCase
{
    public function testHasFlowClient(): void
    {
        $this->assertNotNull($this->client);
    }

    public function testHasProducts(): void
    {
        $this->assertEquals(ProductService::class, get_class($this->client->products));
    }

    public function testCanMakeRequests(): void
    {
        $this->addResponse(200);
        $headers = $this->client->headApi('/');
        $this->assertTrue(sizeof($headers) > 0);
    }
}
