<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Controller;
use App\Models\Lesson\Lesson;
use App\Models\Lesson\Test;
use App\Models\Lesson\TestResult;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StudentTestController extends Controller
{
    public function index($id)
    {
        $lesson = Lesson::findOrFail($id);
        $test = $lesson->tests()->whereHas('questions')->with(['questions'=>function ($query){
            $query->with('options');
        }])->first();
        $now = Carbon::now();
        //dd($now->addHours($test->repeat_period));
        $test_result = $test ->results() ->where('user_id', \Auth::user()->id)->first();
        //dd($test_result->updated_at->addHours($test->repeat_period));
        $can_test = true;
        if($test_result) {
            if($test_result->updated_at->addHours($test->repeat_period) < Carbon::now()) {
                $can_test = true;
            } else {
                $can_test = false;
            }
        }

        return ['test' => $test, 'can_test' => $can_test];
    }
    public function pass(Request $request, $id)
    {

        $results = $request->get('results');
        $questions_count = count($results);
        $question_weight = 100 /  $questions_count;
        $test_score = 0;
        $answers =[];
        foreach ($results as $result){
            $answer_correct = false;
            foreach ($result['answers'] as $answer){
                if($answer['answer'] === true) {
                    $option_id = $answer['option_id'];
                    if($answer['right_answer'] === true) {
                        $answer_correct = true;
                    } else {
                        $answer_correct = false;
                    }}
            }
            if($answer_correct){
                $test_score = $test_score + $question_weight;
            }
            $answers[] = [
                'question_id' => $result['question_id'],
                'option_id' => $option_id,
                'correct' => $answer_correct
            ];
        }
        $test = Test::findOrFail($id);
        $success =  $test_score >= $test -> complete_percent ? true : false;
        if($success){
            $test -> passed = true;
            $test ->save();
        }
        $last_test_result = TestResult::where('test_id', $id);
        $update_answers = true;
        $test_result = TestResult::updateOrCreate([
            'test_id' => $id,
            'user_id' => \Auth::id(),
        ],
            [
                'test_result' => $test_score
            ]);
        $test_result ->updated_at = Carbon::now();
        $test_result -> save();
        if($update_answers){
            $test_result->answers()->delete();
            $test_result->answers()->createMany($answers);
        }

        $url= '';
        return $url;
        //return $answers;
    }

    public function result(Request $request, $id)
    {
        $test = Test::findOrFail($id);
        $lesson = $test -> lesson;
        $course = $lesson ->course;
        $test_result = $test ->results() ->where('user_id', \Auth::user()->id)->first();
        $answers = $test_result ->answers()->with(['question', 'option'])->get();
        $correct_count = $answers->where('correct',1)->count();
        return [
            'correct_count' => $correct_count,
            'answers' => $answers,
        ];
    }
}
