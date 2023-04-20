<?php

namespace App\Http\Controllers\Admin;

use Throwable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Admin\TestContentRequest;
use App\Http\Resources\Admin\TestContentCollection;

class TestContentController extends AdminController
{

    protected $per_page;

    public function __construct()
    {
        $this->per_page = request('per_page') ? request('per_page') : 25;
    }

    public function index()
    {
        $list = DB::table('test_contents')
        ->whereNull('test_contents.deleted_at')
        ->whereNull('test_contents.parent_id')
        ->select(
            'test_contents.id',
            'test_contents.title as question',
            'test_contents.desc',
            'test_contents.test_type',
            DB::raw("json_build_object('id', positions.id, 'name', positions.name) as position"),
            DB::raw("TO_CHAR(test_contents.created_at, 'MM.DD.YYYY') created_at"),
            DB::raw("null AS answer_option")
        )
        ->join("positions", "test_contents.position_id","=","positions.id")
        ->paginate($this->per_page);

        return $this->sendResponse(new TestContentCollection($list));
    }

    public function store(TestContentRequest $request)
    {
        DB::beginTransaction();

        try {
            $id = DB::table('test_contents')->insertGetId([
                'title' => $request->input('question'),
                'test_type' => $request->input('test_type'),
                'position_id' => $request->input('position_id'),
                'created_at' => date('Y-m-d H:i:s'),
            ]);
            foreach ($request->answer_option as $key => $value) {
                DB::table('test_contents')->insert([
                    'parent_id' => $id,
                    'title' => $value['option'],
                    'right' => $value['right'],
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
            }

            DB::commit();
        } catch (Throwable $e) {
            DB::rollback();
            return $this->sendError([], $e->getMessage());
        }

        return $this->sendResponse();
    }

    public function show($id)
    {
        $model = DB::table('test_contents')
        ->where('test_contents.id', $id)
        ->whereNull('test_contents.deleted_at')
        ->whereNull('test_contents.parent_id')
        ->select(
            'test_contents.id',
            'test_contents.title as question',
            'test_contents.desc',
            'test_contents.test_type',
            DB::raw("json_build_object('id', positions.id, 'name', positions.name) as position"),
            DB::raw("TO_CHAR(test_contents.created_at, 'MM.DD.YYYY') created_at"),
            DB::raw(" 
                ( SELECT json_agg(obj) as user_files
                   FROM (
                    select json_build_object(
                               'id', tc.id,
                               'option', tc.title,
                               'right', tc.right
                             ) as obj
                      from test_contents tc
                     where tc.parent_id = test_contents.id
                   ) tmp
            ) AS answer_option
            ")
        )
        ->join("positions", "test_contents.position_id","=","positions.id")
        ->first();
        
        if (!$model)
        {
            return $this->sendError(
                [],
                'Malumot topilmadi',
                404
            );
        }

        return $this->sendResponse(new \App\Http\Resources\Admin\TestContent($model, true));
    }

    public function update(TestContentRequest $request, $id)
    {
        $model = DB::table('test_contents')
        ->whereNull('deleted_at')
        ->whereNull('parent_id')
        ->find($id);
        
        if (!$model)
        {
            return $this->sendError(
                [],
                'Malumot topilmadi',
                404
            );
        }
        DB::beginTransaction();

        try {
            DB::table('test_contents')
            ->where('id', $id)
            ->update([
                'title' => $request->input('question'),
                'test_type' => $request->input('test_type'),
                'position_id' => $request->input('position_id'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
            foreach ($request->answer_option as $key => $value) {
                DB::table('test_contents')
                ->where('id', $value['id'])
                ->update([
                    'title' => $value['option'],
                    'right' => $value['right'],
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
            }
            DB::commit();
        } catch (Throwable $e) {
            DB::rollback();
            return $this->sendError([], $e->getMessage());
        }

        return $this->sendResponse();
    }

    public function destroy($id)
    {
        $model = DB::table('test_contents')
        ->whereNull('deleted_at')
        // ->whereNull('parent_id')
        ->find($id);

        if (!$model)
        {
            return $this->sendError(
                [],
                'Malumot topilmadi',
                404
            );
        }

        DB::table('test_contents')
        ->where('id', $id)
        ->update([
            'deleted_at' => date('Y-m-d H:i:s'),
        ]);

        return $this->sendResponse();
    }
}
