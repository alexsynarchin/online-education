<?php

namespace Database\Seeders;

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
    }
}
