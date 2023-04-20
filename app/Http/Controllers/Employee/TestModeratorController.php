<?php

namespace App\Http\Controllers\Employee;

use Illuminate\Support\Facades\DB;
use App\Services\TestCheckService;
use App\Http\Resources\Employee\TestContentCollection;
use App\Http\Requests\Employee\TestSubmissionRequest;
use App\Http\Requests\Employee\TestCheckRequest;

class TestModeratorController extends AdminController
{
    /*
    * testSubmission => xodimlar uchun test yaratadi
    */
    public function testSubmission(TestSubmissionRequest $request)
    {
        if (!$employee = DB::table("employees")->find($request->input('employee_id')))
        {
            return $this->sendError(
                [],
                'Xodim topilmadi!',
                404
            );
        }

        
        /*
        * test_count => test count: N ta test chiqarib beradi xodimlar uchun
        */
        $test_count = $request->input("test_count", 5);
        $test_contents = DB::table('test_contents')
        ->whereNull('test_contents.deleted_at')
        ->whereNull('test_contents.parent_id')
        ->where('test_contents.position_id', $employee->position_id)
        ->select(
            'test_contents.id',
            'test_contents.title as question',
            'test_contents.test_type',
            DB::raw(" 
                CASE
                    WHEN test_contents.test_type='unique' OR test_contents.test_type='multiple' THEN
                        (SELECT json_agg(obj) as user_files
                               FROM (
                                select json_build_object(
                                           'id', tc.id,
                                           'option', tc.title,
                                           'right_answer', tc.right
                                         ) as obj
                                  from test_contents tc
                                 where tc.parent_id = test_contents.id 
                               ) tmp
                        ) 
                    ELSE null
                END AS answer_option
            ")
        );

        if ($test_contents->count()<$test_count)
        {
           return $this->sendError(
                [],
                'Test savolari yetarli emas',
                404
            ); 
        }

        $test_contents = $test_contents
        ->limit($test_count)
        ->inRandomOrder()
        ->get();

        /*
        * Hodim test topshirigi bolsa ochirib yangi test ochadi
        */
        DB::table("test_moderators")->where('employee_id', $employee->id)->delete();
        
        /*
        * Hodimga test yaratadi
        */
        $moderator_id = DB::table('test_moderators')->insertGetId([
            'employee_id' => $request->employee_id,
            'test_count' => $test_count,
            'created_at' => date('Y-m-d H:i:s')
        ]);
        
        return $this->sendResponse([
            'moderator_id' => $moderator_id,
            'questions' => new TestContentCollection($test_contents)
        ]);
    }

    /*
    * testCheck => testni tehshirib beradi
    */
    public function testCheck(TestCheckRequest $request, TestCheckService $testcheckservices)
    {
        if (!$test_moderator = DB::table("test_moderators")->whereNull("deleted_at")->find(\request("moderator_id")))
        {
            return $this->sendError(
                [],
                'Test sinovi mavjud emas tekshirib qayta urinib ko`ring',
                404
            ); 
        }
        /*
        * test javoblarni services tekshirib saqlab beradi
        */
        $res = $testcheckservices->checking($request);

        return $this->sendResponse($res);
    }
}
