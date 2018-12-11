<?php
namespace TastyRecipes\View;

class Params {
    private $strParams;

    public function __construct() {
        $input = file_get_contents('php://input');
        parse_str($input, $this->strParams);
    }

    public function getString(string $key) {
        if (empty($this->strParams[$key]))
            throw new ParamMissingException($key);
        else
            return $this->strParams[$key];
    }

    public function getInt(string $key) {
        $str = $this->getString($key);
        if (ctype_digit($str))
            return (int)$str;
        else
            throw new ParamMissingException($key);
    }
}
