<?php

namespace App\Classes;

use Elasticsearch\ClientBuilder;
use App\Classes\ElasticResponse;
use App\Classes\ElasticProperties;


class ElasticIndex
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

     /**
     * @return boolean
     */
    public function search($body, $prepare = true)
    {
        $params = [
            'index' => $this->_name,
            'body'  => $body
        ];

        $response = $this->_client->search($params);

        if($prepare){
            return (new ElasticResponse($response))->getDocuments();
        }else{
            return $response;
        }  
    }   


    /**
     * @return boolean
     */
 	public function exists()
    {
    	return $this->_client->indices()->exists(['index' => $this->_name]);
    }

    /**
     * @return boolean
     */
    public function create()
    {   

        $settings = (new ELasticSettings($this->_name))->getSettings();

        $this->_client->indices()->create([
            'index' => $this->_name, 
            'body' => [
                'settings' => $settings
            ]
        ]);
    }

    /**
     * @return boolean
     */
    public function delete()
    {
    	$this->_client->indices()->delete(['index' => $this->_name]);
    }

    /**
    * @return boolean
    */
    public function reset()
    {
       if($this->exists()) $this->delete(); 

        $this->create();
    }

    public function merge(){
        $guzzClient = new \GuzzleHttp\Client();
        $guzzClient->post("http://localhost:9200/_all/_forcemerge?max_num_segments=1&expand_wildcards=all" );
    }
        
    /**
     * @return boolean
     */
    public function insertDocument(array $content, $id = false)
    {

        (new ElasticProperties($this->_name))->setProperties($content);

        if($id){
            $this->_client->index(['index' => $this->_name, 'id' => $id, 'body' => $content]);
        }else{
            $this->_client->index(['index' => $this->_name, 'body' => $content]);
        }

        $this->merge();
    }

    /**
     * @return boolean
     */
    public function updateDocument($id, array $content)
    {
        $this->_client->update(['index' => $this->_name,'id' => trim($id), 'body' => ['doc' => $content]]);
        $this->merge();
    }

    /**
     * @return boolean
     */
    public function deleteDocument($id)
    {
        $this->_client->delete(['index' => $this->_name, 'id' => trim($id)]);
        $this->merge();
    }

    /**
     * @return array
     */
    public function getDocument($id)
    {
        try{
            $response = $this->_client->get(['index' => $this->_name, 'id' => trim($id)]);
            return (new ElasticResponse($response))->getDocument();

        }catch(\Exception $e){
            return false;
        }
    }

    /**
     * @return array
     */
    public function getAllDocuments()
    {
        $response = $this->_client->search([
            'index'  => $this->_name,
            'body'   => [
                'query' => [
                    'match_all' => new \stdClass()
                ]
            ]
        ]);

        return (new ElasticResponse($response))->getDocuments();
    }
}
