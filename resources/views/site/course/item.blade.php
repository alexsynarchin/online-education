<section class="course-item">
    <div class="course-item__heading">
        <a href="{{route('catalog.show', ['edu_slug' => $course -> edu_type -> slug, 'slug' => $course -> slug])}}"  class="course-item__link">
            <h4 class="course-item__title">
                {{$course -> title}}
            </h4>
        </a>

    </div>
    <div class="course-item__content">
        <figure class="course-item__img">
            <img src="{{$course -> image}}" >
        </figure>
        <div class="course-item__main">
            <p class="course-item__descr">
                {{$course -> description}}
            </p>
            <ul class="course-item-lessons">
                @foreach($course -> lessons as $lesson)
                    <li class="course-item-lessons__item course-item-lessons__item--preview">
                        <a href="{{route('lesson.show',[ $course -> edu_type -> slug, $course->slug, $lesson -> slug])}}" class="course-item-lessons__link">
                            {{$lesson -> title}}
                        </a>
                    </li>
                @endforeach
            </ul>
            <a href="{{route('catalog.show', ['edu_slug' => $course -> edu_type -> slug, 'slug' => $course -> slug])}}" class="course-item-lessons__btn btn">Полный список уроков</a>
        </div>
        <div class="course-item__right course-item__right--text-right">
            <div class="course-item__price">
                {{$course ->price}} ₽
            </div>
            <div class="course-item__actions">
                <a href="" class="course-item__btn btn">Купить</a>
            </div>

        </div>
    </div>
    <div class="course-item__footer">
        <div class="course-item__author">
            <label class="course-item__author-label">
                Автор:
            </label>
            <span class="course-item__author-value">
                                    {{$course -> author -> name}}
                {{$course -> author -> surname}}
                                </span>
            <svg class="course-item__author-icon">
                <use xlink:href="{{URL::asset('assets/site/images/sprites.svg?ver=12#sprite-question-icon')}}"></use>
            </svg>
        </div>
    </div>
</section>