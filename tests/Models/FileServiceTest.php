<?php

namespace Flow;

class FileServiceTest extends FlowClientTestCase
{

    public function testShouldCreateAndUploadThenAddVersionAndThenDelete()
    {
        $stream = fopen(__DIR__ . "/favicon.png", "r");
        $mimetype = mime_content_type(__DIR__ . "/favicon.png");
        $this->assertIsResource($stream);
        [$file,] = $this->client->files->createAndUpload($stream, "favicon.png", $mimetype);
        $this->assertEquals("favicon.png", $file->name);
        $this->assertEquals($mimetype, $file->mimetype);
        $this->assertGreaterThan(0, $file->size);

        $this->assertEquals(1, sizeof($file->versions));

        // Add file version
        [$file, ] = $this->client->files->addFileVersion($file->id, fopen(__DIR__ . "/favicon.png", "r"), "favicon2.png", $mimetype);
        $this->assertEquals("favicon2.png", $file->name);
        $this->assertEquals($mimetype, $file->mimetype);
        $this->assertGreaterThan(0, $file->size);
        $this->assertEquals(2, sizeof($file->versions));


        // Delete file
        [, $response] = $this->client->files->delete($file->id);
        $this->assertEquals(204, $response->getStatusCode());

        $this->expectExceptionCode(404);
        $this->client->files->retrieve($file->id);
    }
}
