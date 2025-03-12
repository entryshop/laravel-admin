<?php

namespace Entryshop\Admin\Http\Controllers\Traits;

use Entryshop\Admin\Components\Widgets\Action;
use Entryshop\Admin\Http\Controllers\CrudController;
use Illuminate\Support\Str;

/**
 * @mixin CrudController
 */
trait HasActions
{
    protected function actions($view = 'index')
    {
        $crud_actions = $this->crud()['actions'][$view] ?? ($this->crud()['actions']['all'] ?? []);
        $actions      = [];

        foreach ($crud_actions as $action) {
            if (is_string($action)) {
                if (method_exists($this, 'getAction' . Str::ucfirst($action))) {
                    $actions[] = $this->{'getAction' . Str::ucfirst($action)}();
                }
            } else {
                $action[] = $action;
            }
        }

        return $actions;
    }

    protected function getActionList()
    {
        return Action::make(label: __('admin::base.list'))
            ->class('btn btn-xs btn-ghost-primary')
            ->icon('ri-list-unordered')
            ->href(admin()->url($this->getRoute()));
    }

    protected function getActionView()
    {
        return Action::make(label: __('admin::base.view'))
            ->class('btn btn-xs btn-ghost-primary')
            ->icon('ri-eye-line')
            ->href(admin()->url($this->getRoute() . '/{model.id}'));
    }

    protected function getActionEdit()
    {
        return Action::make(label: __('admin::base.edit'))
            ->icon('ri-edit-line')
            ->class('btn btn-xs btn-ghost-primary')
            ->href(admin()->url($this->getRoute() . '/{model.id}/edit'));
    }

    protected function getActionDelete()
    {
        return Action::make(label: __('admin::base.delete'))
            ->action(admin()->url($this->getRoute() . '/{model.id}'))
            ->icon('ri-delete-bin-line')
            ->class('btn btn-xs btn-ghost-danger')
            ->confirm(__('admin::base.confirm_delete'))
            ->method('delete');
    }
}
