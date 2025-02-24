<?php

namespace Entryshop\Admin\Concerns;

trait HasToasts
{
    const TOAST_TYPE_PRIMARY   = 'primary';
    const TOAST_TYPE_INFO      = 'info';
    const TOAST_TYPE_SUCCESS   = 'success';
    const TOAST_TYPE_DANGER    = 'danger';
    const TOAST_TYPE_SECONDARY = 'secondary';
    const TOAST_TYPE_WARNING   = 'warning';
    const TOAST_TYPE_DARK      = 'dark';
    const TOAST_TYPE_LIGHT     = 'light';

    public function alert($message, $type = 'info', $closeable = true, $icon = null)
    {
        session()->flash('__alert', [
            'message'   => $message,
            'type'      => $type,
            'closeable' => $closeable,
            'icon'      => $icon,
        ]);

        return $this;
    }

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

        return $this;
    }
}
