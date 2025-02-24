<?php

namespace Entryshop\Admin\Http\Controllers\Traits;

trait CanDelete
{
    public function batchDelete()
    {
        $ids = request('ids');
        $this->model()->whereIn('id', $ids)->delete();
        if (request()->ajax()) {
            return admin()->response([
                'success' => true,
                'action'  => 'refresh',
            ]);
        }
        return back();
    }

    public function destroy($id)
    {
        $model = $this->model($id);
        $model->delete();
        if (request()->ajax()) {
            return admin()->response([
                'success' => true,
                'action'  => 'refresh',
            ]);
        }
        return back();
    }
}
