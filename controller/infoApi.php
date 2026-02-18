<?php



class infoApi
{

    public  $information ;

    public function __construct(){


//        $this->information = "https://apitech.ir/gdsApi/";
        $this->information = "192.168.1.100/gdsApi/";
    }



    public  function listTicket()
    {
        $url  =$this->information."RequestTicket";
        $data = array(
            'type'=>'listAll',
        );

        $DataJson = json_encode($data);

       $Result =  functions::curlExecution($url,$DataJson,"yes");


       return $Result["Data"]["Result"] ;

    }


    public  function listCharge()
    {
        $url  =$this->information."Transaction";
        $data = array(
            'type'=>'listAll',
        );

        $DataJson = json_encode($data);

        $Result =  functions::curlExecution($url,$DataJson,"yes");

        return $Result["Data"]["Result"] ;


    }
    public  function listTransaction()
    {
        $url  =$this->information."Transaction";
        $data = array(
            'type'=>'AllTransaction',
        );

        $DataJson = json_encode($data);

        $Result =  functions::curlExecution($url,$DataJson,"yes");

        return $Result["Data"]["Result"] ;


    }



}

