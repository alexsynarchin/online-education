<?php


namespace App\Services\Test;



use App\Models\Lesson\QuestionOption;
use App\Services\ImageService;

class OptionService
{
    public function update($data, $id, $directory)
    {
        $options = $data;
        foreach ($options as $key => $item){
            if(!isset($item['id'])){
                $item['id'] = 0;
            }
            $option = QuestionOption::updateOrCreate(['id' =>$item['id']],[
                'question_id' => $id,
                'menuindex' => $key + 1,
                'text' => $item['text'],
                'right_answer' => $item['right_answer']
            ]);
            $option ->save();
            if (strpos($item['preview'], 'data:image') !== false) {
                $option_dir = $directory . 'option-' . $option ->id . '/';
                $imageService = new ImageService();
                $filename = $imageService -> make($item['preview'],$option_dir);
                $option-> image = $filename;
                $option ->directory = $option_dir;
                $option ->save();
            }
        }
    }
}
