<?php declare(strict_types=1);

namespace Flow;

final class ProductsTest extends FlowClientTestCase
{
    public function testShouldGetProduct(): void
    {
        $this->addResponse(200, [
            "id" => 1,
            "name" => "Test product",
        ]);
        [$data, $response] = $this->client->products->retrieve(1);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertIsObject($data);
        $this->assertObjectHasAttribute("id", $data);
        $this->assertEquals(1, $data->id);
    }

    public function testShouldGetAllProducts(): void
    {
        $this->addResponse(200, [
            "id" => 28,
            "name" => "Test product",
        ]);
        [$data, $response] = $this->client->products->all();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertIsObject($data);
        $this->assertObjectHasAttribute("results", $data);
        $this->assertObjectHasAttribute("count", $data);
        $this->assertObjectHasAttribute("next", $data);
    }

    public function testShouldThrowOnNonExistingProduct(): void
    {
        $this->addResponse(404, "Could not get products/12: 404");
        $this->expectException(FlowException::class);
        $this->expectExceptionMessage("Could not get products/12: 404");
        $this->expectExceptionCode(404);
        $this->client->products->retrieve(12);
    }

    public function testShouldUpdateProduct(): void
    {
        $this->addResponse(200, ["id" => 1, "name" => "new name"]);
        [$data,] = $this->client->products->update(1, ["id" => 1, "name" => "new name"]);
        $this->assertIsObject($data);
        $this->assertEquals("new name", $data->name);
    }
}