<?php
// File: /app/controllers/HomeController.php

class HomeController extends Controller {
    
    public function index() {
        $this->view('public/home');
    }

    public function news() {
        $this->view('public/berita');
    }
}