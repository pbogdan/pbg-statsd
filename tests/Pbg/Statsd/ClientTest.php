<?php

namespace Pbg\Statsd;

require_once "MockClient.php";

class ClientTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $c = new MockClient();
        $this->client = $c;
    }

    public function testGauge()
    {
        $this->assertEquals(
            $this->client->gauge("test", 1),
            "test:1|g"
        );
    }

    public function testCounter()
    {
        $this->assertEquals(
            $this->client->counter("test", 1),
            "test:1|c"
        );
    }

    public function testInc()
    {
        $this->assertEquals(
            $this->client->inc("test", 1),
            "test:1|c"
        );
    }

    public function testDec()
    {
        $this->assertEquals(
            $this->client->dec("test", 1),
            "test:-1|c"
        );
    }

    public function testTimer()
    {
        $this->assertEquals(
            $this->client->timer("test", 1),
            "test:1|ms"
        );
    }

    public function testHisto()
    {
        $this->assertEquals(
            $this->client->histo("test", 1),
            "test:1|h"
        );
    }

    public function testMeter()
    {
        $this->assertEquals(
            $this->client->meter("test", 1),
            "test:1|m"
        );
    }

}
