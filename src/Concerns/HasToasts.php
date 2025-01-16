<?php

namespace Entryshop\Admin\Concerns;

trait HasToasts
{
    public function success($message)
    {
        $this->toast($message, 'success');
    }

    public function error($message)
    {
        $this->toast($message, 'danger');
    }

    public function warning($message)
    {
        $this->toast($message, 'warning');
    }

    public function toast($message, $type = 'info')
    {
        session()->flash('__toast', [
            'text'      => $message,
            'close'     => 'close',
            'className' => $type,
        ]);
    }
}
