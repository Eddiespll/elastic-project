<?php

namespace App\Http\Controllers;

use Elasticsearch\ClientBuilder;
use Illuminate\Http\Request;
use App\Classes\ElasticIndex;

class SearchController extends Controller
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

 	/**
	 * @return view
 	*/
    public function index()
    {   
        return view('search.index');
    }

    /**
     * @return void
    */
    public function search(){

        $search = $this->_request->q;
        $start = $this->_request->start;

        if(empty($search)){
            return redirect('/');
        }

        $query = $this->getQuery('search', 'query', $search);
        $highlight = $this->getQuery('search', 'highlight', $search);

        if(!$start){
            $start = 0;
        }

        $results = $this->_index->search([
            'from' => $start,
            'size' => 10,
            'query' => $query,
            'highlight' => $highlight
        ]);

        return view('search.list')->with('results', $results);
    }

    /**
     * @return void
    */
    public function autocomplete(){

        $search = trim($_POST['search']);

        if(empty($search)){
            exit(json_encode(["success" => false]));
        }

        $indexTags = new ElasticIndex('index_tags');
        $query = $this->getQuery('autocomplete', 'query', $search);
    
        $results = $indexTags->search([
            'size'=>5,
            'query' => $query
        ]);

        if(empty($results)){
            exit(json_encode(["success" => false]));
        }

        $response = array();

        foreach($results as $tag){
            
            $response[] = array(
                'value' => $tag->descricao,
                'label' => $tag->descricao,
                'tag' => $tag->descricao,
                'popularidade' => $tag->popularidade,
                'score' => $tag->score,
            );
        }

        exit(json_encode($response));
    }

    /**
     * @return void
    */
    public function insert(){

        $search = $this->_request->q;

        if(empty($search)){
            exit(json_encode(["success" => false]));
        }

        $indexTags = new ElasticIndex('index_tags');
        $document = $indexTags->getDocument($search);

        if(!$document){

            $content = array(
                'descricao' => $search,
                'popularidade' => 0
            );

            $indexTags->insertDocument($content, $search);

        }else{
            $id = $document->id;
            $popularidade = (int)$document->popularidade;
            $content = ['popularidade' => $popularidade+1];
            $indexTags->updateDocument($id, $content);
        }
        
        exit(json_encode(["success" => true]));
    }

    /**
     * @return void
    */
    public function ranking(){

        $id = $this->_request->id;
        $document = $this->_index->getDocument($id);

        if(!empty($document)){

            $popularidade = $document->popularidade;
            $content = ['popularidade' => $popularidade+1];
            $this->_index->updateDocument($id, $content);
        }

        exit(json_encode(["success" => true]));
    }


    public function pagination(){

        $search = $this->_request->q;
       
        if(empty($search)){
            exit(json_encode(['success' => false]));
        }

        $query = $this->getQuery('search', 'query', $search);

        $results = $this->_index->search([
            'query' => $query
        ], false);

        if(isset($results['hits']['total']['value'])){

            $total = $results['hits']['total']['value'];

            if(($total/10) <= 1){
                exit(json_encode(['success' => false]));
            }

            $pages = range(1,$total/10);

            exit(json_encode([
                'success' => true, 
                'total' => $total,
                'pages' => $pages
            ]));
        }

        exit(json_encode(['success' => false]));
    }
}
