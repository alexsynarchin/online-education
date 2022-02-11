<footer class="b-footer">

    <div class="container">
        <div class="row">
            <footer-logo></footer-logo>
            <footer-menu></footer-menu>
            <footer-social></footer-social>
            <footer-links
                :justice_link="{{json_encode(Config::get('settings.justice_link'))}}"
                :faq_link="{{json_encode(Config::get('settings.faq_link'))}}"
                :email="{{json_encode(Config::get('settings.email'))}}"
                :footer_phone="{{json_encode(Config::get('settings.footer_phone'))}}"
            ></footer-links>
        </div>
    </div>
    <footer-line/>
</footer>
