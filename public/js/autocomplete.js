
var _posAutoComplete = null;
var _termAutoComplete = null;


$(function(){

    $("#search").autocomplete({

        source: function( request, response ) {

            getTags(request.term, function(data){
                if(request.term != _termAutoComplete){
                    handleAutoComplete(request, data);
                }
            });
        }, 
        minLength: 1,
        delay: 0,
        autoFocus: true,
        open: function() {},
        close: function() {}
    }); 

    $("#search").keyup(function(ev){
        if($(this).val() == ''){
            hideAutoComplete();
        }
    });

    $("#search").focus(function(){
        $('#search').autocomplete("search");
    });

  	$(document).click(function(ev) {
        if(!$(ev.target).hasClass("ui-autocomplete-input")){
            hideAutoComplete();
        }
    });

    $(document).keydown(function(ev){
        handleAutoCompleteDown(ev);
    });

    $(document).keyup(function(ev){
        handleAutoCompleteUp(ev);
    });
});

function getTags(term, callback){

    $.ajax({
        dataType: "json",
        url: '/search/autocomplete',
        type: 'post',
        data: {
            search: term
        },
        success: function(data) {

            if(typeof(callback) == 'function'){
                callback(data);
            }
            
        },
        error: function(data) {
            $('input.suggest-user').removeClass('ui-autocomplete-loading');
        }
    });
}

function boldTag(tag, search) {

    let tl = tag.toLowerCase();
    let sl = search.toLowerCase();
    let startPos = tl.indexOf(sl);

    if (startPos !== -1) {
        let endPos = startPos + sl.length;
        return tl.replace(tl.substring(startPos,endPos), sl+"<strong>");
    }

    return tag;
}

function showAutoComplete(){
    $("#autocomplete_search").show();
    $(".search-wrapper").find(".input-group").addClass("complete");
}

function hideAutoComplete(){

    _termAutoComplete = null;

    $("#autocomplete_search").hide();
    $(".search-wrapper").find(".input-group").removeClass("complete");
    $("#autocomplete_search").empty();
}   

function handleAutoComplete(request, data){

    var search = $("#search").val(); 

    if(search == ''){
        hideAutoComplete(); 
        return ;
    }

    var term = request.term;
    _termAutoComplete = term;

    if(data.length == 0 || term.length == 0 || data.success == false){
        hideAutoComplete();
        return ;
    }

    var autocomplete =  $("#autocomplete_search").empty();

    $("<div>")
    .css({'border-top' : '1px solid #e8eaed', 'margin' : '0 14px', 'padding-bottom' : '4px'})
    .appendTo(autocomplete);


    var list = $("<ul id='autocomplete_list'>").appendTo(autocomplete);

    $.each(data, function(key, item){

        var tag = boldTag(item.tag, search);

        var li = $("<li>")
            .html(tag + "<div style='text-align:right'>")
            .attr("data-position", key)
            .click(function(){
                var url = new URL(window.location.href);
                url.searchParams.set('q', $(this).text());
                url.searchParams.delete('p');
                url.searchParams.delete('start');
                window.location = url.toString();
            })
            .mouseover(function(){

                $(this).parent().find("li").each(function(key, el){
                    $(el).removeClass('selected');
                });

                $(li).addClass('selected');

            })
            .appendTo(list);


        $('<svg focusable="false" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"></path></svg>')
        .css({'height' : '20px', 'width' : '50px', 'color' : '#9aa0a6', 'fill' : 'currentColor'})
        .prependTo(li);

    });

    showAutoComplete();
}

function handleAutoCompleteDown(ev){

    var list = $("#autocomplete_list");

    if(list[0] == undefined){
        _posAutoComplete = null;
    }

    if(list[0] != undefined){

        if(ev.keyCode == 13){
            list.find("li").each(function(key, li){
                if($(li).hasClass("selected")){
                    $("#search").val($(li).text()).trigger("change");
                }
            });
        }

        if(ev.keyCode == 38){

            list.find("li").each(function(key, li){
                if($(li).hasClass("selected")){
                    _posAutoComplete = parseInt($(li).data("position")) - 1;
                }
            });
        }

        if(ev.keyCode == 40){

            list.find("li").each(function(key, li){
                if($(li).hasClass("selected")){
                    _posAutoComplete = parseInt($(li).data("position")) + 1;
                }
            });
        }
    }
}

function handleAutoCompleteUp(ev){

    var list = $("#autocomplete_list");

    if(list[0] == undefined){
        _posAutoComplete = null;
    }   

    if(list[0] != undefined){

        // UP
        if(ev.keyCode == 38){

            var li = list.find("li").last();

            if(_posAutoComplete != null){
                li = list.find('li[data-position="'+_posAutoComplete +'"]');
            }

            if(li[0] == undefined){
                li = list.find("li").last();
            }
        }

        // DOWN
        if(ev.keyCode == 40){

            var li = list.find("li").first();

            if(_posAutoComplete != null){
                li = list.find('li[data-position="'+_posAutoComplete +'"]');
            }

            if(li[0] == undefined){
                li = list.find("li").first();
            }
        }

        if(li != undefined){

            list.find("li").each(function(key, el){
                $(el).removeClass('selected');
            });

            li.addClass("selected");
        }
    }
}
