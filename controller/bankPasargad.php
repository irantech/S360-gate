<?php
@session_start();

class BankPasargad {

    public $message = '';
    public $codRahgiri = 'Error';
    public $categoryNum = '';
    public $bankAmount = 0;
    public $number_factor = "";
    public $failMessage = "";
    public $transactionStatus = "";

    public function __construct() {

    }

    public function returnBankCharge() {
        require_once(LIBRARY_DIR . "bank/pasargad/parser.php");
        require_once(LIBRARY_DIR . "bank/pasargad/RSAProcessor.class.php");

        define('MERCHANT_CODE_AJAX', 379918);
        define('TERMINAL_CODE_AJAX', 384790);
        define('KEYPRIVATE_CODE_AJAX', '<RSAKeyValue><Modulus>vVYGdEx9XSxOY0+35rMTxdch/+6G9HdKHOGUsludVupUJjmM2fsA9FX33ds4yjh6TRk9JPEdA9H3kKRRYUUH4IAKviPxKUG5UW70E17otFUB3UEewQxDfPV+4EKgGguKUV6uO+tc7rhJ9ORoKh7qrYJcRG8srhPdAy3N5HmbK0E=</Modulus><Exponent>AQAB</Exponent><P>3Mnuzg8uEQj3upXCNzY2TWvw3b17aq1vZfKssq3auJyrtlE/VCqqZeKcncDDcHnz2SqmNCKtLjOtRWla9cHlnw==</P><Q>24f7Oz/03Rw424zn/D6bUAjBdskpY2t+PU+i3/rl68oqoZ7SZfu/d9ECKHPbw8NxbLaaSdcD1TwCUU/evWCDHw==</Q><DP>VTQMVzLeeS53w2aFs57VJ92O71NvLETP54zV/oI/FN1JGquR/94TMgxYmjxIb8BwTQ87YoU7RcglhtLYilyQSw==</DP><DQ>XBWD+mxvZ7gI2X8XaCVSvJWPoSXsKHnUcB9RcKYrf2ZDz5txIbohrD6Nqy4+BrWahEFsIoEAaJdNWZIpGkK7fQ==</DQ><InverseQ>UEuvirKmbzv+cuyXTtRxTPXcqQ/UvhghhGcbxl0dwcFZsjswCUZRfErAy5OrH+CW7dzfZxYz3LCsaA2qv6qcDw==</InverseQ><D>XbpHSa1P5h730yv0ku0VnbvJJgQzpLOk6bU2QjEeK5em/qFAu+wI5evk31wVue3JhX84CKCfx3NaxazCaI+evMdMFRv2F4Gqc7RBvnl3TcWlyZkEF/8iXH7OYqXpocVwCAgnfYWNQqlfANTEmUFhdMAT+biekC5goJ/K6FuGDm0=</D></RSAKeyValue>');

        $fields = array('invoiceUID' => $_GET['tref']);
        $result = post2https($fields, 'https://pep.shaparak.ir/CheckTransactionResult.aspx');
        $array_buy = makeXMLTree($result);

//        echo '<pre>'.print_r($array_buy,true).'</pre>';
//        echo '<hr/>';
        functions::insertLog('after return bank by in=>'.$_GET['tref'].' array result is==>'.json_encode($array_buy),'logChargeAgencyBankPasargad');
        if ($array_buy["resultObj"]["result"] == "True" && $array_buy["resultObj"]["action"] == "1003") {
            $fields = array(
                'MerchantCode' => $array_buy["resultObj"]["merchantCode"], //shomare ye pazirande e shoma.
                'TerminalCode' => $array_buy["resultObj"]["terminalCode"], //shomare ye terminal e shoma.
                'InvoiceNumber' => $array_buy["resultObj"]["invoiceNumber"], //shomare ye factor tarakonesh.
                'InvoiceDate' => $array_buy["resultObj"]["invoiceDate"], //tarikh e tarakonesh.
                'amount' => $array_buy["resultObj"]["amount"], //mablagh e tarakonesh. faghat adad.
                'TimeStamp' => date("Y/m/d H:i:s"), //zamane jari ye system.
                'sign' => '' //reshte ye ersali ye code shode. in mored automatic por mishavad.
            );

            $processor = new RSAProcessor(KEYPRIVATE_CODE_AJAX, RSAKeyType::XMLString);

            $data = "#" . $fields['MerchantCode'] . "#" . $fields['TerminalCode'] . "#" . $fields['InvoiceNumber'] . "#" . $fields['InvoiceDate'] . "#" . $fields['amount'] . "#" . $fields['TimeStamp'] . "#";
            $data = sha1($data, true);
            $data = $processor->sign($data);
            $fields['sign'] = base64_encode($data); // base64_encode

            $sendingData = "MerchantCode=" . MERCHANT_CODE_AJAX . "&TerminalCode=" . TERMINAL_CODE_AJAX . "&InvoiceNumber=" . $array_buy["resultObj"]["invoiceNumber"] . "&InvoiceDate=" . $array_buy["resultObj"]["invoiceDate"] . "&amount=" . $array_buy["resultObj"]["amount"] . "&TimeStamp=" . $array_buy["resultObj"]["invoiceDate"] . "&sign=" . $result;
            $verifyresult = post2https($fields, 'https://pep.shaparak.ir/VerifyPayment.aspx');
            functions::insertLog('verifyresult data=>'.json_encode($data).' of charge by factorNumber=>'. $array_buy["resultObj"]["invoiceNumber"].'==>'.json_encode($verifyresult),'logChargeAgencyBankPasargad');
            $array_verify = makeXMLTree($verifyresult);
            functions::insertLog('array_verify makeXmlTree data=>'.json_encode($data).' of charge by factorNumber=>'. $array_buy["resultObj"]["invoiceNumber"].'==>'.json_encode($verifyresult),'logChargeAgencyBankPasargad');
            functions::insertLog('===================================================================','logChargeAgencyBankPasargad');
//                        echo '<pre>'.print_r($array_verify,true).'</pre>';
            if ($array_verify["actionResult"]["result"] == "True") {
                $this->codRahgiri = $array_buy["resultObj"]["transactionReferenceID"];
                $this->categoryNum = $array_buy["resultObj"]["invoiceNumber"];
                $this->bankAmount = $array_buy["resultObj"]["amount"];

            }else {
                $this->failMessage = functions::Xmlinformation('ErrorVerify');
                $this->transactionStatus = 'failed';
            }

        }else {
            $this->failMessage = functions::Xmlinformation('NoPayment');
            $this->transactionStatus = 'failed';
        }

    }

}