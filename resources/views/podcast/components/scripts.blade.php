<script src="{{asset('podcast/js/jquery-3.3.1.min.js')}}"></script>
<script src="{{asset('podcast/js/jquery-migrate-3.0.1.min.js')}}"></script>
<script src="{{asset('podcast/js/jquery-ui.js')}}"></script>
<script src="{{asset('podcast/js/popper.min.js')}}"></script>
<script src="{{asset('podcast/js/bootstrap.min.js')}}"></script>
<script src="{{asset('podcast/js/owl.carousel.min.js')}}"></script>
<script src="{{asset('podcast/js/jquery.stellar.min.js')}}"></script>
<script src="{{asset('podcast/js/jquery.countdown.min.js')}}"></script>
<script src="{{asset('podcast/js/jquery.magnific-popup.min.js')}}"></script>
<script src="{{asset('podcast/js/aos.js')}}"></script>

<script src="{{asset('podcast/js/mediaelement-and-player.min.js')}}"></script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    var mediaElements = document.querySelectorAll('video, audio'), total = mediaElements.length;

    for (var i = 0; i < total; i++) {
      new MediaElementPlayer(mediaElements[i], {
        pluginPath: 'https://cdn.jsdelivr.net/npm/mediaelement@4.2.7/build/',
        shimScriptAccess: 'always',
        success: function () {
          var target = document.body.querySelectorAll('.player'), targetTotal = target.length;
          for (var j = 0; j < targetTotal; j++) {
            target[j].style.visibility = 'visible';
          }
        }
      });
    }
  });
</script>
<script src="{{asset('podcastj/s/main.js')}}"></script>
@include('sweetalert::alert')