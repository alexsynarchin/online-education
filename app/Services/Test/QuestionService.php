<?php


namespace App\Services\Test;


use App\Models\Lesson\Question;
use App\Services\ImageService;

class QuestionService
{
    public function update($data, $id,$directory)
    {
        $questions = $data;
        foreach ($questions as $key => $item){
            if(!isset($item['id'])){
                $item['id'] = 0;
            }
            $question = Question::firstOrNew(['id' =>$item['id']],[
                'menuindex' => $key + 1,
                'text' => $item['text'],
                'test_id' => $id,
            ]);
            $question->save();
            $question_dir = $directory . 'question-'.$question->id . '/';
            if (strpos($item['preview'], 'data:image') !== false) {
                $imageService = new ImageService();
                $filename = $imageService -> make($item['preview'],$question_dir);
                $question-> image = $filename;
                $question ->directory = $question_dir;
                $question->save();
            }
            $optionsService = new OptionService();
            $optionsService->update($item['options'], $question->id, $question_dir);
        }

    }
}
