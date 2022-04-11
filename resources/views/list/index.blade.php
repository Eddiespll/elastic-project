@extends('layout')

@section('content-body')
		
	
	<div class="box-content">

		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	 			<a href="/list/insert" class='btn btn-success'>Adicionar Lista</a> 
	 			<a href="/list/migrate" class='btn btn-primary'>Indexar Listas</a> 
	 		</div>
	 	</div>
	 	<br />
	 	<div class="row">
	 		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				
				@foreach ($lists as $list)
				<table class="table table-list">
					<tbody>
						<tr class='theader'>
							<td class='title'>Lista {{ $list->name }}</td>

							<td class='icon'>
								<div class='tdicon'><a href="/list/rule/insert?id={{ $list->id }}"><i class="bi bi-gear"></i></a></div>
							</td>

							<td class='options'>
								<div class="dropdown">
								  	<button class="btn btn-default dropdown-toggle white" type="button" data-bs-toggle="dropdown" aria-expanded="false">
							  			<i class="bi bi-list"></i>
								  	</button>
							  		<ul class="dropdown-menu">
							  			<li>
									    	<a class="dropdown-item" href="/list/link/insert?id={{ $list->id }}">Adicionar Link</a>
									    </li>
									    <li>
									    	<a class="dropdown-item"  href="/list/update?id={{ $list->id }}">Alterar Lista</a>
									    </li>
									    <li>
									    	<a href="javascript:void(0)" class="dropdown-item delete-lista" data-id="{{ $list->id }}" data-name="{{ $list->name }}">Excluir Lista</a>
									    </li>
								     	<li>
									    	<a class="dropdown-item" href="/list/migrate?id={{ $list->id }}">Indexar Lista</a>
									    </li> 
								  	</ul>
								</div>
							</td>
						</tr>

						@foreach ($list->links as $key => $link)
						<tr>
							<td colspan="2">{{ $link }}</td>
							<td class='options'>
								<div class="dropdown">
								  	<button class="btn btn-default dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
							  			<i class="bi bi-list"></i>
								  	</button>
							  		<ul class="dropdown-menu">
									    <li>
									    	<a href="javascript:void(0)" class="dropdown-item delete-link" data-id="{{ $list->id }}" data-pos="{{ $key }}" data-link="{{ $link }}">Excluir Link</a>
									    </li>
								  	</ul>
								</div>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>

				@endforeach
			</div>
		</div>
	</div>

@stop



@section('content-modal')

	<form method="POST" action="list/link/delete">
		<div id="modal-delete-link" class="modal modal-delete fade" tabindex="-1">
			<input hidden name='id' value='' />
			<input hidden name='pos' value='' />
			<div class="modal-dialog">
		    	<div class="modal-content">
			      	<div class="modal-body">
				 		<span class='txt-delete'>Confirmar a remoção do link ?</span>
		      		</div>
		      		<div class="modal-footer">
	        		  	<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Não</button>
	    				<button type="submit" class="btn btn-danger">Sim, remover.</button>
		      		</div>
		    	</div>
		  	</div>
		</div>
	</form>

	<form method="POST" action="list/delete">
		<div id="modal-delete-list" class="modal modal-delete fade" tabindex="-1">
			<input hidden name='id' value='' />
			<input hidden name='pos' value='' />
			<div class="modal-dialog">
		    	<div class="modal-content">
			      	<div class="modal-body">
				 		<span class='txt-delete'>Confirmar a remoção da lista ?</span>
		      		</div>
		      		<div class="modal-footer">
	        		  	<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Não</button>
	    				<button type="submit" class="btn btn-danger">Sim, remover.</button>
		      		</div>
		    	</div>
		  	</div>
		</div>
	</form>

@stop

