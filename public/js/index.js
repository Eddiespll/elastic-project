const urlParams = new URLSearchParams(window.location.search);

$(function(){
	bindEvents();
});

function bindEvents(){

	let btnField= $("#btn_field");
	let btnNewUrl = $("#btn_new_url");
	let btnRule = $("#btn_rule");

	btnField.click(function(){
		createFieldDocument(this);
	});

	btnNewUrl.click(function(){
		createUrl(this);
	})

	btnRule.click(function(){
		createRule(this);
	});

	$(".link-result").click(function(){
		insertPopularidade(this);
	});

	$(".btn-remove-rule").click(function(){
		removeRule(this);
	});
	
	$(".delete-link").click(function(){

		var modal = $("#modal-delete-link");
		var id = $(this).data('id');
		var pos = $(this).data('pos');
		var link = $(this).data('link');

		var question = "Confirmar a remoção do link <small><a target='_blank' href='" + link + "'>"+link+"</a></small> ?";
		modal.find('.txt-delete').html(question);

	 	modal.find('input[name=id]').val(id);
	 	modal.find('input[name=pos]').val(pos);
		modal.modal("show");
	});

	$(".delete-lista").click(function(){
			
		var id = $(this).data('id');
		var name = $(this).data('name');

		var modal = $("#modal-delete-list");
		var question = "Confirmar a remoção da lista <b>" + name + "</b> ?";

		modal.find('.txt-delete').html(question);
	 	modal.find('input[name=id]').val(id);
		modal.modal("show");
	});
}

function createFieldDocument(el){
	
	var name = $("#field").val();

	if(name == ''){
		alert("Informe o nome do campo"); return;
	}

	var form = $("#frm_document");
	var wrapper = $("#fields_document");
	var col = $("<div>").addClass('col-sm-5').appendTo(wrapper);
	var group = $("<div>").addClass("form-group").appendTo(col);
	var label = $("<label>").html(name).appendTo(group);
	var input = $("<input type='text' class='form-control col-sm-6'>").attr({'name' : name, 'required' : true}).appendTo(group);

	$("#field").val("");
}

function createUrl(el){

	var form = $("#frm_list");
	var wrapper = $("#fields_url");
	var pos = 1;

	wrapper.find('.form-group').each(function(){
		pos = $(this).data("pos");
	});

	pos+=1;
	
	var name = 'url_' + pos;
	var label = 'LINK ' + pos;

	var group = $("<div>").addClass("form-group").attr('data-pos', pos).appendTo(wrapper);
	var label = $("<label>").html(label).appendTo(group);
	var input = $("<input type='text' class='form-control col-sm-6'>").attr({'name' : name, 'required' : true}).appendTo(group);
}

function createRule(el){

	var configs = $("#list_configs");
	var pos = 0;

	configs.find('.wrapper').each(function(){
		pos = $(this).data("pos");
	});

	pos+=1;
	
	var wrapper = $("<div>").addClass("row wrapper").attr('data-pos', pos).appendTo(configs);

	var wrap = $("<div>").addClass("col-sm-4").appendTo(wrapper);
	var group = $("<div>").addClass("form-group").appendTo(wrap);
	var label = $("<label>").html('Campo').appendTo(group);
	var input = $("<input type='text' class='form-control'>").attr({'name' : 'field[][' + pos + ']', 'required' : true}).appendTo(group);

	var wrap = $("<div>").addClass("col-sm-4").appendTo(wrapper);
	var group = $("<div>").addClass("form-group").attr('data-pos', pos).appendTo(wrap);
	var label = $("<label>").html('Tag').appendTo(group);
	var input = $("<input type='text' class='form-control'>").attr({'name' : 'tag[][' + pos + ']', 'required' : true}).appendTo(group);

	var wrap = $("<div>").addClass("col-sm-4").appendTo(wrapper);
	var group = $("<div>").addClass("form-group").css('margin-top', '28px').attr('data-pos', pos).appendTo(wrap);

	$("<button type='button' class='btn btn-danger btn-remove-rule'>")
	.attr('data-pos', pos)
	.html('<i class="bi bi-trash"></i>')
	.click(function(){
		removeRule(this);
	})
	.appendTo(group);
}

function removeRule(el){
	var pos = $(el).data('pos');
 	$('.wrapper[data-pos="'+pos+'"]').remove();	
}


function insertPopularidade(el){
	var xhttp = new XMLHttpRequest();
	xhttp.open("POST", "/search/ranking?id=" + $(el).data("id"), true);
	xhttp.send();
}
