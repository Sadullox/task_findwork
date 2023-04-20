<?php

namespace App\Http\Controllers\Admin;

// use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Admin\EmployeeRequest;
use App\Http\Resources\Admin\EmployeeCollection;

class EmployeeController extends AdminController
{

    protected $per_page;

    public function __construct()
    {
        $this->per_page = request('per_page') ? request('per_page') : 25;
    }

    public function index()
    {
        $list = DB::table('employees')
        ->whereNull('employees.deleted_at')
        ->select(
            'employees.id',
            'employees.sur_name',
            'employees.given_names',
            'employees.father_name',
            DB::raw("json_build_object('id', positions.id, 'name', positions.name) as position"),
            DB::raw("TO_CHAR(employees.created_at, 'MM.DD.YYYY') created_at")
        )
        ->join('positions', 'employees.position_id', '=', 'positions.id')
        ->orderBy("employees.id", "desc")
        ->paginate($this->per_page);

        return $this->sendResponse(new EmployeeCollection($list));
    }

    public function store(EmployeeRequest $request)
    {
        DB::table('employees')->insert([
            'given_names' => $request->input('given_names'),
            'father_name' => $request->input('father_name'),
            'sur_name' => $request->input('sur_name'),
            'position_id' => $request->input('position_id'),
            'created_at' => date('Y-m-d H:i:s')
        ]);

        return $this->sendResponse();
    }

    public function show($id)
    {
        $model = DB::table('employees')
        ->whereNull('employees.deleted_at')
        ->select(
            'employees.id',
            'employees.sur_name',
            'employees.given_names',
            'employees.father_name',
            DB::raw("json_build_object('id', positions.id, 'name', positions.name) as position"),
            DB::raw("TO_CHAR(employees.created_at, 'MM.DD.YYYY') created_at")
        )
        ->join('positions', 'employees.position_id', '=', 'positions.id')
        ->where('employees.id', $id)
        ->first();
        
        if (!$model)
        {
            return $this->sendError(
                [],
                'Malumot topilmadi',
                404
            );
        }

        return $this->sendResponse(new \App\Http\Resources\Admin\Employee($model));
    }

    public function update(EmployeeRequest $request, $id)
    {
        $model = DB::table('employees')
        ->whereNull('deleted_at')
        ->find($id);
        
        if (!$model)
        {
            return $this->sendError(
                [],
                'Malumot topilmadi',
                404
            );
        }
        
        DB::table('employees')
        ->where('id', $id)
        ->update([
            'given_names' => $request->input('given_names'),
            'father_name' => $request->input('father_name'),
            'sur_name' => $request->input('sur_name'),
            'position_id' => $request->input('position_id'),
            'updated_at' => date('Y-m-d H:i:s')
        ]); 

        return $this->sendResponse();
    }

    public function destroy($id)
    {
        $model = DB::table('employees')
        ->whereNull('deleted_at')
        ->find($id);
        
        if (!$model)
        {
            return $this->sendError(
                [],
                'Malumot topilmadi',
                404
            );
        }

        DB::table('employees')
        ->where('id', $id)
        ->update([
            'deleted_at' => date('Y-m-d H:i:s'),
        ]);

        return $this->sendResponse();
    }
}
