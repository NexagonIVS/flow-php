<?php

namespace Flow;

use Flow\Service\OrderService;
use PHPUnit\Framework\TestCase;

class OrderServiceTest extends FlowClientTestCase
{
    public function testShouldCreateOrder(): void
    {
        $this->addResponse(204, [
            "id" => 1,
            "status" => 1,
            "customer_group" => 1,
        ]);

        $data = $this->client->orders->create(["customer_group" => 1]);
        $this->assertIsObject($data);
        $this->assertObjectHasAttribute("id", $data);
        $this->assertEquals(1, $data->id);
    }
}
