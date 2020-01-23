<?php
namespace App\Traits;

/**
 * Trait to help during tests
 */
trait HelpsTests{

    private function createModel($class,$type='create'){
        return factory($class)->$type();
    }

    private function createManyModels($class,$num,$type='create'){
        return factory($class,$num)->$type();
    }

    private function createModelWithState($class,$state,$type='create'){
        return factory($class)->state($state)->$type();
    }

    private function createManyModelsWithState($class,$state,$num,$type='create'){
        return factory($class)->state($state)->$type();
    }

}