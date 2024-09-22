<?php

namespace DFiks\TBank\Payments\Contracts;

use Illuminate\Contracts\Support\Arrayable;

interface ApiOptions extends Arrayable
{
    public function attachHandler(OptionHandlers $optionHandlers): static;
}
