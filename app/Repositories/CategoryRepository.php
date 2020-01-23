<?php
namespace App\Repositories;

use App\Repositories\Repository;
use App\Category;

class CategoryRepository extends Repository{
    function __construct(Category $category){
        parent::__construct($category);
    }
}