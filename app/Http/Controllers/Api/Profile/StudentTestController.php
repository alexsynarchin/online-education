<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Controller;
use App\Models\Lesson\Lesson;
use App\Models\Lesson\Test;
use App\Models\Lesson\TestResult;
use Illuminate\Http\Request;

class StudentTestController extends Controller
{
    public function index($id)
    {
        $lesson = Lesson::findOrFail($id);
        $tests = $lesson->tests()->whereHas('questions')->with(['questions'=>function ($query){
            $query->with('options');
        }])->get();
        return $tests;
    }
    public function pass(Request $request, $id)
    {
        $results = $request->get('results');
        $questions_count = count($results);
        $question_weight = 100 /  $questions_count;
        $test_score = 0;
        $answers =[];
        foreach ($results as $result){
            $answer_correct = true;
            foreach ($result['answers'] as $answer){
                if($answer['right_answer'] != $answer['answer']){
                    $answer_correct = false;
                }
            }
            if($answer_correct){
                $test_score = $test_score + $question_weight;
            }
            $answers[] = [
                'question_id' => $result['question_id'],
                'option_id' => $answer['option_id'],
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
        if($last_test_result -> exists()){
            $last_test_result = $last_test_result->first();
            if($test_score < $last_test_result ->test_result){
                $test_score = $last_test_result ->test_result;
                $update_answers = false;
            }
        }
        $test_result = TestResult::updateOrCreate([
            'test_id' => $id,
            'user_id' => \Auth::id(),
        ],
            [
                'test_result' => $test_score
            ]);
        if($update_answers){
            $test_result->answers()->delete();
            $test_result->answers()->createMany($answers);
        }

        $url= '';
        return $url;
        //return $answers;
    }
}
