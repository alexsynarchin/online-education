<?php


namespace App\Services\Test;


use App\Models\Lesson\Question;
use Carbon\Carbon;
use Storage;
use Image;
use  App\Models\Lesson\QuestionOption;

class StoreQuestionService
{
    public function store($id, $data)
    {
        $menuindex = 1;
        foreach ($data as $item){
            $question = new Question([
               'test_id' => $id,
                'text' => $item['text'],
                'menuindex' => $menuindex,
            ]);
            $question -> save();
            if($item['preview']){
                $imageData = $item['preview'];
                $question ->addMediaFromBase64($item['preview'])
                    ->toMediaCollection('questions');
            }
            $question -> save();
            $menuindex++;
            $this -> storeOptions($question->id, $item['options']);
        }
    }
    private function storeOptions($id, $data){
        $menuindex =1;
        foreach ($data as $item){
            $option = new QuestionOption([
                'question_id' => $id,
                'text' => $item['text'],
                'right_answer' => $item['right_answer'],
                'menuindex' => $menuindex
            ]);
            if($item['preview']){
                $option->addMediaFromBase64($item['preview'])
                    ->toMediaCollection('question_options');

            }
            $option -> save();
            $menuindex++;
        }
    }
}
