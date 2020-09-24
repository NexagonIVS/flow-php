<?php

namespace Flow\Service;

class ProductService extends AbstractService
{
    /**
     * @param string|int $id    the id of the product to get
     * @return object           a product as an object
     * @throws \Flow\FlowException
     */
    public function retrieve($id)
    {
        return $this->get('/products/' . $id);
    }

    /**
     * @param string|int $id        the id of the product to update
     * @param array $data           the data to update with
     * @return object               some data - not necessarily a product
     * @throws \Flow\FlowException
     */
    public function update($id, $data = [])
    {
        return $this->patch('/products/' . $id, [], $data);
    }
}