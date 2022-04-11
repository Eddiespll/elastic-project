@extends('layout')

@section('content-body')
	
    <div class="box-content">
        <form id="frm_list" method="POST">

            <input type="hidden" name="id" value="{{ $list->id }} ">

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class='title-box'>
                        <a href="/list" class="btn"><i class="bi bi-arrow-left-circle"></i></a> 
                        <h3>Configurar lista {{ $list->name }} </h3>
                    </div>
                </div>
            </div>

            <div style='padding:20px;font-size:13px'>
                <dl>
                    <dt id="seletor_por_tag">
                        <a href="/en-US/docs/Web/CSS/Type_selectors">Seletor por tag</a>
                    </dt>
                    <dd>
                        Este seletor básico escolhe todos os elementos que correspondem ao nome fornecido.<br>
                        <strong>Sintaxe:</strong>&nbsp;<font face="consolas, Liberation Mono, courier, monospace"><span style="background-color: rgba(220, 220, 220, 0.5);"><em>nome-da-tag</em></span></font><br>
                        <strong>Exemplo:</strong> <code>input</code> corresponderá a qualquer elemento <a href="/pt-BR/docs/Web/HTML/Element/Input"><code>&lt;input&gt;</code></a>
                    </dd>
                    <dt id="seletor_por_classe"><a href="/en-US/docs/Web/CSS/Class_selectors">Seletor por classe</a></dt>
                    <dd>
                        Este seletor básico escolhe elementos baseados no valor de seu atributo&nbsp;<code>classe</code>.<strong> Sintaxe:</strong> <code>.<em>nome-da-classe</em></code><br>
                        <strong>Examplo:</strong> <code>.index</code> irá corresponder a qualquer elemento que tenha o índice de classe (provavelmente definido por um atributo class="index", ou similar).
                    </dd>
                    <dt id="seletor_por_id"><a href="/en-US/docs/Web/CSS/ID_selectors">Seletor por ID</a></dt>
                    <dd>
                        Este seletor básico escolhe nós baseados no valor do atributo <code>id</code>. Deve existir apenas um elemento com o mesmo ID no mesmo documento.<br>
                         <strong>Sintaxe:</strong> <code>#<em>nome-do-id</em></code><br>
                         <strong>Exemplo:</strong> <code>#toc</code> irá corresponder ao elemento que possuir o id=toc (definido por um atributo id="toc", ou similar).
                    </dd>
                    <dt id="seletores_universais"><a href="/en-US/docs/Web/CSS/Universal_selectors">Seletores universais</a></dt>
                    <dd>
                        Este seletor básico irá escolher todos os nós. Ele também existe em um namespace único e em uma     variante de todo o namespace também.<br>
                        <strong>Sintaxe:</strong> <code>*&nbsp;ns|*&nbsp;*|*</code><br>
                        <strong>Exemplo:</strong> <code>*</code> irá&nbsp;corresponder a todos os elementos do documento.
                    </dd>
                    <dt id="seletores_por_atributo"><a href="/en-US/docs/Web/CSS/Attribute_selectors">Seletores por atributo</a></dt>
                    <dd>
                        Este seletor básico ira escolher nós baseados no valor de um de seus atributos, ou até mesmo pelo próprio atributo.<br>
                        <strong>Sintaxe:</strong> <code>[atrib] [atrib=valor] [atrib~=valor] [atrib|=valor] [atrib^=valor] [atrib$=valor] [atrib*=valor]</code><br>
                        <strong>Exemplo:</strong> <code>[autoplay]</code> irá corresponder a todos os elementos que possuirem o atributo <code>autoplay</code> (para qualquer valor).
                    </dd>
                </dl>
            </div>
            <div style='padding:20px'>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    		         	<button id="btn_rule" type="button" class="btn btn-primary">
    		            	<i class="bi bi-plus-circle"></i>
    		            	<span style='font-size:14px'>Nova Regra</span>
    		            </button>
    		            <button type="submit" class="btn btn-success">Gravar</button>
    		        </div>
    		    </div>

                <br />
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-check">

                            @if (isset($list->rules['indexar_pdf']) && $list->rules['indexar_pdf'] == true)
                                <input checked class="form-check-input" type="checkbox" value="t" id="indexar_pdf" name="indexar_pdf">
                            @else
                                <input class="form-check-input" type="checkbox" value="t" id="indexar_pdf" name="indexar_pdf">
                            @endif
                          
                            <label class="form-check-label" for="indexar_pdf">Indexar Conteúdo de Documentos PDF</label>
                        </div>
                       <div class="form-check">

                            @if (isset($list->rules['download_pdf']) && $list->rules['download_pdf'] == true)
                                <input checked class="form-check-input" type="checkbox" value="t" id="download_pdf" name="download_pdf">
                            @else
                                <input class="form-check-input" type="checkbox" value="t" id="download_pdf" name="download_pdf">
                            @endif
                          
                          <label class="form-check-label" for="download_pdf">Fazer Download de Documentos PDF</label>
                        </div>
                    </div>
                </div>

    	     	<br />

                <div id="list_configs" class="row">
                       
             		@foreach ($list->configs as $key => $config)
                       
                        <div class="row wrapper" data-pos="{{ $key }}">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Campo</label>
                                    <input type="text" class="form-control" name="field[][{{ $key }}]" required="required" value="{{ $config['field'] }}">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group" data-pos="{{ $key }}">
                                    <label>Tag</label>
                                    <input type="text" class="form-control" name="tag[][{{ $key }}]" required="required" value="{{ $config['tag'] }}">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group" data-pos="{{ $key }}" style="margin-top: 28px;">
                                    <button type="button" class="btn btn-danger btn-remove-rule" data-pos="{{ $key }}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                       
             		@endforeach
                       
                </div>
            </div>
        </form>
    </div>

@stop
