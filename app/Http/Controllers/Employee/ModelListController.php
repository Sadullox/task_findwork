<?php

namespace App\Http\Controllers\Employee;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ModelListController extends AdminController
{
    public function employee()
    {
        $employee = DB::table("employees")
            ->select(
                'employees.id',
                'employees.sur_name',
                'employees.given_names',
                'employees.father_name'
            );
        if ($f = \request('search'))
        {
            $employee=$employee
                ->where('sur_name', 'ilike', '%'.$f.'%')
                ->whereOr('given_names','ilike', '%'.$f.'%')
                ->whereOr('father_name', 'ilike', '%'.$f.'%');
        }
        $employee=$employee->limit(10)
            ->get();

        return $this->sendResponse($employee);
    }
}
