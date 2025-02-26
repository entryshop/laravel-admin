<?php

namespace Entryshop\Admin\Components\Table\Columns;

use Entryshop\Admin\Components\Cell;
use Entryshop\Admin\Components\Widgets\Action;
use Entryshop\Admin\Concerns\HasChildren;

class Actions extends Cell
{
    use HasChildren;

    public $view = 'admin::table.columns.actions';

    public function actions($callable)
    {
        call_user_func($callable, $this);
        return $this;
    }

    public function link($label, $href, $target = "_self")
    {
        $action = Action::make();
        $action->label($label)->href($href)->target($target);
        $this->child($action);
        return $action;
    }

    public function delete($label, $link)
    {
        $action = Action::make();
        $action->label($label)
            ->action($link)
            ->method('delete')
            ->class('text-danger')
            ->confirm(__('admin::base.confirm_delete'));
        $this->child($action);
        return $action;
    }

    public function setupModel()
    {
        if (empty($this->model())) {
            return;
        }
        $variables = $this->variables();
        $children  = $this->children;
        foreach ($children as $child) {
            $child->context($variables);
        }
    }

    public function getDefaultLabel()
    {
        return __('admin::base.actions');
    }
}
