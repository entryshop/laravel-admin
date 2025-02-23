<?php

namespace Entryshop\Admin\Http\Controllers;

use Entryshop\Admin\Components\Layout;
use Entryshop\Admin\Concerns\CanCallMethods;
use Entryshop\Admin\Concerns\HasVariables;
use Entryshop\Admin\Http\Controllers\Traits\HasForm;
use Entryshop\Admin\Http\Controllers\Traits\HasIndex;
use Entryshop\Admin\Http\Controllers\Traits\HasShow;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Str;

class AdminController
{
    use CanCallMethods;
    use HasVariables;
    use HasIndex, HasShow, HasForm;

    /**
     * @var string|Model|Builder
     */
    public $model;
    public $route;
    public $lang;

    protected $layout;

    public function __construct()
    {
        $this->callMethods('setup');
    }

    protected function getModelClass()
    {
        return $this->model ?? 'App\\Models\\' . $this->guessModelClass();
    }

    protected function guessModelClass()
    {
        $class = class_basename($this);
        return Str::replace('Controller', '', $class);
    }

    protected function model($id = null)
    {
        $model_class = $this->getModelClass();

        if (empty($id)) {
            return new $model_class;
        }

        return $this->getModelClass()::find($id);
    }

    protected function models()
    {
        if (is_string($this->getModelClass())) {
            return $this->getModelClass()::query();
        }

        return $this->model;
    }

    protected function getRoute()
    {
        return $this->route ?? Str::lower(Str::plural($this->guessModelClass()));
    }

    protected function getLabel()
    {
        $label = $this->getLang('label');

        if (!Str::is($label, 'label', true)) {
            return $label;
        }

        return Str::title(class_basename($this->getModelClass()));
    }

    protected function getLabelPlural()
    {
        $label = $this->getLang('label_plural');
        if (!Str::is($label, 'label_plural', true)) {
            return $label;
        }
        return Str::plural($this->getLabel());
    }

    protected function getLang($name)
    {
        if (empty($this->lang)) {
            $this->lang = Str::lower($this->guessModelClass());
        }

        $lang_key = $this->lang . '.' . $name;
        if (Lang::has($lang_key)) {
            return __($lang_key);
        }

        return Str::ucfirst($name);
    }

    /**
     * @return Layout
     */
    protected function layout()
    {
        return admin()->layout();
    }
}
