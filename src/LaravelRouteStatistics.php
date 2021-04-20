<?php

namespace Bilfeldt\LaravelRouteStatistics;

class LaravelRouteStatistics
{
    protected $enable = false;

    protected $attributes = [];

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->enable;
    }

    /**
     * @return self
     */
    public function enable(): self
    {
        $this->setEnable(true);

        return $this;
    }

    /**
     * @return self
     */
    public function disable(): self
    {
        $this->setEnable(false);

        return $this;
    }

    /**
     * @param  bool  $enable
     * @return self
     */
    public function setEnable(bool $enable): self
    {
        $this->enable = $enable;

        return $this;
    }

    /**
     * @param  array  $attributes
     * @return self
     */
    public function setAttributes(array $attributes): self
    {
        $this->attributes = $attributes;

        return $this;
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @param  array  $attributes
     * @return self
     */
    public function mergeAttributes(array $attributes): self
    {
        $this->attributes = array_merge($this->attributes, $attributes);

        return $this;
    }
}
