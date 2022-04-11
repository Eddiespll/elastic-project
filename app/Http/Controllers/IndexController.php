<?php

namespace App\Http\Controllers;

use Elasticsearch\ClientBuilder;
use Illuminate\Http\Request;
use App\Classes\ElasticIndex;

class IndexController extends Controller
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
    }

 	/**
	 * @return view
 	*/
    public function index()
    {   
        return view('index.index');
    }

    /**
     * @return void
    */
    public function reset(){

        $indexSearch = new ElasticIndex('index_search');
        $indexTags = new ElasticIndex('index_tags');
        
    	$indexSearch->reset();
        $indexTags->reset();
        
	  	return redirect('/');
    }
 
}
