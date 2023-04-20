<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ModelListController extends AdminController
{
    public function position()
    {
        $positions = DB::table("positions")
            ->select(
                'id',
                'name'
            );
            
        if ($f = \request('search'))
        {
            $positions = $positions->where('name', 'ilike', '%'.$f.'%');
        }

        $positions = $positions
            ->whereNull("deleted_at")
            ->limit(5)->get();

        return $this->sendResponse($positions);
    }
}
