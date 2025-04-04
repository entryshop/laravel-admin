<?php

namespace Entryshop\Admin\Concerns;

use Illuminate\Pagination\Paginator;

/**
 * @method self|string favicon($value = null)
 * @method self|string csp($value = null) csp nonce
 */
trait HasAssets
{
    public function bootHasAssets()
    {
        Paginator::useBootstrapFive();
    }

    public function js($value = null)
    {
        if (empty($value)) {
            return $this->get('js', []);
        }
        return $this->push('js', $value);
    }

    public function script($value = null)
    {
        if (empty($value)) {
            return $this->get('script', []);
        }
        return $this->push('script', $value);
    }

    public function css($value = null)
    {
        if (empty($value)) {
            return $this->get('css', []);
        }
        return $this->push('css', $value);
    }

    public function getDefaultJs()
    {
        return [
            $this->asset('js/layout.js'),
            $this->asset('libs/jquery/jquery-4.js'),
            $this->asset('libs/bootstrap/js/bootstrap.bundle.min.js'),
            $this->asset('libs/simplebar/simplebar.min.js'),
            $this->asset('libs/node-waves/waves.min.js'),
            $this->asset('libs/feather-icons/feather.min.js'),
            $this->asset('libs/flatpickr/flatpickr.min.js'),
            $this->asset('libs/toastify-js/src/toastify.js'),
            $this->asset('libs/choices.js@10.2.0/choices.min.js'),
            $this->asset('js/app.js'),
            $this->asset('js/admin.js'),
        ];
    }

    public function getDefaultCss()
    {
        return [
            $this->asset('css/bootstrap.min.css'),
            $this->asset('libs/tabler-icons-3.31.0/webfont/tabler-icons.min.css'),
            $this->asset('css/icons.min.css'),
            $this->asset('css/app.min.css'),
            $this->asset('css/custom.min.css'),
        ];
    }
}

