var $ = jQuery;
var np_data = [];

function getStreamsData(streams, selected_index){
	//for (var i=0; i<streams.length; i++){
	//$.each(streams, function (i, stream) {
	$(streams).each(function(i){
		var stream = streams[i],
			cb="&cb="+Math.floor(Math.random()*1e14), // &cb=21611190065014
			url="https://api.composer.nprstations.org/v1/widget/"+stream.data.ucs+"/now?format=json"+cb;

		$.ajax({
			url: url,
			cache: false,
            indexValue: i,
			success: function(data){
				//np_data.push([i, data]);
				if (np_data[i]){
					np_data[i][0] = i;
					np_data[i][1] = data;
				} else {
					// if doesn't already exist, add it
					np_data.push([i, data]);
				}

				if (i == selected_index){
					updateNowPlaying(data);
				}

				if (i == streams.length-1){
					ajaxDoneCheck(selected_index);
				}
			}
		});

	});

}

function ajaxDoneCheck(selected_index){
	if (np_data.length == streams.length) {
		sortData();
		updateStreamList();
	} else {
		getStreamsData(streams, selected_index);
	}
};

function sortData(){
	np_data.sort(function(a, b) {
        var x = a[0]; var y = b[0];
        return ((x < y) ? -1 : ((x > y) ? 1 : 0));
    });
}

$(document).ready(function(){
	
	$(streams).each(function(i){
		var stream = streams[i];
		if (stream.url == '') {
			streams.pop(stream);
		}
	});

	// fix this
	if (streams.length < 3) {
		$('#stream-2').remove();
	}

	buildAudioElement(streams[0]);

	var audio_display = '<div id="audio_display"></div>';

	$('#site-header').append(audio_display);

	initPlayerHTML();

	positionPlayer();
	
});

function buildAudioElement(stream){
	var audio_el = '',
		selected_index = stream.name;

	audio_el += '<audio id="npr-stream-player" controls><source src="';
	audio_el += stream.url;
	audio_el += '" type="audio/mpeg"><source src="';
	audio_el += stream.url;
	audio_el += '" type="audio/ogg"></audio>';

	$('#npr-audio-player-container').html(audio_el);

	getStreamsData(streams, selected_index);
}

function initPlayerHTML() {
	
	var $container = $('#temp_container'),
		html = $container.html(),
		html_audio = $("#npr-stream-player")[0];

	$('#audio_display').html('<div id="jp_container_1">' + html + '</div>');

	initPlayerControls(html_audio);

	//$container = $('#jp_container_1');
	

}

function initPlayerControls(audio){

	var $container = $('#jp_container_1');

	// stream 1 list item
	$('#stream-0').unbind().click(function(){
		$container.addClass('jp-state-playing');
		$('.jp-mute').show();
		$('.jp-unmute').hide();
		buildAudioElement(streams[0]);
	});

	// stream 2 list item
	$('#stream-1').unbind().click(function(){
		$container.addClass('jp-state-playing');
		$('.jp-mute').show();
		$('.jp-unmute').hide();
		buildAudioElement(streams[1]);
	});

	// stream 3 list item
	$('#stream-2').unbind().click(function(){
		$container.addClass('jp-state-playing');
		$('.jp-mute').show();
		$('.jp-unmute').hide();
		buildAudioElement(streams[2]);
	});

	$('#nprap-wrapper .more-toggle').unbind().click(function(){
		$('#nprap-wrapper').toggleClass('expanded topexpand');
	});

	// play button
	$('#nprap-wrapper .jp-play').unbind().click(function(){
		$container.addClass('jp-state-playing');
		audio.play();
	});

	// stop button
	$('#nprap-wrapper .jp-stop').unbind().click(function(){
		$container.removeClass('jp-state-playing');
		audio.pause();
	});

	var volume = $("#npr-stream-player")[0].volume;
	// mute button
	$('#nprap-wrapper .jp-mute').unbind().click(function(){
		$(this).hide();
		$('.jp-unmute').show();
		audio.volume = 0;
	});

	// unmute button
	$('#nprap-wrapper .jp-unmute').unbind().click(function(){
		$(this).hide();
		$('.jp-mute').show();
		audio.volume = volume;
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

	var audio = $("#npr-stream-player")[0];
	initPlayerControls(audio);

	// if playing has been clicked
	if ( $('#jp_container_1').hasClass('jp-state-playing') ){
		audio.play();
	}
}

function updateStreamList(){
	$('#stream-0 .program-name').html(np_data[0][1].onNow.program.name);
	
	if (np_data[1]) {
		$('#stream-1 .program-name').html(np_data[1][1].onNow.program.name);	
	} else {
		$('#stream-1').remove();
	}
	if (np_data[2]) {
		$('#stream-2 .program-name').html(np_data[2][1].onNow.program.name);
	} else {
		$('#stream-2').remove();
	}
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

function positionPlayer(){
	win_width = $(window).width();
	$container = $('#audio_display');

	if (win_width < 768){
		if ( $container.parent("#site-header").length > 0 ){
			$container.detach();
			$container.appendTo('#site-footer').addClass('fixed');
			$('#nprap-wrapper').addClass('expanded topexpand');
		}
	} else if (win_width > 768){
		if ( $container.parent("#site-footer").length > 0 ){
			$container.detach();
			$container.appendTo('#site-header').removeClass('fixed');
		}
	}

	//$('.nav-shelf, .nav-shelf .menu-item a').click(function(){
	$('.nav-shelf *').click(function(){
		$('.sticky-navbar').removeClass('open');
	})
}

$(window).resize(function(){
	positionPlayer();
})




