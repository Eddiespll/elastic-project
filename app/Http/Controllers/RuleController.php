<?php

namespace App\Http\Controllers;

use Elasticsearch\ClientBuilder;
use Illuminate\Http\Request;
use App\Classes\ElasticIndex;
use GuzzleHttp\Client;
use GuzzleHttp\TransferStats;
use Symfony\Component\DomCrawler\Crawler as DomCrawler;
use App\Utils\DomHelper;
use App\Utils\Helper;

class RuleController extends Controller
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

        if(empty($_POST)){  
            return view('rule.insert')->with('list', $this->_index->getDocument($this->_request->id));
        }

        $configs = array();
        $rules= array();
   
        if(isset($_POST['field'])){

            $content = $_POST;
            $count = count($content['field']);
          
            for($i = 0; $i < $count; $i++){
                $field = array_values($content['field'][$i]);
                $tag = array_values($content['tag'][$i]);
                $configs[] = array('field' => $field[0], 'tag' => $tag[0]);
            }
        }

        if(isset($_POST['download_pdf']) && $_POST['download_pdf'] == 't'){
            $rules['download_pdf'] = true;
        }else{
            $rules['download_pdf'] = false;
        }

        if(isset($_POST['indexar_pdf']) && $_POST['indexar_pdf'] == 't'){
            $rules['indexar_pdf'] = true;
        }else{
            $rules['indexar_pdf'] = false;
        }


        $this->_index->updateDocument($_POST['id'], array(
            'configs' => $configs,
            'rules' => $rules
        ));

        return redirect('/list');
    }
}
