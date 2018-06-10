<?php

namespace App\Models;

use PDO;

class Connection{

        private $pdo;

        public function __construct(){
            $this->pdo = new PDO("mysql:host=localhost;dbname=pay_pal","root","root");
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        public function connect(){
            return $this->pdo;
        }

}