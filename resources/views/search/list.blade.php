
@extends('search.index')

@section('content-list')
	

	<div class='container-search'>
  		@foreach ($results as $result)

		<div>
	        <div class='row'>
	            <div class='col-sm-12'>
	              	<h3><a class="title link-result" data-id="{{ $result->id }}" target="_blank" href="{{ $result->url }}">{{ $result->title }}</a></h3>
	            </div>
	            <div class='col-sm-12 highlight'>
      			 	{!! $result->highlight !!}
	            </div>

	            @if (isset($result->links_pdf) && !empty($result->links_pdf))
	            	<div class="anexos-wrapper">
		            	<span><i>Anexos:</i></span>
		            	<br>
	        			@foreach($result->links_pdf as $link)
			        		<div>
			            		<img src="img/pdf_icon.png" title="{{ $link['title'] }}" class="icon-list">
		            			<a class="link-option" target="_blank" href="{{ $link['href'] }}">{{ $link['title'] }}</a>
		            		</div>
	        			@endforeach
	        		</div>
	        	@endif
	        </div>

	        <br />


	       

	     	<!--
	     	<div class='row'>
	            <div class='col-sm-12'>
	          		Score : <b>{{ $result->score }}</b>
	            </div>
	        </div>

	        <div class='row'>
	            <div class='col-sm-12'>
	          		Popularidade : <b>{{ $result->popularidade }}</b>
	            </div>
	        </div>
	        -->

	        <br />

		</div>
		@endforeach
		<div id="pagination-container"></div>
	</div>
@stop