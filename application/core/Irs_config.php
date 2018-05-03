<?php  defined('BASEPATH') OR exit('No direct script access allowed');

class Irs_config 
{
    private $irs_ip = '110.232.83.76';
    private $irs_port = '9090';
    private $host_path = 'irs_api';

    
    public function __construct()
    {
    }
    

    public function getIRSUrl()
    {
        return 'http://'.$this->irs_ip.':'.$this->irs_port.'/'.$this->host_path.'/';
    }

    public function getIRSAPIUrl($segment)
    {
        return $this->getIRSUrl().$segment;
    }

    private function getIRSAPISecretKey()
    {
        $segment = 'irs/api/secret/key';
        $urls = $this->getIRSUrl().$segment;

        $record = runGetCurl($urls);

        if($record != null){
            $record = json_decode($record, true);
            return $record;
        }
        else
            return null;
    }

    public function getSecretKey()
    {
        $data = $this->getIRSAPISecretKey();
        return $data['messages']['secret_key'];
    }


    public function setResponse($status=false, $data=null, $optional=null, $code=200)
    {
        $array = array(
            'status' => ($status!=null) ? $status : false,
            'messages' => ($data!=null) ? $data : 'Tidak Ada Respon Data' 
        );

        if($optional != null)
            $array['optional'] = $optional;

        return $this->output->set_content_type('application/json')->set_status_header($code)->set_output(json_encode($array));
        
    }

    public function setEncodeData($array)
    {
        return json_encode($array, true);
    }

    public function PostData($url, $data)
    {
        return json_decode(runPostCurl($url, $this->setEncodeData($data)), true);
    }

}

/* End of file IRSConfig.php */ 
