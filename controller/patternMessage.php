<?php


class patternMessage extends clientAuth {
    /**
     * @var string
     */
    private $patternTb ;
    /**
     * @var string
     */
    private $photoUrl;
    public function __construct() {
    parent::__construct();
    $this->patternTb = 'pattern_message_tb';
    }

    public function getPatternMessage($params) {
        $pattern_model = $this->getModel('patternMessageModel')->get()->where('code', $params['code'])->find();
        if ($params['code'] == 'registerLogin') {
            $message = $pattern_model['message'];
            $message_final1 = str_replace("##send_code##",$params['param1'],$message);
            $message_final2 = str_replace("##CLIENT_NAME##",CLIENT_NAME,$message_final1);
            $message_final3 = str_replace("##CLIENT_ADDRESS##",CLIENT_DOMAIN,$message_final2);
            $message_final = $message_final3;
        }
        return $message_final;
    }


}