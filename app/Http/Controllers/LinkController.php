<?php

namespace App\Http\Controllers;

use Elasticsearch\ClientBuilder;
use Illuminate\Http\Request;
use App\Classes\ElasticIndex;

class LinkController extends Controller
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
    * @return void
    */
    public function insert()
    {   

        $id = $this->_request->id;

        if(empty($_POST)){
            return view('link.insert')
                ->with('list', $this->_index->getDocument($id))
                ->with('url', '');
        }

        $document = $this->_index->getDocument($_POST['id']);
        $links = $document->links;
        $link = trim($_POST['url']);

        if(in_array($link, $links)){

            return view('link.insert')
                ->with('list', $this->_index->getDocument($id))
                ->with('error', 'Esse link já existe na lista')
                ->with('url', $link);
        }

        array_push($links, $link);

        $this->_index->updateDocument($_POST['id'], array(
            'links' => $links
        ));

        return redirect("/list/link/insert?id=$id");
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
        $pos = $_POST['pos'];

        $document = $this->_index->getDocument($id);
        $links = $document->links;

        unset($links[$pos]);
        Sort($links); 

        $this->_index->updateDocument($id, array(
            'links' => $links
        ));

        return redirect('/list');
    }
}
