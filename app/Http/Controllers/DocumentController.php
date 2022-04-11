<?php

namespace App\Http\Controllers;
use Elasticsearch\ClientBuilder;
use Illuminate\Http\Request;
use App\Classes\ElasticIndex;


class DocumentController extends Controller
{

   	private $_index;
    private $_request;

	/**
     * @return void
     */
    public function __construct(Request $request)
    {   

        parent::__construct();

        $this->_request = $request;
        $this->_index = new ElasticIndex('index_search');
    }

    public function insert(){

        if(empty($_POST)){
            return view('document.insert');
        }

     	$content = array(
            'url' => trim($_POST['titulo']),
            'title' => trim($_POST['titulo']),
            'main_content' => trim($_POST['conteudo']), 
            'popularidade' => 0
        );

        foreach($_POST as $key => $value){
            $content[$key] = $value;
        }
      
        $this->_index->insertDocument($content);
        return redirect('/document/insert');
    }
}
