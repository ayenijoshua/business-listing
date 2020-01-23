<?php
namespace App\Repositories;

use App\Models\User;

interface RepositoryInterface {

    /**
     * create a user
     */
    public function create(array $data);

    /**
     * gel all users
     */
    public function all();

    /**
     * get a user
     */
    public function get($id);

    /**
     * update a user
     */
    public function update($id, array $data);

    /**
     * delete a user
     */
    public function delete($id);
        
}