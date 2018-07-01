<?php
/**
 * Created by PhpStorm.
 * User: Ali Khalili
 * Date: 5/27/18
 * Time: 12:35 PM
 */

namespace PersianValidator\Mobile;


use Exception;

class Mobile
{
    protected $number;
    protected $length = 11;

    private $hamrahAval = ['0910', '0911', '0912', '0913', '0914', '0915', '0916', '0917', '0918', '0919', '0990', '0991'];
    private $irancell = ['0901', '0902', '0930', '0933', '0935', '0936', '0937', '0938', '0939', '0903'];
    private $rightel = ['0920', '0921', '0922'];
    private $spadan = ['0931', '09324'];
    private $taliya = ['09329'];
    private $kish = ['0934'];



    public function __construct($number)
    {
        $this->number = $number;
    }


    public function validate()
    {
        if (! ($this->validMobile() && $this->isDigit() && $this->checkLength())) {
            throw new Exception('This is not a valid mobile number');
        }
    }

    public function isValid()
    {
        try {
            $this->validate();
        } catch (Exception $exception) {
            return false;
        }
        return true;
    }

    public function notValid()
    {
        return !$this->isValid();
    }
    // -----------------------------------------


    public function isHamrahAval()
    {
        return $this->startsWith($this->number, $this->hamrahAval);
    }

    public function isTaliya()
    {
        return $this->startsWith($this->number, $this->taliya);
    }

    public function isSpadan()
    {
        return $this->startsWith($this->number, $this->spadan);
    }

    public function isKish()
    {
        return $this->startsWith($this->number, $this->kish);
    }

    public function isIrancell()
    {
        return $this->startsWith($this->number, $this->irancell);
    }

    public function isRightel()
    {
        return $this->startsWith($this->number, $this->rightel);
    }

    protected function validMobile()
    {
        return $this->startsWith($this->number, array_merge($this->hamrahAval, $this->irancell, $this->rightel, $this->spadan, $this->taliya, $this->kish));
    }

    protected function isDigit()
    {
        return is_numeric($this->number);
    }

    protected function checkLength()
    {
        return strlen($this->number) == $this->length;
    }


    public function operator()
    {
        if ($this->isHamrahAval()) {
            return 'اپراتور اول ، همراه اول ، MCI';
        }
        if ($this->isTaliya()) {
            return 'شرکت تالیا ، Taliya';
        }
        if ($this->isSpadan()) {
            return 'اسپادان ، Spadan';
        }
        if ($this->isKish()) {
            return 'شبکه مستقل تلفن همراه کیش ، TKC';
        }
        if ($this->isIrancell()) {
            return 'اپراتور دوم ، ایرانسل ، Irancell';
        }
        if ($this->isRightel()) {
            return 'اپراتور سوم ، رایتل ، تامین تلکام ، سازمان تامین اجتماعی ، Rightel';
        }
        return 'این شماره موبایل خطا میباشد';
    }

    public function province()
    {
        if (!$this->isHamrahAval()) {
            return 'این شماره موبایل همراه اول نمی باشد. فقط شماره های همراه اول بر اساس استان میباشند';
        }

        if ($this->startsWith($this->number, '0911')) {
            return 'گلستان، گیلان، مازندران';
        }

        if ($this->startsWith($this->number, '0912')) {
            return 'تهران، البرز، زنجان، سمنان، قزوین، قم';
        }

        if ($this->startsWith($this->number, '0913')) {
            return 'اصفهان، کرمان، یزد، چهارمحال و بختیاری';
        }

        if ($this->startsWith($this->number, '0914')) {
            return 'آذربایجان شرقی، غربی، اردبیل';
        }

        if ($this->startsWith($this->number, '0915')) {
            return 'خراسان شمالی، رضوی، جنوبی، سیستان و بلوچستان';
        }

        if ($this->startsWith($this->number, '0916')) {
            return 'خوزستان، لرستان';
        }

        if ($this->startsWith($this->number, '0917')) {
            return 'فارس، کهگیلویه و بویر احمد، هرمزگان، بوشهر';
        }

        if ($this->startsWith($this->number, '0918')) {
            return 'همدان، ایلام، مرکزی، کردستان، کرمانشاه';
        }

        return 'کلیه شهرهای ایران';
    }

    public static function make($number)
    {
        return new static($number);
    }

    public function __toString()
    {
        return $this->number;
    }


    private function startsWith($haystack, $needles)
    {
        foreach ((array) $needles as $needle) {
            if ($needle !== '' && substr($haystack, 0, strlen($needle)) === (string) $needle) {
                return true;
            }
        }

        return false;
    }
}