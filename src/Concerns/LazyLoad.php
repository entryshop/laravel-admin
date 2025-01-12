<?php

namespace Entryshop\Admin\Concerns;

/**
 * @method self|bool lazy($value = null)
 */
trait LazyLoad
{
    public function getDefaultLazy(): bool
    {
        return true;
    }

    public function payload($value = null): self|string|array|null
    {
        if (empty($value)) {
            return $this->get('payload');
        }

        if (is_array($value)) {
            return $this->set('payload', $value);
        }

        if (is_string($value)) {
            $payload = $this->get('payload');
            return $payload[$value] ?? null;
        }

        return $this;
    }
}
