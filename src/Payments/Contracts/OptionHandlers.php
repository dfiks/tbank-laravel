<?php

namespace DFiks\TBank\Payments\Contracts;

interface OptionHandlers
{
    public function run(): array;

    public function attachData(array $data): static;
}
