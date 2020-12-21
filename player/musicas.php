<link rel="stylesheet" href="./player/styles.css">
  <!-- Top Info -->
  <div id="title">
    <span id="track"></span>
    <div id="timer">0:00</div>
    <div id="duration">0:00</div>
  </div>

  <!-- Controls -->
  <div class="controlsOuter">
    <div class="controlsInner">
      <div id="loading"></div>
      <div class="btn" id="playBtn"></div>
      <div class="btn" id="pauseBtn"></div>
      <div class="btn" id="prevBtn"></div>
      <div class="btn" id="nextBtn"></div>
    </div>
    <div class="btn" id="playlistBtn"></div>
    <div class="btn" id="volumeBtn"></div>
  </div>

  <!-- Progress -->
  <div id="waveform"></div>
  <div id="bar"></div>
  <div id="progress"></div>

  <!-- Playlist -->
  <div id="playlist">
    <div id="list"></div>
  </div>

  <!-- Volume -->
  <div id="volume" class="fadeout">
    <div id="barFull" class="bar"></div>
    <div id="barEmpty" class="bar"></div>
    <div id="sliderBtn"></div>
  </div>

  <!-- Scripts -->
  <script src="./player/howler.core.js"></script>
  <script src="./player/siriwave.js"></script>
  <script>

    var MUSICAS = [];
    var SIZE = 0;
        $.ajax({
            async: false,
            dataType: "json",
            url: "admin/api.php?method=getMusicaArtista",
            data: {artcodigo: <?=$artcodigo?>},
            success: function (data) {
                   MUSICAS = data.musicas;
                   SIZE =  parseInt(data.size) - 1;
            }
        });

    function getRandomInt(min, max) {
        min = Math.ceil(min);
        max = Math.floor(max);
        return Math.floor(Math.random() * (max - min)) + min;
    }

  </script>
  <script src="./player/player.js"></script>
