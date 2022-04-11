<?php

namespace App\Classes;


use Elasticsearch\ClientBuilder;
use App\Classes\ElasticIndex;
use App\Classes\ElasticLog;
use GuzzleHttp\Client;
use GuzzleHttp\TransferStats;
use Symfony\Component\DomCrawler\Crawler as DomCrawler;
use App\Utils\DomHelper;
use App\Utils\Helper;

class ElasticMigrate
{

	private $_elasticIndex;

	public function __construct($elasticIndex){

		$this->_elasticIndex = $elasticIndex;
	}

	public function getDocuments($id = false){

	 	if(!empty($id)){
            return [$this->_elasticIndex->getDocument($id)];
        }else{
          	return $this->_elasticIndex->getAllDocuments();
        }
	}

	public function getDocumentConfigs($document){

	   	try{
            $configs = $document->configs;
        }catch(\Exception $e){
            $configs = array();
        }

        return $configs;
	}

	public function getDocumentRules($document){

	   	try{
            $rules = $document->rules;
        }catch(\Exception $e){
            $rules = array();
        }

        if(!isset($rules['indexar_pdf'])){
        	$rules['indexar_pdf'] = false;
        }

        if(!isset($rules['download_pdf'])){
        	$rules['download_pdf'] = false;
        }

        return (object)$rules;
	}

  	public function getUrlConfigs($url){
	 	$urlConfigs = parse_url($url);
        $host = $urlConfigs['host'];
        $path = $urlConfigs['path'];

        return [$host, $path];
  	}

  	public function getDomLinks($domCrawler){

        $links = $domCrawler->filter('a')->each(function($node) {

            $href  = $node->attr('href');
            $text = $node->text();
            $ext = pathinfo($href, PATHINFO_EXTENSION);

            if($ext == 'pdf'){
                return ['href'=> $href, 'text' => $text];
            }

            return false;
        });

        return array_map("unserialize", array_unique(array_map("serialize", $links)));
  	}

  	public function getLinkContent($link, $host){

	 	$domHelper =  new DomHelper();
	 	$pdfParser =  new \Smalot\PdfParser\Parser(); 

        $href = $link['href'];
        $filename = basename($href);

        if(strpos($href, $host) === false){
            $href = 'https://'.$host.'/'.$href;
        }

        //$href = "tmp/pt996DIRBEN-INSS-5.pdf";
        $ctx = stream_context_create(array('http'=>
            array(
                'timeout' => 10,  
            )
        ));

        $content = file_get_contents($href, false, $ctx);
        $filesize = strlen($content);

        $pdf = $pdfParser->parseFile($href); 
        $text = $domHelper->filterPDF($pdf->getText());

        return array(
        	'href' => $href,
        	'filename' => $filename,
        	'content' => $content,
        	'text' => $text
        );
  	}

  	public function downloadPdf($configs){

  		$filename = $configs['filename'];
  		$content = $configs['content'];

  		$path = "docs/$filename";

        if(file_exists($path)){
            unlink($path);
        }

        $file = fopen($path, "w");
        file_put_contents($path, $content);
        fclose($file);

        return [$filename, $path];
  	}

  	public function migrateLinksPdf($link, $rules, $host, &$pdfContent, &$pdfLinks){

	 	$linkContent = $this->getLinkContent($link, $host);

        if($rules->indexar_pdf == true){
            $pdfContent[] = $linkContent['text'];
        }
        
        if(!empty($linkContent['content'])){

            if($rules->download_pdf == true){

                list($filename, $path) = $this->downloadPdf($linkContent);

                if(!in_array($path, $pdfLinks)){
                    $pdfLinks[] = [
                        'title' => $filename,
                        'href' => $path
                    ];
                }
            }
        }

        return $linkContent['href'];
  	}
}
  
