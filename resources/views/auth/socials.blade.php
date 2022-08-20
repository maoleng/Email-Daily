<ul class="fxt-socials">
    <form id="form_google" action="{{route('auth.redirect', ['social' => 'google'])}}">
        <input type="hidden" name="device_id">
        <li class="fxt fxt-google"><a href="#" title="google"><i class="fab fa-google"></i></a></li>
    </form>

    <form id="form_github" action="{{route('auth.redirect', ['social' => 'github'])}}">
        <input type="hidden" name="device_id">
        <li class="fxt fxt-github"><a href="#" title="github"><i class="fab fa-github"></i></a></li>
    </form>

    <form id="form_gitlab" action="{{route('auth.redirect', ['social' => 'gitlab'])}}">
        <input type="hidden" name="device_id">
        <li class="fxt fxt-gitlab"><a href="#" title="gitlab"><i class="fab fa-gitlab"></i></a></li>
    </form>

    <form id="form_linkedin" action="{{route('auth.redirect', ['social' => 'linkedin'])}}">
        <input type="hidden" name="device_id">
        <li class="fxt fxt-linkedin"><a href="#" title="linkedin"><i class="fab fa-linkedin"></i></a></li>
    </form>

    <form id="form_facebook" action="{{route('auth.redirect', ['social' => 'facebook'])}}">
        <input type="hidden" name="device_id">
        <li class="fxt fxt-facebook"><a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
    </form>

    <form id="form_twitter" action="{{route('auth.redirect', ['social' => 'twitter'])}}">
        <input type="hidden" name="device_id">
        <li class="fxt fxt-twitter"><a href="#" title="Twitter"><i class="fab fa-twitter"></i></a></li>
    </form>

</ul>
