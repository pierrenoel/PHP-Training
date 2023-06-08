<?php

namespace app\helpers\validation;

class Validation
{
    /**
     * @var array
     */
    protected array $request;
    /**
     * @var array
     */
    protected array $result = [];

    public function __construct(array $request)
    {
        $this->request = $request;
    }

    /**
     * @param array $array
     * @return $this
     */
    public function required(array $array): self
    {
        return $this->checkConditions($array, function ($value) {
            return empty($value);
        });
    }

    /**
     * @param array $array
     * @param int $min
     * @return $this
     */
    public function min(array $array, int $min) :self
    {
        return $this->checkConditions($array, function ($value) use ($min) {
            return strlen($value) <= $min && strlen($value) >= 1;
        });
    }

    /**
     * @param array $array
     * @param callable $condition
     * @return $this
     */
    public function checkConditions(array $array, callable $condition) : self
    {
        foreach ($this->request as $key => $value) {

            foreach ($array as $keyA => $valueA) {

                if ($key == $keyA && $condition($value)) {

                    $this->result[$key] = $valueA;
                }
            }
        }

        return $this;
    }

    /**
     * @return bool|string
     */
    public function validate(): bool|string
    {
       if(!empty($this->result))
       {
           http_response_code(400);
           echo json_encode($this->result);
       }
       else return true;
    }
}