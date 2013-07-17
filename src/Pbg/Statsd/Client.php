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
        $c->send("lol|@1234");

        $this->client = $c;
    }

    public function setClient($client)
    {
        $this->client = $client;
        return $this;
    }

    public function gauge($name, $value)
    {
        // <metric name>:<value>|g
        $m = sprintf("%s:%d|g", $name, $value);;
        $this->client->send($m);
    }

    public function counter($name, $value, $sampleRate = null)
    {
        // <metric name>:<value>|c[|@<sample rate>]
        $m = sprintf("%s:%d|c", $name, $value);

        if ($sampleRate !== null) {
            $m .= sprintf("|@%d", $sampleRate);
        }

        $this->client->send($m);
    }

    public function timer($name, $value)
    {
        // <metric name>:<value>|ms
        $m = sprintf("%s:%d|ms", $name, $value);
        $this->client->send($m);
    }

    public function histo($name, $value)
    {
        // <metric name>:<value>|h
        $m = sprintf("%s:%d|h", $name, $value);
        $this->client->send($m);
    }

    public function meter($name, $value)
    {
        // <metric name>:<value>|m
        $m = sprintf("%s:%d|m", $name, $value);
        $this->client->send($m);
    }
}
