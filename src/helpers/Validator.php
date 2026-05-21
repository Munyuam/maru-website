<?php

namespace App\Helpers;

class Validator {
    private array $data;
    private array $errors = [];
    private array $validated = [];

    public function __construct(array $data) {
        $this->data = $data;
    }

    public function validate(array $rules): bool {
        foreach ($rules as $field => $ruleString) {
            $ruleArray = explode('|', $ruleString);
            $value = $this->data[$field] ?? null;

            foreach ($ruleArray as $rule) {
                if (strpos($rule, ':') !== false) {
                    list($ruleName, $ruleParam) = explode(':', $rule);
                } else {
                    $ruleName = $rule;
                    $ruleParam = null;
                }

                $this->applyRule($field, $value, $ruleName, $ruleParam);
            }

            if (!isset($this->errors[$field])) {
                $this->validated[$field] = $this->sanitize($value);
            }
        }

        return empty($this->errors);
    }

    private function applyRule(string $field, mixed $value, string $ruleName, ?string $ruleParam): void {
        if (isset($this->errors[$field])) return;

        switch ($ruleName) {
            case 'required':
                if (empty($value) && $value !== '0') {
                    $this->errors[$field] = "The {$field} field is required.";
                }
                break;
            case 'email':
                if (!empty($value) && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->errors[$field] = "The {$field} must be a valid email address.";
                }
                break;
            case 'min':
                if (!empty($value) && strlen($value) < (int)$ruleParam) {
                    $this->errors[$field] = "The {$field} must be at least {$ruleParam} characters.";
                }
                break;
            case 'max':
                if (!empty($value) && strlen($value) > (int)$ruleParam) {
                    $this->errors[$field] = "The {$field} may not be greater than {$ruleParam} characters.";
                }
                break;
            case 'date':
                if (!empty($value) && !strtotime($value)) {
                    $this->errors[$field] = "The {$field} is not a valid date.";
                }
                break;
            case 'in':
                if (!empty($value)) {
                    $allowed = explode(',', $ruleParam);
                    if (!in_array($value, $allowed)) {
                        $this->errors[$field] = "The selected {$field} is invalid.";
                    }
                }
                break;
        }
    }

    public function errors(): array {
        return $this->errors;
    }

    public function hasErrors(): bool {
        return !empty($this->errors);
    }

    public function validated(): array {
        return $this->validated;
    }

    public function sanitize(mixed $value): mixed {
        if (is_string($value)) {
            return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
        }
        return $value;
    }
}
