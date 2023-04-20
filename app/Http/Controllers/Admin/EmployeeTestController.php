<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;
use App\Http\Requests\Admin\EmployeeRequest;
use App\Http\Resources\Admin\EmployeeTestCollection;

class EmployeeTestController extends AdminController
{
    protected $per_page;

    public function __construct()
    {
        $this->per_page = request('per_page') ? request('per_page') : 25;
    }

    public function index()
    {
        $list = DB::table('test_moderators')
        ->whereNull('test_moderators.deleted_at')
        ->select(
            'test_moderators.id',
            'test_moderators.score',
            'test_moderators.test_count',
            'employees.sur_name',
            'employees.given_names',
            DB::raw("null AS question"),
            DB::raw("
                json_build_object(
                    'id', employees.id, 
                    'sur_name', employees.sur_name,
                    'given_names', employees.given_names,
                    'position', json_build_object('id', positions.id, 'name', positions.name)
                    ) as employee
            "),
            DB::raw("TO_CHAR(test_moderators.created_at, 'MM.DD.YYYY') created_at")
        )
        ->join('employees', 'test_moderators.employee_id', '=', 'employees.id')
        ->join('positions', 'employees.position_id', '=', 'positions.id');

        if ($f = \request("position_id"))
        {
            $list = $list->where("positions.id", $f);
        }

        if ($search = \request('search', null))
        {
            $list = $list->where(function(Builder $q) use ($search)
            {
                $q->where('employees.given_names', 'ilike', '%'. $search .'%')
                ->orwhere('employees.sur_name', 'ilike', '%'. $search .'%')
                ->orwhere('positions.name', 'ilike', '%'. $search .'%');
            });
        }

        $list = $list->orderBy("test_moderators.id", "desc")
        ->paginate($this->per_page);

        return $this->sendResponse(new EmployeeTestCollection($list));
    }

    public function show($id)
    {
        $model = DB::table('test_moderators')
        ->whereNull('test_moderators.deleted_at')
        ->select(
            'test_moderators.id',
            'test_moderators.score',
            'test_moderators.test_count',
            'employees.sur_name',
            'employees.given_names',
            DB::raw("null AS question"),
            DB::raw("
                json_build_object(
                    'id', employees.id, 
                    'sur_name', employees.sur_name,
                    'given_names', employees.given_names,
                    'position', json_build_object('id', positions.id, 'name', positions.name)
                    ) as employee
            "),
            DB::raw("TO_CHAR(test_moderators.created_at, 'MM.DD.YYYY') created_at")
        )
        ->join('employees', 'test_moderators.employee_id', '=', 'employees.id')
        ->join('positions', 'employees.position_id', '=', 'positions.id')
        ->where('test_moderators.id', $id)
        ->first();
        
    if (!$model)
    {
        return $this->sendError(
            [],
            'Malumot topilmadi',
            404
        );
    }

    $test_moderator = DB::table("test_moderator_options as tmo")
    ->join("test_contents as tc", "tmo.test_content_parent_id", "=", "tc.id")
    ->where("tmo.test_moderator_id", $id)
    ->selectRaw("
            tmo.test_content_parent_id,
            tc.title,
            tc.test_type,
            CASE 
            WHEN tmo.test_type = 'unique' THEN 
                (
                    SELECT json_agg(obj) as user_files
                    FROM (
                        select json_build_object(
                                'id', test_contents.id,
                                'option', test_contents.title,
                                'right', test_contents.right,
                                'answer_score', tmo.answer_score,
                                'created_at', TO_CHAR(tmo.created_at, 'MM.DD.YYYY')
                        ) as obj from test_contents
                        where 
                        test_contents.id = tmo.test_content_option_id order by test_contents.id asc
                    ) tmp
                )
            WHEN tmo.test_type = 'closed' THEN 
                (
                    SELECT json_agg(obj) as user_files
                    FROM (
                        select json_build_object(
                                'id', test_contents.id,
                                'option', tmo.test_answer,
                                'right', CASE 
                                        WHEN tmo.answer_score >0 THEN
                                            true
                                        ELSE false
                                    END,
                                'answer_score', tmo.answer_score,
                                'created_at', TO_CHAR(tmo.created_at, 'MM.DD.YYYY')
                        ) as obj from test_contents
                        where 
                        test_contents.parent_id = tmo.test_content_parent_id order by test_contents.id asc
                    ) tmp
                )
            WHEN tmo.test_type = 'multiple' THEN 
                (
                    SELECT json_agg(obj) as user_files
                    FROM (
                        select json_build_object(
                                'id', ttc.id,
                                'option', ttc.title,
                                'right', ttc.right,
                                'answer_score', obj_tmo.answer_score
                        ) as obj from test_moderator_options obj_tmo
                        join test_contents as ttc on obj_tmo.test_content_option_id = ttc.id
                        where obj_tmo.test_content_parent_id = tmo.test_content_parent_id
                        AND 
                        obj_tmo.test_moderator_id = $id
                        order by obj_tmo.id asc
                    ) tmp
                )
            ELSE null
        END as your_answer,
        (
            SELECT json_agg(obj) as user_files
            FROM (
                select json_build_object(
                        'id', test_contents.id,
                        'option', test_contents.title,
                        'right', test_contents.right,
                        'created_at', TO_CHAR(test_contents.created_at, 'MM.DD.YYYY')
                ) as obj from test_contents
                where 
                test_contents.parent_id = tmo.test_content_parent_id 
                    AND
                test_contents.right = true
                order by test_contents.id asc
            ) tmp
        ) as right_answer
    ")
    ->distinct("tmo.test_content_parent_id")
    ->get();
    /*
    * test biri birga solishtrib biriktrilyabdi
    */
    $model->question = $test_moderator;

    return $this->sendResponse(new \App\Http\Resources\Admin\EmployeeTest($model, true));

    }

}
