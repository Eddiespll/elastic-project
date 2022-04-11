<?php

namespace App\Classes;

use Elasticsearch\ClientBuilder;
use App\Classes\ElasticResponse;


class ElasticProperties
{

    private $_indexMappings;
    private $_name;
    private $_client;

    /**
     * @return void
     */
    public function __construct($name){

        $this->_name = $name;
        $this->_client = ClientBuilder::create()->build();

        $this->_indexMappings = array(

            'index_list' => [],

            'index_search' => [
                'default' => [
                    'type' => 'vector'
                ],
                'popularidade' => [
                    'type' => 'integer'
                ],
                'links_pdf' => [
                    'type' => 'array'
                ]
            ],
            'index_tags' =>  [
                'default' => [
                    'type' => 'text'
                ],
                'popularidade' => [
                    'type' => 'integer'
                ]
            ],
        );
    }

    /**
     * @return void
     */
    public function setProperties($content){

        $config = $this->_indexMappings[$this->_name];

        if(empty($config)){
            return false;
        }

        foreach($content as $key => $value){

            $type = false;

            if(isset($config[$key]['type'])){
                $type = $config[$key]['type'];
            }else if(isset($config['default']['type'])){
                $type = $config['default']['type'];
            }

            if(!$type){
                continue;
            }

            switch($type){
                case 'integer' : $this->setInteger($key); break;
                case 'search_as_you_type' : $this->setSearchAsYouType($key);break;
                case 'vector' : $this->setVector($key);break;
                case 'completion' : $this->setCompletion($key);break;
            }
        }
    }

    /**
     * @return void
     */
    public function setInteger($field){

        $properties = array(
            "$field" => [
                "type" => "integer"
            ]
        );

        $this->_client->indices()->putMapping([
            'index' => $this->_name,
            'body' => [
                'properties' => $properties
            ]
        ]);
    }

    /**
     * @return void
     */
    public function setVector($field){

        $properties = array(
            "$field" => [
                "type" => "text" ,
                "term_vector" => "with_positions_offsets_payloads",
                "search_analyzer" => "analyzer_brazilian",
            ]
        );

        $this->_client->indices()->putMapping([
            'index' => $this->_name,
            'body' => [
                'properties' => $properties
            ]
        ]);
    }

    /**
     * @return void
     */
    public function setSearchAsYouType($field){

        $properties = array(
            "$field" => [
                "type" => "search_as_you_type" ,
                "search_analyzer" => "analyzer_brazilian",
            ]
        );

        $this->_client->indices()->putMapping([
            'index' => $this->_name,
            'body' => [
                'properties' => $properties
            ]
        ]);
    }

    /**
     * @return void
     */
    public function setCompletion($field){

        $properties = array(
            "$field" => [
                "type" => "completion"
            ]
        );

        $this->_client->indices()->putMapping([
            'index' => $this->_name,
            'body' => [
                'properties' => $properties
            ]
        ]);
    }

}
  
