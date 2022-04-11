<?php

$queries = array(

	'query' => array(

		'function_score' => [  

	        "query"=>[

	            'match_phrase_prefix'  => [
	                'descricao' => [
	                    'query' => $search,
	                    //'max_expansions' => 10,
                     	'slop'=> 1, 
	                ]
	            ]
	        ],

	        "script_score"=>[
	            'script' => [
	                'source' => " _score * (1  +(doc['popularidade'].value*0.01))"
	            ]
	        ],
	     	'boost_mode' => 'replace'
    	]
	),
);
