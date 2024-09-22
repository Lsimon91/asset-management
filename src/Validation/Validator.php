<?php

namespace App\Validation;

class Validator
{
    private $errors = [];

    public function validate($data, $rules)
    {
        foreach ($rules as $field => $fieldRules) {
            foreach ($fieldRules as $rule => $parameter) {
                $method = 'validate' . ucfirst($rule);
                if (method_exists($this, $method)) {
                    $this->$method($field, $data[$field] ?? null, $parameter);
                }
            }
        }

        return empty($this->errors);
    }

    public function getErrors()
    {
        return $this->errors;
    }

    private function validateRequired($field, $value, $parameter)
    {
        if (empty($value)) {
            $this->errors[$field][] = "El campo {$field} es obligatorio.";
        }
    }

    private function validateEmail($field, $value, $parameter)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field][] = "El campo {$field} debe ser un email válido.";
        }
    }

    private function validateMin($field, $value, $parameter)
    {
        if (strlen($value) < $parameter) {
            $this->errors[$field][] = "El campo {$field} debe tener al menos {$parameter} caracteres.";
        }
    }

    private function validateMax($field, $value, $parameter)
    {
        if (strlen($value) > $parameter) {
            $this->errors[$field][] = "El campo {$field} no debe exceder {$parameter} caracteres.";
        }
    }

    // Puedes añadir más métodos de validación según sea necesario
}
