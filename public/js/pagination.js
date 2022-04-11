
var paginate = false;

$(function(){

	var _pagination = $("#pagination-container");
	var _page = urlParams.get('p');
	var _search = urlParams.get('q');

	if(_pagination[0] != undefined){

		getTotals(_search, function(response){

			_pagination.pagination({

		     	dataSource: response.pages,
			    pageSize: 1,
			    pageNumber : (_page == null) ? 1 : _page,
			    prevText : "Anterior",
			    nextText : "Próximo",
	        	ulClassName  : 'pagination',
	        	className : 'custom-pagination',
			    callback: function(data, pagination) {

			        var page = pagination.pageNumber;

			        if(!paginate){
			        	paginate = true; return false;
			        }

		        	var search = $("#search").val().trim();
		        	var start = (page * 10) - 10;

		        	if(start == 0){
		        		window.location = '/search?q=' + search + '&p=' + page;
		        	}else{
		        		window.location = '/search?q=' + search + '&p=' + page + '&start=' + start;
		        	}
		        	
			    }
			})
		});
	}	
});


function getTotals(search, callback){

	$.ajax({

		url : 'search/pagination?q=' + search,
		type : "GET",
		dataType : "JSON",
		success : function(response){
			if(response.success){
				if(typeof(callback) == 'function'){
					callback(response);
				}
			}
		}
	})
}
