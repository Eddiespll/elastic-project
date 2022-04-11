<?php

namespace App\Http\Controllers;

use Elasticsearch\ClientBuilder;
use Illuminate\Http\Request;
use App\Classes\ElasticIndex;
use App\Classes\ElasticLog;
use GuzzleHttp\Client;
use GuzzleHttp\TransferStats;
use Symfony\Component\DomCrawler\Crawler as DomCrawler;
use App\Utils\DomHelper;
use App\Utils\Helper;

class ListController extends Controller
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
        $this->_index = new ElasticIndex('index_list');
    }

    /**
     * @return view
     */
    public function index()
    {   
        $documents = $this->_index->getAllDocuments();
        return view('list.index')->with('lists', $documents);
    }

    /**
     * @return void
     */
    public function insert()
    {
        if(empty($_POST)){
            return view('list.insert');
        }

    	$this->_index->insertDocument([
            'name' => trim($_POST['name']),
            'links' => [],
            'configs' => []
        ]);

        return redirect('/list');
    }

    /**
     * @return void
     */
    public function update()
    {

        if(empty($_POST)){
            return view('list.update')->with('list', $this->_index->getDocument($this->_request->id));
        }

        $this->_index->updateDocument($_POST['id'], array(
            'name' => trim($_POST['name'])
        ));

        return redirect('/list');
    }

    /**
     * @return void
     */
    public function delete()
    {
        if(empty($_POST)){
            return redirect('/list');
        }

        $id = $_POST['id'];
        $this->_index->deleteDocument($id);
        return redirect('/list');
    }
}
