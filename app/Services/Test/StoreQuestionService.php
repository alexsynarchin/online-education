<?php


namespace App\Services\Test;


use App\Models\Lesson\Question;
use Carbon\Carbon;
use Storage;
use Image;
use  App\Models\Lesson\QuestionOption;

class StoreQuestionService
{
    public function store($id, $data, $directory)
    {
        $menuindex = 1;
        foreach ($data as $item){
            $question = new Question([
               'test_id' => $id,
                'text' => $item['text'],
                'menuindex' => $menuindex,
            ]);
            $question -> save();
            $question_dir = $directory . 'question-'.$question->id . '/';
            if($item['preview']){
                $imageData = $item['preview'];
                Storage::makeDirectory('/public/' . $question_dir);
                $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.' . explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
                Image::make($item['preview'])->save(storage_path('app/public/').$question_dir . $fileName);
                $question -> image = $fileName;
                $question ->directory = $question_dir;
                $question -> save();
            }
            $menuindex++;
            $this -> storeOptions($question->id, $item['options'], $question_dir);
        }
    }
    private function storeOptions($id, $data, $directory){
        $menuindex =1;
        foreach ($data as $item){
            $option = new QuestionOption([
                'question_id' => $id,
                'text' => $item['text'],
                'right_answer' => $item['right_answer'],
                'menuindex' => $menuindex
            ]);
            $option -> save();
            if($item['preview']){
                $option_dir = $directory . 'option-' . $option ->id . '/';
                $imageData = $item['preview'];
                Storage::makeDirectory('/public/' .  $option_dir);
                $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.' . explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
                Image::make($item['preview'])->save(storage_path('app/public/'). $option_dir . $fileName);
                $option -> image = $fileName;
                $option ->directory = $option_dir;
                $option -> save();
            }
            $menuindex++;
        }
    }
}
