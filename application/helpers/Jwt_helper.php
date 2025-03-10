<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// Load the JWT library
require_once(APPPATH . '/libraries/JWT.php');  // Jika Anda menggunakan library secara manual

use \Firebase\JWT\JWT;

class Jwt_helper {

    private static $secret_key = "zerodoseapi"; // Ganti dengan secret key Anda

    // Encode Data menjadi JWT Token
    public static function encode($data) {
        $issuedAt = time();
        $expirationTime = $issuedAt + 3600;  // jwt valid for 1 hour from the issued time
        $payload = array(
            "iat" => $issuedAt,
            "exp" => $expirationTime,
            "data" => $data
        );

        // Use the algorithm and secret key for encoding
        $algorithm = 'HS256'; // Using HS256 algorithm

        // Encoding payload with secret key and algorithm
        return JWT::encode($payload, self::$secret_key, $algorithm);
    }

    // Decode the JWT Token
    public static function decode($jwt) {
        try {
            // Attempt to decode the token
            $decoded = JWT::decode($jwt, self::$secret_key);

            // Return decoded data
            return (array) $decoded->data;
        } catch (ExpiredException $e) {
            // Token expired
            return ['error' => 'Token has expired', 'message' => $e->getMessage()];
        } catch (BeforeValidException $e) {
            // Token is not yet valid
            return ['error' => 'Token is not valid yet', 'message' => $e->getMessage()];
        } catch (SignatureInvalidException $e) {
            // Invalid token signature
            return ['error' => 'Invalid token signature', 'message' => $e->getMessage()];
        } catch (Exception $e) {
            // General error
            return ['error' => 'Failed to decode token', 'message' => $e->getMessage()];
        }
    }
}

