<?php

namespace Database\Seeders;

use App\Models\Category\CategoryType;
use DB;
use Illuminate\Database\Seeder;

class SubjectsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subjects = [
            [
                'title' => 'Математика',
                'type' => 'subject',
                'slug' => 'maths',
            ],
            [
                'title' => 'Русский язык',
                'type' => 'subject',
                'slug' => 'russian-language'
            ],
            [
                'title' => 'Физика',
                'type' => 'subject',
                'slug' => 'physics'
            ],
            [
                'title' => 'Химия',
                'type' => 'subject',
                'slug' => 'chemistry'
            ],
            [
                'title' => 'Естествознание',
                'type' => 'subject',
                'slug' => 'natural-science'
            ],
            [
                'title' => 'Правоведение',
                'type' => 'subject',
                'slug' => 'jurisprudence'
            ],
            [
                'title' => 'Философия',
                'type' => 'subject',
                'slug' => 'philosophy'
            ],
            [
                'title' => 'Экология',
                'type' => 'subject',
                'slug' => 'ecology'
            ],
            [
                'title' => 'Астрономия',
                'type' => 'subject',
                'slug' => 'astronomy'
            ],
            [
                'title' => 'Риторика',
                'type' => 'subject',
                'slug' => 'Rhetoric'
            ],
            [
                'title' => 'Экономика',
                'type' => 'subject',
                'slug' => 'economy'
            ],
            [
                'title' => 'Биология',
                'type' => 'subject',
                'slug' => 'biology'
            ],
            [
                'title' => 'География',
                'type' => 'subject',
                'slug' => 'geography'
            ],
            [
                'title' => 'Информатика',
                'type' => 'subject',
                'slug' => 'informatics'
            ],
        ];
        DB::table('category_types') ->insert($subjects);
        $themes = [
            [
                'title' => 'Алгоритмы',
                'type' => 'theme',
            ],
            [
                'title' => 'Дифферинциалы',
                'type' => 'theme',
            ],
            [
                'title' => 'Интегралы',
                'type' => 'theme',
            ],
            [
                'title' => 'Теория вероятностей',
                'type' => 'theme',
            ],
            [
                'title' => 'Теория чисел',
                'type' => 'theme',
            ],
        ];
        $subject = CategoryType::where('type', 'subject')->where('slug','maths')->firstOrFail();
        foreach ($themes as $theme) {
            $theme = CategoryType::create($theme);
            $theme -> parent_id = $subject -> id;
            $theme -> save();
        }
    }
}
