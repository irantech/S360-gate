<?php


class selectColor
{

    public $Info ;

    public function __construct()
    {
        
    }


    public function InfoColor($ClientId)
    {
        Load::autoload('ModelBase');

        $ModelBase = new ModelBase();

        $ClientId = !empty($ClientId) ? $ClientId : CLIENT_ID;

        $SqlColor = "SELECT * FROM client_colors_tb WHERE ClientId={$ClientId}";

        $Color = $ModelBase->load($SqlColor);

        $this->Info = $Color;
    }

    public function SaveChangeColor($param)
    {
        Load::autoload('ModelBase');

        $ModelBase = new ModelBase();
        $ModelBase->setTable('client_colors_tb');

        $ClientID = !empty($param['ClientId'])? $param['ClientId'] : CLIENT_ID ;
        $this->InfoColor($ClientID);

        $d['ColorMainBg'] = $param['colorMainBg'];
        $d['ColorMainBgHover'] = $param['colorMainBgHover'];
        $d['ColorMainText'] = $param['colorMainText'];
        $d['ColorMainTextHover'] = $param['colorMainTextHover'];

        if($this->Info != ''){

            $res = $ModelBase->update($d,"ClientId={$ClientID}");

        } else{

            $d['ClientId'] = $ClientID;
            $res = $ModelBase->insertLocal($d);

        }

        if($res)
        {
            return "success : تعیین رنگ با موفقیت انجام شد";
        }else{
            return "error : خطا در تعیین رنگ";
        }
    }


}