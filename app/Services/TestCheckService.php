<?php 

namespace App\Services;

use Throwable;
use App\Models\TestContent;
use App\Traits\ResponseAble;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Exceptions\HttpResponseException;
/**
 * TestCheckService service
 */
class TestCheckService
{
    use ResponseAble;
	/*
	*	Transaction create required $model
	*/
	public static function checking($request)
    {
        DB::beginTransaction();
        DB::table("test_moderator_options")->where('test_moderator_id', $request->moderator_id)->delete();
        try {
            foreach ($request->question_answers as $key => $val)
            {
                $val["moderator_id"] = $request->moderator_id;

                switch ($val['test_type'])
                {
                    case TestContent::UNIQUETYPE:
                        self::uniqeAnswer($val);
                    break;
                    case TestContent::CLOSEDTYPE:
                        self::closedAnswer($val);
                    break;
                    case TestContent::MULTIPLETYPE:
                        self::multipleAnswer($val);
                    break;
                    default: 
                        // code... 
                    break;
                }
            }
        self::testModeratorScore($request);
        DB::commit();

        } catch (Throwable $e) {
            DB::rollback();
            throw new HttpResponseException(
                response()->json([
                        'success' => false,
                        'code'    => 400,
                        'error'   => $e->getMessage(),
                        'message' => "Error"
                ])->setStatusCode($code)
            );
        }
        
    }

    private static function uniqeAnswer($val)
    {
        $ball = 0;
        $test_contents = DB::table("test_contents")
            ->where("id", $val['answer_id'])
            ->where("parent_id", $val['question_id'])
            ->where("right", true)
            ->first();

        $ball = $test_contents ? 1 : 0;

        self::createModeratorAnswer($val, $ball);
    }

    private static function multipleAnswer($val)
    {
        $ball = 0;
        $test_contents = DB::table("test_contents")
            ->where("parent_id", $val['question_id']);

        $count = $test_contents->where('right', true)->count();
        $right_answer = $test_contents
            ->where("id", $val['answer_id'])
            ->where('right', true)
            ->first();

        $ball = $right_answer ? round(1/$count, 2) : 0;
        self::createModeratorAnswer($val, $ball);
    }

    private static function closedAnswer($val)
    {
        $ball = 0;
        $test_contents= null;
        if (isset($val['answer'])) {
            $test_contents = DB::table("test_contents")
                ->where("parent_id", $val['question_id'])
                ->where("title", $val['answer'])
                ->first();
        }
        $ball = $test_contents ? 1 : 0;
        self::createModeratorAnswer($val, $ball, $val['answer']);
    }


    protected static function createModeratorAnswer($value, $score, $test_answer = null)
    {
            DB::table("test_moderator_options")->insert([
                "test_moderator_id"=>$value['moderator_id'],
                "test_content_parent_id"=> $value['question_id'],
                "test_content_option_id"=> isset($value['answer_id'])?$value['answer_id']:null,
                "test_answer"=> $test_answer,
                "test_type"=> $value['test_type'],
                "answer_score"=> $score,
                'created_at' => date('Y-m-d H:i:s')
            ]);
    }    
    protected static function testModeratorScore($request)
    {   
        $score = DB::table("test_moderator_options")
            ->where('test_moderator_id', $request->moderator_id)
            ->sum("answer_score");
            
        DB::table("test_moderators")
        ->where("id", $request->moderator_id)
        ->update([
            "score"=> $score,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
}