<?php

namespace yetilms;

include_once("functions.php");

include_once ("config.php");


/**
 * Class to validate the inputs field
 */
class DataValidator
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }
    /**
     * Validate the data in basic formate
     *
     * @param string
     * @return string
     */
    public function validateData($data)
    {
        $data = mysqli_real_escape_string($this->conn, $data);
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    /**
     * Validate the email in proper email formate
     *
     * @param string
     * @return string
     */
    public function validateEmail($email)
    {
        // Email validation using filter_var function
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        return true;
    }

    /**
     * Validate the phone in proper phone number formate
     *
     * @param number
     * @return number
     */
    public function validatePhoneNumber($phone)
    {
        // Phone number validation: should be exactly 10 digits
        if (!preg_match("/^[0-9]{10}$/", $phone)) {
            return false;
        }
        return true;
    }

    /**
     * Validate the image in jpeg,png,jpg and less than 2mb
     *
     * @param string
     * @return string
     */
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


    /**
     * Validate the password and confirm password are equal or not.
     * 1. Password must be more than 8 characters.
     * 2. Password must have at least one capital letter.
     * 3. Password must have at least one special character.
     *
     * @param string $password
     * @param string $confirmPassword
     * @return bool True if password is valid, false otherwise
     */
    public function validatePassword($password, $confirmPassword)
    {
        // Password length should be greater than 8 characters
        if (strlen($password) < 8) {
            return false;
        }

        // Password should contain at least one capital letter
        if (!preg_match('/[A-Z]/', $password)) {
            return false;
        }

        // Password should contain at least one special character
        if (!preg_match('/[!@#$%^&*()\-_=+{};:,<.>]/', $password)) {
            return false;
        }

        // Password validation: check if passwords match
        if ($password !== $confirmPassword) {
            return false;
        }

        return true;
    }
}


