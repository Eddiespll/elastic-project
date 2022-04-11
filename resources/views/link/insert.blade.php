@extends('layout')

@section('content-body')

    @if (isset($error))

        <br /><div class='alert alert-danger'> {{ $error }}</div>

    @endif
	
    <div class="box-content">
        <form id="frm_link" method="POST" >
            <input type="hidden" name="id" value="{{ $list->id }}">
            <div class="row">
                <div class='title-box'>
                    <a href="/list" class="btn"><i class="bi bi-arrow-left-circle"></i></a> 
                    <h3>Adicionar link na lista {{ $list->name }}</h3>
                </div>
            </div>
            <br />
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label for="name">URL</label>
                        <input type="text" class="form-control" id="url" name="url" value="{{$url}}" required>
                    </div>
                </div>
            </div>
            <br />  
            <button type="submit" class="btn btn-primary">Gravar</button>
        </form>
    </div>

@stop

