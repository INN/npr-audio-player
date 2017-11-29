var $ = jQuery;
var np_data = '';

function getNowPlayingData(stream){
	var cb="&cb="+Math.floor(Math.random()*1e14), // &cb=21611190065014
		url="https://api.composer.nprstations.org/v1/widget/"+stream.data.ucs+"/now?format=json"+cb;

	$.ajax({
		url: url,
		cache: false,
		success: function(data){
			updateNowPlaying(data);
		}
	});
}


jQuery(document).ready(function(){

	var audio_el = '';

	audio_el += '<audio id="npr-stream-player" controls><source src="';
	audio_el += streams[0].url;
	audio_el += '" type="audio/mpeg"><source src="';
	audio_el += streams[0].url;
	audio_el += '" type="audio/ogg"></audio>';

	$('#npr-audio-player-container').html(audio_el);

	getNowPlayingData(streams[0]);

	var audio_display = '<div id="audio_display">Spoof Player Contents</div>';

	$('#site-header').append(audio_display);

	initPlayerHTML();
	
});

function initPlayerHTML() {
	
	var $container = $('#temp_container');
	var html = $container.html();

	$('#audio_display').html('<div id="jp_container_1">' + html + '</div>');

	$('#nprap-wrapper .more-toggle').click(function(){
		$('#nprap-wrapper').toggleClass('expanded topexpand');
	});

	$container = $('#jp_container_1');

	// play button
	$('#nprap-wrapper .jp-play').click(function(){
		$container.addClass('jp-state-playing');
		$("#npr-stream-player")[0].play();
	});

	// stop button
	$('#nprap-wrapper .jp-stop').click(function(){
		$container.removeClass('jp-state-playing');
		$("#npr-stream-player")[0].pause();
	});

	

}

function updateNowPlaying(data){
	var i = findUCSIndex(data.onNow.program.ucs);
	$('.stream-label span.stream-title').html(streams[i].desc);
	$('.program-name').html(data.onNow.program.name);
	$('.program-next').html('<span>NEXT:</span> ' + data.nextUp[0].program.name);
	$('.stream-program-meta-view .current.stream').html(streams[i].desc);
	$('#stream-title').html(data.onNow.program.name);

	if (data.onNow.hasOwnProperty('song')) {
		$('#song-view .song-trackname').html(data.onNow.song.trackName);
		var artist_name = $('#song-view .song-artistname');
		if (data.onNow.song.hasOwnProperty('artistName')) {
			artist_name.html(data.onNow.song.artistName);
		} else if (data.onNow.song.hasOwnProperty('composerName')) {
			artist_name.html(data.onNow.song.composerName);
		};
		$('#metadata-container').show();
	} else {
		$('#metadata-container').hide();
	}
	$('#stream-0 .program-name').html(data.onNow.program.name);
}

function findUCSIndex(ucs){
	var match = -1;

	for (var i = 0; i < streams.length; ++i) {
	 	var stream = streams[i];
	 	if(stream.data.ucs == ucs){
			match = i;
			break;
		}
	}

	return match;
}






