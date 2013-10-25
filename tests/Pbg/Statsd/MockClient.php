<?php

namespace Pbg\Statsd;

class MockClient extends Client
{
    public function send($m)
    {
        return $m;
    }
}
