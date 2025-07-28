<?php

namespace FOS\MessageBundle\FormModel;

abstract class AbstractMessage
{
    protected string $body;

    public function getBody(): string
    {
        return $this->body;
    }

    public function setBody(string $body): void
    {
        $this->body = $body;
    }
}
