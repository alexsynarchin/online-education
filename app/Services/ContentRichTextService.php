<?php


namespace App\Services;
use DOMDocument;
use Storage;
use Image;
use App\Models\Lesson\LessonContent;

class ContentRichTextService
{
    public function store($data, $directory, $path){
        $content_dir = $directory . '/content/';
        Storage::makeDirectory('public/' .$content_dir);
        $content = new LessonContent();
        $dom = new DomDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML(mb_convert_encoding($data, 'HTML-ENTITIES', 'UTF-8'));
        libxml_clear_errors();

        $images = $dom->getElementsByTagName('img');



        // foreach <img> in the submited message
        foreach($images as $img){
            $src = $img->getAttribute('src');

            // if the img source is 'data-url'
            if(preg_match('/data:image/', $src)){

                // get the mimetype
                preg_match('/data:image\/(?<mime>.*?)\;/', $src, $groups);
                $mimetype = $groups['mime'];

                // Generating a random filename

                $filename = uniqid();
                $filepath = $content_dir.$filename.'.'.$mimetype;

                // @see http://image.intervention.io/api/
                $image = Image::make($src)
                    // resize if required
                    /* ->resize(300, 200) */
                    ->encode($mimetype, 100) 	// encode file to the specified mimetype
                    ->save((storage_path('app/public/').$filepath));

                $new_src = '/storage/'.$path.'/'.$filename.'.'.$mimetype;
                $img->removeAttribute('src');
                $img->setAttribute('src', $new_src);
            } // <!--endif
        } // <!--endforeach

        $content -> text = $dom->saveHTML();
        return $content;
    }
}
