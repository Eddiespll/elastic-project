<?php

namespace App\Classes;

class ElasticLog
{

	private $_pathLog;
	private $_pathLogCount;
	private $_fileLog;
	private $_fileLogCount;
	private $_urlScan;
	private $_urlInsert;
	private $_urlUpdate;
	private $_urlBroken;
	private $_startLog;

	public function __construct(){

		date_default_timezone_set('America/Sao_Paulo');
		
		$this->_pathLog = "tmp/log.txt";
		$this->_pathLogCount = "tmp/log_counts.txt";

		if(file_exists($this->_pathLog)){
			unlink($this->_pathLog);
		}

		if(file_exists($this->_pathLogCount)){
			unlink($this->_pathLogCount);
		}

		$this->_fileLog = fopen($this->_pathLog, "w");
		$this->_fileLogCount = fopen($this->_pathLogCount, "w");

        $this->_urlScan = 0;
        $this->_urlInsert = 0;
        $this->_urlBroken = 0;
        $this->_startLog = date('d/m/Y H:i:s');
	}

    public function outputLog(){

    	$this->setTotals();
    	$this->mergeLogs();

    
    	$logname = "log_index_" . date('y_m_d_h_i_s') . ".txt";

    	$file = fopen("tmp/$logname", "w");
    	file_put_contents("tmp/$logname", $this->_pathLogCount);
    	fclose($file);


		/*header('Content-Description: File Transfer');
		header('Content-Type: text/csv');
		header('Content-Disposition: attachment; filename=' . $logname);
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
	
		ob_clean();
		flush();
		readfile($this->_pathLogCount);*/

		unlink($this->_pathLog);
		unlink($this->_pathLogCount);
    }

    public function getLog(){
    	return file_get_contents($this->_pathLog);
    }

    public function mergeLogs(){
		return file_put_contents($this->_pathLogCount, $this->getLog() , FILE_APPEND | LOCK_EX);
    }

    public function writeLog($log, $compute = false, $configs = array()){

    	fwrite($this->_fileLog, $log);
    	fwrite($this->_fileLog, "\n");

    	if($compute){

    		$this->_urlScan++;

    		if(isset($configs['insert'])){
    			$this->_urlInsert++;
    		}

    		if(isset($configs['error'])){
    			$this->_urlBroken++;
    		}
    	}	
    }

    public function setTotals(){
    	fwrite($this->_fileLogCount,"Data Log : " . $this->_startLog . "\n");
    	fwrite($this->_fileLogCount,"Links escaneados : " . $this->_urlScan . "\n");
    	fwrite($this->_fileLogCount,"Links inseridos : " . $this->_urlInsert . "\n");
    	fwrite($this->_fileLogCount,"Links quebrados : " . $this->_urlBroken . "\n");
    	fwrite($this->_fileLogCount,"\n");

    }
}
  
