@extends('layout')

@section('content-body')

    <br />
    <form id="frm_document" method="POST">
        
        
        <div class="row">
            <div class="col-sm-5">
                <div class="form-group"> 
                    <input type="text" class="form-control" id="field" placeholder="Nome do campo">
                </div>
            </div>
            <div class="col-sm-2">
                <button type="button" class="btn btn-primary" id="btn_field">Criar campo</button>
            </div>
        </div>
        <br /><br />
        <div id="fields_document" class="row">
            <div class="col-sm-5">
                <div class="form-group">
                    <label for="title">Título</label>
                    <input type="text" class="form-control" id="titulo" name="titulo" required>
                </div>
            </div>
            <div class="col-sm-5">
                <div class="form-group">
                    <label for="title">Conteúdo (main_content)</label>
                    <input type="text" class="form-control" id="conteudo" name="conteudo" required>
                </div>
            </div>
        </div>
        <br /><br />
        <button type="submit" class="btn btn-success">Cadastrar</button>
       
    </form>
@stop




