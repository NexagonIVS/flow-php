<?php


namespace Flow\Service;


use Psr\Http\Message\StreamInterface;

class FileService extends AbstractService
{
    use \Flow\ApiOperations\All;
    use \Flow\ApiOperations\Retrieve;
    use \Flow\ApiOperations\Create;
    use \Flow\ApiOperations\Update;
    use \Flow\ApiOperations\Delete;

    protected function getClassUrl(): string
    {
        return "files";
    }

    /**
     * @param StreamInterface|resource|string $stream   the file to upload as a stream
     * @param string $name              the file name
     * @param string $mimetype          the mimetype of the file
     * @return array                   the flow file resource and response object
     * @throws \Flow\FlowException
     */
    public function createAndUpload($stream, string $name, string $mimetype)
    {
        // 1. Create a new file and Get post URL (and config fields)
        [$fileResponseData,] = $this->create([
            "name" => $name,
        ]);
        // 2. Upload file stream as form data
        $this->uploadFile($fileResponseData, $stream, $mimetype);
        // 3. Refresh the file and return it.
        return $this->refresh($fileResponseData->id);
    }

    /**
     * @param string|integer $id        the files id
     * @param StreamInterface|resource|string $stream   the file to upload as a stream
     * @param string $name              the name of the file
     * @param string $mimetype          the file mimetype
     * @return array                    the refreshed flow file resource and an response
     * @throws \Flow\FlowException
     */
    public function addFileVersion($id, $stream, string $name, string $mimetype)
    {
        // 1. get the file to upload
        [$fileResponseData,] = $this->retrieve($id);
        // 2. upload the file stream (as a new version)
        $this->uploadFile($fileResponseData, $stream, $mimetype);
        // 3. refresh the file and return it.
        $this->update($id, [
            "name" => $name
        ]);
        $this->refresh($id);
        return $this->retrieve($id);
    }

    private function refresh($id)
    {
        return $this->post($this->getClassUrl() .  '/' . $id . '/refresh', [], null);
    }

    private function uploadFile($fileResponseData, $stream, $mimetype)
    {
        $this->getClient()->request('PUT', $fileResponseData->post_info->url, [
            "body" => $stream,
            "headers" => [
                "Content-Type" => $mimetype
            ],
        ]);
    }
}