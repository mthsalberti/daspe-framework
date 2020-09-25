<?php
namespace Daspeweb\Framework\Exception;

class ObserverException extends \Exception
{
    protected $_field;

    public function __construct($message="", $code=0 , \Exception $previous=NULL, $field = NULL)
    {
        $this->_field = $field;
        parent::__construct($message, $code, $previous);
    }
    public function getField()
    {
        return $this->_field;
    }

}
