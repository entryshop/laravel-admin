<?php

namespace Entryshop\Admin\Http\Controllers;

use Entryshop\Admin\Components\Cell;
use Entryshop\Admin\Components\Form;
use Entryshop\Admin\Components\Grid;
use Entryshop\Admin\Components\Layout;
use Entryshop\Admin\Concerns\CanCallMethods;
use Entryshop\Admin\Concerns\HasVariables;
use Entryshop\Admin\Http\Controllers\Traits\HasForm;
use Entryshop\Admin\Http\Controllers\Traits\HasIndex;
use Entryshop\Admin\Http\Controllers\Traits\HasShow;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Lang;

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

    /**
     * @param  string  $view  current controller handler index|show|edit|create
     * @return array
     */
    public function crud($view = null)
    {
        return [
            'id',
        ];
    }

    public function model($id = null)
    {
        if (empty($id)) {
            return new $this->model;
        }

        return $this->model::find($id);
    }

    public function models()
    {
        if (is_string($this->model)) {
            return $this->model::query();
        }

        return $this->model;
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

    protected function getColumn($column)
    {
        $column['label'] ??= $this->getLang($column['name']);

        /**
         * @var Cell $cellClass
         */
        $cellClass = Grid::$availableColumns[$column['type'] ?? 'text'];

        return $cellClass::make($column);
    }

    protected function getField($column)
    {
        $column['label'] ??= $this->getLang($column['name']);

        /**
         * @var Cell $cellClass
         */
        $cellClass = Form::$availableFields[$column['type'] ?? 'text'];

        return $cellClass::make($column);
    }

    protected function getLang($name)
    {
        if (!empty($this->lang)) {
            $lang_key = $this->lang . '.' . $name;
            if (Lang::has($lang_key)) {
                return __($lang_key);
            }
        }
        return $name;
    }

    /**
     * @return Layout
     */
    protected function layout()
    {
        return admin()->layout();
    }
}
