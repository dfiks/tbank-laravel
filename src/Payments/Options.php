<?php

namespace DFiks\TBank\Payments;

use DFiks\TBank\Payments\Contracts\ApiOptions;
use DFiks\TBank\Payments\Contracts\OptionHandlers;
use ReflectionClass;

class Options implements ApiOptions
{
    public ?OptionHandlers $handler = null;

    public function toArray(): array
    {
        return $this->handler->run();
    }

    public function attachHandler(OptionHandlers $optionHandlers): static
    {
        if (!$this->handler) {
            $data = $this->getProperties();
            unset($data['handler']);
            $this->handler = $optionHandlers->attachData($data);
        }

        return $this;
    }

    /**
     * Получить все свойства (включая приватные) с помощью рефлексии.
     *
     * @return array
     */
    private function getProperties(): array
    {
        $reflection = new ReflectionClass($this);
        $properties = [];

        foreach ($reflection->getProperties() as $property) {
            $properties[$property->getName()] = $property->getValue($this);
        }

        return $properties;
    }
}
