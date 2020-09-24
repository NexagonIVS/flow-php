<?php


namespace Flow\Service;


class OrderService extends AbstractService
{
    /**
     * @param string|int $id        the id of the order to get
     * @return object               an order as an object
     * @throws \Flow\FlowException
     */
    public function retrieve($id)
    {
        return $this->get('/orders/' . $id);
    }

    /**
     * @param string|int $id        the id of the order to update
     * @param array $data           the data to update with
     * @return object               some data - not necessarily a product
     * @throws \Flow\FlowException
     */
    public function update($id, $data)
    {
        return $this->patch('/orders/' . $id, [], $data);
    }

    /**
     * @param object|array<string, mixed> $data the data to create an order from
     * @return mixed                            a newly created order
     * @throws \Flow\FlowException
     */
    public function create($data)
    {
        return $this->post('/orders', [], $data);
    }
}