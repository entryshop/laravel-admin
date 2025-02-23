<?php

namespace Entryshop\Admin\Http\Controllers\Traits;

trait CanDelete
{
    public function destroy($id)
    {
        $model = $this->model($id);
        $model->delete();
        if (request()->ajax()) {
            return admin()->response([
                'success' => true,
                'action'  => 'reload',
            ]);
        }
        return back();
    }
}
