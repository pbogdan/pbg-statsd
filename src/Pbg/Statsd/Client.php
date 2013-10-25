<?php

namespace Pbg\Statsd;

class Client
{
    protected $client = null;

    public function __construct()
    {
        $c = new \Pbg\Socket\Client();
        $c->setProtoFamily(AF_INET)
            ->setSocketType(SOCK_DGRAM)
            ->setSocketProtocol(SOL_UDP)
            ->setHost("127.0.0.1")
            ->setPort(8125)
            ->connect();

        $this->client = $c;
    }

    public function setClient($client)
    {
        $this->client = $client;
    }

    public function gauge($name, $value)
    {
        $m = sprintf("%s:%d|g", $name, $value);;
        return $this->send($m);
    }

    public function counter($name, $value)
    {
        $m = sprintf("%s:%d|c", $name, $value);
        return $this->send($m);
    }

    public function inc($name, $value = 1)
    {
        return $this->counter($name, $value);
    }

    public function dec($name, $value = 1)
    {
        return $this->counter($name, -1 * $value);
    }

    public function timer($name, $value)
    {
        $m = sprintf("%s:%d|ms", $name, $value);
        return $this->send($m);
    }

    public function histo($name, $value)
    {
        $m = sprintf("%s:%d|h", $name, $value);
        return $this->send($m);
    }

    public function meter($name, $value)
    {
        $m = sprintf("%s:%d|m", $name, $value);
        return $this->send($m);
    }

    public function send($m)
    {
        $this->client->send($m);
        return $this;
    }
}
