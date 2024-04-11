<?php

namespace yetilms;

include_once ("config.php");

class DataValidator
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function validateData($data)
    {
        $data = mysqli_real_escape_string($this->conn, $data);
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public function validateEmail($email)
    {
        // Email validation using filter_var function
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        return true;
    }

    public function validatePhoneNumber($phone)
    {
        // Phone number validation: should be exactly 10 digits
        if (!preg_match("/^[0-9]{10}$/", $phone)) {
            return false;
        }
        return true;
    }

    public function validateImage($file)
    {
        if (isset($file['tmp_name']) && $file['tmp_name'] !== '') {
            // Image validation: check file type and size
            $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
            $maxFileSize = 2 * 1024 * 1024; // 2 MB

            if (!in_array($file['type'], $allowedTypes) || $file['size'] > $maxFileSize) {
                return false;
            }
            return true;
        } else {
            // Handle case where no file is uploaded
            return false;
        }
    }

    public function validatePassword($password, $confirmPassword)
    {
        // Password validation: check if passwords match
        if ($password !== $confirmPassword) {
            return false;
        }
        return true;
    }
}

?>

