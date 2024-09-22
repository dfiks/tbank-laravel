<?php

namespace DFiks\TBank\Configuration\Contracts;

interface ConfigurationInterface
{
    public function get(): ConfigInterface;
}
