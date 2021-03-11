<?php

namespace Eset\Api\Models;

class Credentials
{
    /**
     * GUID for eset API.
     *
     * @var string
     */
    public $esetGuid;

    /**
     * KEY for eset API.
     *
     * @var string
     */
    public $esetKey;

    /**
     * @return string
     */
    public function getEsetGuid(): string
    {
        return $this->esetGuid;
    }

    /**
     * @param string $esetGuid
     */
    public function setEsetGuid(string $esetGuid): void
    {
        $this->esetGuid = $esetGuid;
    }

    /**
     * @return string
     */
    public function getEsetKey(): string
    {
        return $this->esetKey;
    }

    /**
     * @param string $esetKey
     */
    public function setEsetKey(string $esetKey): void
    {
        $this->esetKey = $esetKey;
    }

    public function __construct($esetGuid, $esetKey)
    {
        $this->esetGuid = $esetGuid;
        $this->esetKey = $esetKey;
    }


}