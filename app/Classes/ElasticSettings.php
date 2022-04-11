<?php

namespace App\Classes;

use Elasticsearch\ClientBuilder;
use App\Classes\ElasticResponse;


class ElasticSettings
{

    private $_name;
    private $_client;

    /**
     * @return void
     */
    public function __construct($name){

        $this->_name = $name;
        $this->_client = ClientBuilder::create()->build();
    }

    public function getSettings(){

   		return array(
   			'analysis' => [

   				'filter' => [
   					'brazilian_stop' => [
   						'type' => 'stop',
   						'stopwords' => '_brazilian_'
   					]
	   			],
	   			'analyzer' => [
	   				'analyzer_brazilian' => [
	   					'tokenizer' => 'standard',
	   					'filter' => [
	   						'lowercase',
	   						'brazilian_stop'
	   					]
	   				]
	   			]
   			],
    	);

        


    }
}
  
