<?php

namespace App\Http\Controllers;

use Elasticsearch\ClientBuilder;
use Illuminate\Http\Request;
use App\Classes\ElasticIndex;
use App\Classes\ElasticLog;
use App\Classes\ElasticMigrate;
use GuzzleHttp\Client;
use GuzzleHttp\TransferStats;
use Symfony\Component\DomCrawler\Crawler as DomCrawler;
use App\Utils\DomHelper;
use App\Utils\Helper;

class MigrateController extends Controller
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


    public function index(){

        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', '100000');
        ini_set('post_max_size', '100000M');
        ini_set('upload_max_filesize', '100000M');

        $id = $this->_request->id;

        $elasticMigrate = new ElasticMigrate($this->_index);
        $elasticLog = new elasticLog();
        $domHelper =  new DomHelper();
        $guzzClient = new Client();
        $indexSearch = new ElasticIndex('index_search');

        $documents = $elasticMigrate->getDocuments($id);

        foreach($documents as $document){

            $configs = $elasticMigrate->getDocumentConfigs($document);
            $rules = $elasticMigrate->getDocumentRules($document);

            foreach($document->links as $url){

                try{

                    $title = '';
                    $body = '';
                    $pdfContent = array();
                    $pdfLinks = array();
                    $contentConfigs = array();
                    $links = array();

                    list($host, $path) = $elasticMigrate->getUrlConfigs($url);

                    $response = $guzzClient->request('GET', $url, ['verify' => false]);

                    $domCrawler = new DomCrawler(
                        (string)$response->getBody()
                    );

                    foreach($domCrawler->filter('title') as $domElement){
                        $title = $domElement->nodeValue;
                    }

                    foreach($domCrawler->filter('body') as $domElement){
                        $body = $domElement->nodeValue;
                    }

                    if($rules->indexar_pdf == true || $rules->download_pdf == true){
                        $links = $elasticMigrate->getDomLinks($domCrawler);
                    }
                    
                    foreach($links as $link){

                        if($link){

                            $href = '';

                            try{

                                $href = $elasticMigrate->migrateLinksPdf($link, $rules, $host, $pdfContent, $pdfLinks);

                            }catch(\Exception $e){
                                $elasticLog->writeLog("$url:");
                                $elasticLog->writeLog("Não foi possível extrair o conteúdo do PDF $href");
                                $elasticLog->writeLog("Erro:" . $e->getMessage());
                                $elasticLog->writeLog("\n");
                                continue;
                            }
                        }
                    }

                    $pdfContent = implode(" ", $pdfContent);
                    $title = trim($title);
                    $body = trim($body);
        
                    foreach($configs as $config){

                        $field = $config['field'];
                        $tag = $config['tag'];

                        try{
                            $contentConfigs[$field] = $domHelper->filterTag($domCrawler->filter($tag)->html());
                        }catch(\Exception $e){
                            $contentConfigs[$field] = '';
                        }
                    }
                    
                    if(empty($title) && empty($body)){
                        $elasticLog->writeLog("$url:");
                        $elasticLog->writeLog("Link não retornou resultados no corpo e no título.", true, ['error' => true]);
                        $elasticLog->writeLog("\n");
                        continue;
                    }

                    $id = (string)$url;

                    $document = $indexSearch->getDocument($url);
                    $popularidade = 0;

                    if(!empty($document)){
                        $popularidade = $document->popularidade;
                    }

                    $content = array(
                        'url' => (string) $url,
                        'title' => $title,
                        'popularidade' => $popularidade,
                        'body' => $domHelper->filterBody($body),
                        'conteudo_pdf' => $pdfContent,
                        'links_pdf' => $pdfLinks,
                        'data' => date('Y-m-d')
                    );

                    $content = array_merge($content, $contentConfigs);
                    $indexSearch->insertDocument($content, $id);

                    $elasticLog->writeLog("$url:");
                    $elasticLog->writeLog("Link indexado com sucesso!", true, ['insert' => true]);
                    $elasticLog->writeLog("\n");
                    continue;

                }catch(\Exception $e){
                   
                    $elasticLog->writeLog("$url:");
                    $elasticLog->writeLog("Ocorreu um erro ao tentar buscar o conteúdo deste link.", true, ['error' => true]);
                    $elasticLog->writeLog($e->getMessage());
                    $elasticLog->writeLog("\n");
                }
           
            }
        }

        $elasticLog->outputLog();  
        return redirect("/list");
    }

}
