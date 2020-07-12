<?php


namespace App\Modules\ReCaptcha;


class ReCaptcha
{

    protected $urlApi = 'https://www.google.com/recaptcha/api/siteverify';
    protected $secretKey = null;

    public function __construct($secretKey)
    {
        $this->secretKey = $secretKey;
    }

    public function getCaptcha()
    {
        $Response = file_get_contents($this->urlApi."?secret=".getenv('CAPTCHA_KEY_PRIVATE')."&response={$this->secretKey}");
        $Return = json_decode($Response);
        return $Return;
    }

    public function isBot()
    {
        $result = $this->getCaptcha();
//        dd($result);
        $success = $result->success ?? false;
        $score = $result->score ?? 1;
        if($success == true && $score > 0.5){
            return false;
        }
        else {
            return true;
        }
    }
}
