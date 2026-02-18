<?php

class TrainBotSearch
{
    public function __construct() {
        $this->search();
    }

    public function search() {
        $url = "http://safar360.chartertech.ir/Core/V-1/Train/search";

        $dataSend = array(
            'FromStation' => "1",
            'ToStation' => "191",
            'MoveDate' => "2024-02-26",
            'TypePassenger' => "3",
            'AdultCount' => 6,
            'ChildCount' => 0,
            'InfantCount' => 0,
        );

        $data_final = [];
        $fileDirect = LOGS_DIR .'Bot_count_train.txt';
        $fileDirect_bot = LOGS_DIR .'Bot_train.txt';
        $count_file = file_get_contents($fileDirect);
        echo $count_file ;
        $count = 100;//(is_numeric($count_file) && $count_file > 0) ? ($count_file + 50) : 100 ;
        for ($i = 0; $i < ($count ); $i++) {
            $data_final[] = $dataSend;
        }

        file_put_contents($fileDirect, "");
        error_log( $count, 3, $fileDirect );
        error_log( ' after data - ' .json_encode($data_final,256|64), 3, $fileDirect_bot );

        $curl_result = $this->MultiCurl($data_final, $url, ['auth_user' => 'atiyehgasht', 'auth_pass' => 'atiyehgasht']);
    }

    function MultiCurl($data, $url, $header, $timeout = 60) {
        $mh = curl_multi_init();
        $result_final = [];

        $ch = [];
        $running = null;
        $fileDirect_bot = LOGS_DIR .'Bot_train.txt';
        error_log( ' header - ' .json_encode($header,256|64), 3, $fileDirect_bot );

        // Create cURL handles for each request
        foreach ($data as $key => $item) {
            $ch[$key] = curl_init();
            curl_setopt($ch[$key], CURLOPT_URL, $url);
            curl_setopt($ch[$key], CURLOPT_USERPWD, $header['auth_user'] . ":" . $header['auth_pass']);
            curl_setopt($ch[$key], CURLOPT_HTTPHEADER, $header);
            curl_setopt($ch[$key], CURLOPT_RETURNTRANSFER, true );
            curl_setopt($ch[$key], CURLOPT_SSL_VERIFYHOST, 0 );
            curl_setopt($ch[$key], CURLOPT_SSL_VERIFYPEER, 0 );
            curl_setopt($ch[$key], CURLOPT_POST, true);
            curl_setopt($ch[$key], CURLOPT_POSTFIELDS, json_encode($item,256|64));
            curl_setopt($ch[$key], CURLOPT_TIMEOUT, $timeout); // Set timeout
            curl_multi_add_handle($mh, $ch[$key]);
        }

        // Execute the multi-handle
        do {
            curl_multi_exec($mh, $running);
        } while ($running > 0);

        // Process the responses
        foreach ($ch as $key => $each_ch) {
            $response = curl_multi_getcontent($each_ch);
            $result_final[$key] = $response;
            error_log( ' in loop - ' .json_encode($result_final[$key],256|64), 3, $fileDirect_bot );
            // Remove the handle from the multi handle
            curl_multi_remove_handle($mh, $each_ch);

            // Close individual cURL handles
            curl_close($each_ch);
        }

        // Close the multi-handle
        curl_multi_close($mh);


        error_log( '---------------------------------------------------------------------------------- ' , 3, $fileDirect_bot );

        return $result_final;
    }
}

new TrainBotSearch();
