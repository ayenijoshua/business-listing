<?php
namespace App\Repositories;

use App\Repositories\Repository;
use App\Listing;

class ListingRepository extends Repository{
    function __construct(Listing $listing){
        parent::__construct($listing);
    }
}