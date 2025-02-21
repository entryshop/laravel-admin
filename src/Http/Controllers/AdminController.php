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
    public $index_actions = [
        'view'   => true,
        'edit'   => true,
        'delete' => true,
    ];

    protected $layout;

    public function __construct()
    {
        $this->callMethods('setup');
    }

    protected function model($id = null)
    {
        if (empty($id)) {
            return new $this->model;
        }

        return $this->model::find($id);
    }

    protected function getRoute()
    {
        if (!empty($this->route)) {
            return $this->route;
        }

        if (!empty($this->model)) {
            return Str::lower(Str::plural(class_basename($this->model)));
        }

        return '';
    }

    protected function models()
    {
        if (is_string($this->model)) {
            return $this->model::query();
        }

        return $this->model;
    }

    protected function getLabel()
    {
        // get label from lang
        $label = $this->getLang('label');

        if (!Str::is($label, 'label', true)) {
            return $label;
        }

        // guess label from model
        if (is_string($this->model)) {
            return Str::title(class_basename($this->model));
        }
        return '';
    }

    protected function getLabelPlural()
    {
        // get label from lang
        $label = $this->getLang('label_plural');
        if (!Str::is($label, 'label_plural', true)) {
            return $label;
        }

        return Str::plural($this->getLabel());
    }

    public function destroy($id)
    {
        $model = $this->model::find($id);
        $model->delete();
        if (request()->ajax()) {
            return admin()->response([
                'success' => true,
                'action'  => 'reload',
            ]);
        }
        return back();
    }

    protected function getLang($name)
    {
        if (empty($this->lang)) {
            $this->lang = Str::lower(Str::plural(class_basename($this->model)));
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
