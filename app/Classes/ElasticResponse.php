<?php

namespace App\Classes;

class ElasticResponse
{
	private $_response;

	/**
     * @param array $response
     * @return void
     */
	public function __construct($response){
		$this->_response = $response;
	}

	public function getDocument(){

		$obj = new \StdClass;
		$obj->id = $this->_response['_id'];

		foreach($this->_response['_source'] as $key => $value){
			$obj->$key = $value;
		}

		return $obj;
	}

	public function getDocuments(){

		$prepared = array();
		$hits = array();

		try{
			$hits = $this->_response['hits']['hits'];
		}catch(\Exception $e){};

	 	if(!empty($hits)){

			foreach($hits as $hit){

				$obj = new \StdClass;
				$obj->score = $hit['_score'];
				$obj->id = $hit['_id'];
				$obj->highlight = '';

				foreach($hit['_source'] as $key => $value){
					$obj->$key = $value;
				}

				if(isset($hit['_source']['data'])){

					setlocale( LC_ALL, 'pt_BR', 'pt_BR.iso-8859-1', 'pt_BR.utf-8', 'portuguese' );
					date_default_timezone_set( 'America/Sao_Paulo' );

					$data = $hit['_source']['data'];
					$dia = strftime('%d', strtotime($data));
					$mes = strftime('%B', strtotime($data));
					$ano = strftime('%Y', strtotime($data));
					$data = $dia . ' de ' . substr($mes, 0, 3) . '. de ' . $ano;
					$obj->data = $data;
				}

				if(isset($hit['highlight'])){

					$highlights = array();

				 	//echo "<pre>" , var_dump($hit['highlight']), "</pre>";
					foreach($hit['highlight'] as $field => $value){
						foreach($value as $k => $v){
							$highlights[] = trim(ucfirst($v)) . '...'; break;
						}
						//break;
					}

					$obj->highlight = implode(" ", $highlights);
				}

				$prepared[] = $obj;
			}
		}

		return $prepared;
	}
}
