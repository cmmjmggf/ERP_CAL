<?php

require_once APPPATH . "/third_party/fpdf17/fpdf.php";

class PDF extends FPDF {

    public $Logo = '';

    function getLogo() {
        return $this->Logo;
    }

    function setLogo($Logo) {
        $this->Logo = $Logo;
    } 

    function Footer() {
        
    }
}