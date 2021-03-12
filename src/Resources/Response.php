<?php


namespace Eset\Api\Resources;


class Response
{
    /**
     * Messages returned by Eset API
     *
     * @var array
     */
    private array $data;

    /**
     * Result of the request to Eset API
     *
     * @var bool
     */
    private bool $result;

    /**
     * Messages returned by Eset API
     *
     * @var array
     */
    private array $messages;



    /**
     * @return bool
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param bool $result
     */
    public function setResult($result)
    {
        $this->result = $result;
    }

    /**
     * @return array
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * @param array $messages
     */
    public function setMessages($messages)
    {
        $this->messages = $messages;
    }


    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData(array $data): void
    {
        $this->data = $data;
    }

    /**
     * @param array $object
     */
    public function __construct(array $object)
    {
        $this->result = $object['Result'];
        $this->messages = $object['Messages'];

        $data = $object;
        unset($data['Result'], $data['Messages']);
        $this->data = $data;
    }


}