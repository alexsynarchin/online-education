<footer class="b-footer">

    <div class="container">
        <div class="row">
            <footer-logo></footer-logo>
            <footer-menu :menu="{{json_encode($footer_nav)}}" ></footer-menu>
            <footer-social
                :instagram_link="{{json_encode(Config::get('settings.instagram_link'))}}"
                :vk_link="{{json_encode(Config::get('settings.vk_link'))}}"
                :facebook_link="{{json_encode(Config::get('settings.facebook_link'))}}"
            ></footer-social>
            <footer-links
                :justice_link="{{json_encode(Config::get('settings.justice_link'))}}"
                :faq_link="{{json_encode(Config::get('settings.faq_link'))}}"
                :email="{{json_encode(Config::get('settings.email'))}}"
                :phone_footer="{{json_encode(Config::get('settings.phone_footer'))}}"
            ></footer-links>
        </div>
    </div>
    <footer-line/>
</footer>
