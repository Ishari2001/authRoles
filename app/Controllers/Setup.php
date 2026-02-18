<?php
namespace App\Controllers;

use Exception;

class Setup extends BaseController
{
    public function index(){ 
    $migration = service('migrations');

        try {
            $migration->latest();
            echo 'Migration Setup completed successfully.';
             
        } catch (Exception $e) {
            echo 'Migration failed: ' . $e->getMessage();
        }

        
    }

    public function dropTable(){ 
        $migration = service('migrations');

        try {
            $migration->regress(0);
            echo 'Migration drop successfully.';
        } catch (Exception $e) {
            echo 'Error in Deoping database failed: ' . $e->getMessage();
        }
    }

}       