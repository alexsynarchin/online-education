<form class="b-search__form" action="" method="get">
    <div class="b-search">
        <input class="b-search__input" type="text" name="query" placeholder="Введите название темы курса или урока">
        <button type="submit" class="b-search__btn">
            <svg class="b-search__icon">
                <use xlink:href="{{URL::asset('images/sprite.svg#search')}}"></use>
            </svg>
        </button>
    </div>
    <button type="submit" class="b-search__main-btn">
        Найти преподавателя
    </button>
</form>


