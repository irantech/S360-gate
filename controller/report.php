<?php

class Report {

    public function getReport($agency, $from, $to, $airline, $memberID) {
        $model = Load::model('book');
        return $model->getReport($agency, $from, $to, '', $airline, $memberID);
    }

    public function getReportLocal($agency, $from, $to, $airline, $memberID) {
        $model = Load::model('book_local');
        return $model->getReportLocal($agency, $from, $to, '', $airline, $memberID);
    }
}

?>
