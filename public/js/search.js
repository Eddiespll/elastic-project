
$(function(){

	let search = $("#search");
 	search.val(urlParams.get('q'));

 	if(urlParams.get('q') != undefined && urlParams.get('q') != ''){
 		insertTag(urlParams.get('q'));
 	}

 	search.on('keyup', function(ev){
		handleSearch(this, ev);
	});

 	if(search.val() == ""){
 		search.focus();
 	}
	
});

function handleSearch(el, ev){

	var search = $(el).val().trim();

	if (ev.key === 'Enter' || ev.keyCode === 13) {
		window.location = '/search?q=' + search;
    }  
}

function insertTag(search){
	var xhttp = new XMLHttpRequest();
	xhttp.open("POST", "/search/insert?q=" + search, true);
	xhttp.send();
}
