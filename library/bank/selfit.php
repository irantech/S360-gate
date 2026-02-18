<?php

class selfit implements bankInterface {

    public function payment() {
        $selfitClass = Load::library('bank/selfit/selfit');
        return $selfitClass->requestPayment(func_get_args()[0]);
    }

    public function verify() {
        $selfitClass = Load::library('bank/selfit/selfit');
        return $selfitClass->verifyPayment(func_get_args()[0]);
    }

    public function getToken() {
        return null; // Not needed as token handling is done internally
    }
} 