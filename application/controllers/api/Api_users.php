<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// Include REST_Controller library
require APPPATH . '/libraries/REST_Controller.php';

// Use the correct namespace for REST_Controller
use Restserver\Libraries\REST_Controller;

/**
 * API Controller for handling User Authentication and CRUD operations for api_users
 */
class Api_users extends REST_Controller {

    public function __construct()
    {
        // Construct the parent class
        parent::__construct();

        // Set the request rate limits
        $this->methods['login_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['users_post']['limit'] = 100; // 100 requests per hour per user/key
    }

    /**
     * POST method for login and generating bearer token
     */
    public function login_post()
    {
        // Get the username and password from the post request
        $username = $this->post('username');
        $password = $this->post('password');

        // Validate that username and password are not empty
        if (empty($username) || empty($password)) {
            $this->response([
                'status' => FALSE,
                'message' => 'Username and password are required'
            ], REST_Controller::HTTP_BAD_REQUEST); // 400 Bad Request
        }

        // Retrieve user data from the database based on the username
        $this->load->database();
        $this->db->where('username', $username);
        $user = $this->db->get('api_users')->row_array();

        // Check if the user exists and verify the password
        if (!$user || md5($password) !== $user['password']) {
            $this->response([
                'status' => FALSE,
                'message' => 'Invalid username or password'
            ], REST_Controller::HTTP_UNAUTHORIZED); // 401 Unauthorized
        }

        // Generate a simple token (for example, we can use a hash of the username and time)
        $token = md5($user['username'] . time());

        // Store the token in session or pass it to client
        $this->session->set_userdata('user_token', $token);
        $this->session->set_userdata('user_id', $user['id']);

        // Respond with the generated token
        $this->response([
            'status' => TRUE,
            'message' => 'Login successful',
            'token' => $token
        ], REST_Controller::HTTP_OK); // 200 OK
    }

    /**
     * GET method for fetching users or a specific user by ID
     */
    public function users_get()
    {
        // Get the token from the Authorization header
        $token = $this->input->get_request_header('Authorization', TRUE);

        // Validate the token
        if (!$token) {
            $this->response([
                'status' => FALSE,
                'message' => 'Token is required'
            ], REST_Controller::HTTP_UNAUTHORIZED); // 401 Unauthorized
        }

        // Verify the token (check if the token matches the one stored in session)
        if ($token !== $this->session->userdata('user_token')) {
            $this->response([
                'status' => FALSE,
                'message' => 'Invalid token'
            ], REST_Controller::HTTP_UNAUTHORIZED); // 401 Unauthorized
        }

        // If valid token, fetch user data from database
        $user_id = $this->session->userdata('user_id');
        $this->load->database();
        $user = $this->db->get_where('api_users', ['id' => $user_id])->row_array();

        if ($user) {
            $this->response($user, REST_Controller::HTTP_OK); // 200 OK
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'User not found'
            ], REST_Controller::HTTP_NOT_FOUND); // 404 Not Found
        }
    }

    /**
     * POST method for creating a new user
     */
    public function users_post()
    {
        // Validate token (similar to users_get)
        $token = $this->input->get_request_header('Authorization', TRUE);

        // Check if the token is provided
        if (!$token) {
            $this->response([
                'status' => FALSE,
                'message' => 'Token is required'
            ], REST_Controller::HTTP_UNAUTHORIZED); // 401 Unauthorized
        }

        // Check if the token is valid (check against your session)
        if ($token !== $this->session->userdata('user_token')) {
            $this->response([
                'status' => FALSE,
                'message' => 'Invalid token'
            ], REST_Controller::HTTP_UNAUTHORIZED); // 401 Unauthorized
        }

        // Proceed with creating a new user
        $name = $this->post('name');
        $email = $this->post('email');
        $password = md5($this->post('password')); // Encrypt the password

        $data = [
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'created_at' => date('Y-m-d H:i:s')
        ];

        // Insert new user into the database
        if ($this->db->insert('api_users', $data)) {
            $this->response([
                'status' => TRUE,
                'message' => 'User created successfully'
            ], REST_Controller::HTTP_CREATED); // 201 Created
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'Failed to create user'
            ], REST_Controller::HTTP_INTERNAL_SERVER_ERROR); // 500 Internal Server Error
        }
    }

}

