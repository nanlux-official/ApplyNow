<?php
// Các hàm validation

class Validator {
    private $errors = [];
    private $data = [];
    
    public function __construct($data) {
        $this->data = $data;
    }
    
    public function validate($rules) {
        foreach ($rules as $field => $ruleString) {
            $rules = explode('|', $ruleString);
            $value = $this->data[$field] ?? null;
            
            foreach ($rules as $rule) {
                $this->applyRule($field, $value, $rule);
            }
        }
        
        return empty($this->errors);
    }
    
    private function applyRule($field, $value, $rule) {
        $parts = explode(':', $rule);
        $ruleName = $parts[0];
        $ruleValue = $parts[1] ?? null;
        
        switch ($ruleName) {
            case 'required':
                if (empty($value) && $value !== '0') {
                    $this->addError($field, 'Trường này là bắt buộc');
                }
                break;
                
            case 'email':
                if (!empty($value) && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addError($field, 'Email không hợp lệ');
                }
                break;
                
            case 'min':
                if (!empty($value) && mb_strlen($value) < $ruleValue) {
                    $this->addError($field, "Tối thiểu {$ruleValue} ký tự");
                }
                break;
                
            case 'max':
                if (!empty($value) && mb_strlen($value) > $ruleValue) {
                    $this->addError($field, "Tối đa {$ruleValue} ký tự");
                }
                break;
                
            case 'numeric':
                if (!empty($value) && !is_numeric($value)) {
                    $this->addError($field, 'Phải là số');
                }
                break;
                
            case 'phone':
                if (!empty($value) && !preg_match('/^[0-9]{10,11}$/', $value)) {
                    $this->addError($field, 'Số điện thoại không hợp lệ');
                }
                break;
                
            case 'date':
                if (!empty($value) && !strtotime($value)) {
                    $this->addError($field, 'Ngày không hợp lệ');
                }
                break;
                
            case 'url':
                if (!empty($value) && !filter_var($value, FILTER_VALIDATE_URL)) {
                    $this->addError($field, 'URL không hợp lệ');
                }
                break;
                
            case 'confirmed':
                $confirmField = $field . '_confirmation';
                if (isset($this->data[$confirmField]) && $value !== $this->data[$confirmField]) {
                    $this->addError($field, 'Xác nhận không khớp');
                }
                break;
        }
    }
    
    private function addError($field, $message) {
        if (!isset($this->errors[$field])) {
            $this->errors[$field] = [];
        }
        $this->errors[$field][] = $message;
    }
    
    public function getErrors() {
        return $this->errors;
    }
    
    public function getFirstError($field) {
        return $this->errors[$field][0] ?? null;
    }
    
    public function hasError($field) {
        return isset($this->errors[$field]);
    }
}

// Helper function
function validate($data, $rules) {
    $validator = new Validator($data);
    $validator->validate($rules);
    return $validator;
}
