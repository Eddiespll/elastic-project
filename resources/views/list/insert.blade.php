@extends('layout')

@section('content-body')
	
    <div class="box-content">
        <form id="frm_list" method="POST" >
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class='title-box'>
                        <a href="/list" class="btn"><i class="bi bi-arrow-left-circle"></i></a> 
                        <h3>Adicionar lista</h3>
                    </div>
                </div>
            </div>
            <br />
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label for="name">Nome</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                </div>
            </div>
            <br />  
            <button type="submit" class="btn btn-primary">Gravar</button>
        </form>
    </div>

@stop

