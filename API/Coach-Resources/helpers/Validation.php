<?php

namespace app\helpers;

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

    /**
     * @var mixed
     */
    protected mixed $response;

    public function __construct(array $request)
    {
        $this->request = $request;
        $this->response = app('response');
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
     * @param int $max
     * @return $this
     */
    public function max(array $array, int $max) :self
    {
        return $this->checkConditions($array, function ($value) use ($max) {
            return strlen($value) >= 1 && strlen($value) <= $max;
        });
    }

    /**
     * @param $array
     * @return $this
     */
    public function email($array) : self
    {
        return $this->checkConditions($array,function($value) {
            $sanitizedValue = $this->sanitizeEmail($value);
            return filter_var($sanitizedValue, FILTER_VALIDATE_EMAIL) === false;
        });
    }

    /**
     * @return bool|string
     */
    public function validate(): bool|string
    {
        if (empty($this->result)) return true;
        else {
            http_response_code(400);

            foreach ($this->result as $key => $value) {
                $this->result[$key] = $this->escapeHtml($value);
            }

            echo $this->response->setContent(json_encode([
                'response_code' => 400,
                'message' => $this->result
            ]));

            return false;
        }
    }


    /**
     * @param array $array
     * @param callable $condition
     * @return $this
     */
    private function checkConditions(array $array, callable $condition) : self
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
     * @param string $value
     * @return string
     */
    private function escapeHtml(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }

    /**
     * @param string $email
     * @return string
     */
    private function sanitizeEmail(string $email): string
    {
        return filter_var($email, FILTER_SANITIZE_EMAIL);
    }

}
