<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PositionController extends AdminController
{

    protected $per_page;

    public function __construct()
    {
        $this->per_page = request('per_page') ? request('per_page') : 25;
    }

    public function index()
    {
        $list = DB::table('positions')
        ->where('deleted_at',null)
        ->select(
            'id',
            'name', 
            DB::raw("TO_CHAR(created_at, 'MM.DD.YYYY') created_at")
        )
        ->paginate($this->per_page);

        return $this->sendResponseList($list);
    }

    public function store(Request $request)
    {
        DB::table('positions')->insert([
            'name' => $request->input('name'),
            'created_at' => date('Y-m-d H:i:s')
        ]);

        return $this->sendResponse();
    }

    public function show($id)
    {
        $model = DB::table('positions')
        ->where('deleted_at', null)
        ->select(
            'id', 
            'name',
            DB::raw("TO_CHAR(created_at, 'MM.DD.YYYY') created_at")
        )
        ->find($id);

        if (!$model)
        {
            return $this->sendError(
                [],
                'Malumot topilmadi',
                404
            );
        }

        return $this->sendResponse($model);
    }

    public function update(Request $request, $id)
    {
        $model = DB::table('positions')
        ->where('deleted_at',null)
        ->find($id);
        
        if (!$model)
        {
            return $this->sendError(
                [],
                'Malumot topilmadi',
                404
            );
        }

        DB::table('positions')
        ->where('id', $id)
        ->update([
            'name' => $request->input('name'),
            'updated_at' => date('Y-m-d H:i:s')
        ]); 

        return $this->sendResponse();
    }

    public function destroy($id)
    {
        $model = DB::table('positions')
        ->where('deleted_at',null)
        ->find($id);
        
        if (!$model)
        {
            return $this->sendError(
                [],
                'Malumot topilmadi',
                404
            );
        }

        DB::table('positions')
        ->where('id', $id)
        ->update([
            'deleted_at' => date('Y-m-d H:i:s'),
        ]);

        return $this->sendResponse();
    }
}
