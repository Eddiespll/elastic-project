@extends('layout')

@section('content-body')
	
    <div class="box-content">
        <form id="frm_list" method="POST">

            <input type="hidden" name="id" value="{{ $list->id }} ">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class='title-box'>
                        <a href="/list" class="btn"><i class="bi bi-arrow-left-circle"></i></a> 
                        <h3>Alterar lista {{ $list->name }} </h3>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label for="name">Nome</label>
                        <input type="text" class="form-control" id="name" name="name" required value="{{ $list->name }}">
                    </div>
                </div>
            </div>
            <br />  
            <button type="submit" class="btn btn-success">Alterar</button>
        </form>
    </div>

@stop
