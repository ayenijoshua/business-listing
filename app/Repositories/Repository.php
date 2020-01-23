<?php
namespace App\Repositories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Repository implements RepositoryInterface {

    protected $model;

    function __construct(Model $model){
        $this->model = $model;
    }
    
    public function create(array $data){
       return $this->model->create($data);
    }

    public function all(){
        return $this->model->all();
    }

    public function get($id){
        return $this->model->find($id);
    }

    public function update($id,$data){
       return $this->get($id)->update($data);
    }

    public function delete($id){
        return $this->model->destroy($id);
    }

    /**
     * get model instance
     */
    public function getModel(){
        return $this->model;
    }

    /**
     * set model instance
     */
    public function setModel($model){
        return $this->model = $model;
    }

    /**
     * eager load relations
     * $relations - array of relations
     */
    public function with($relations){
        return $this->model->with($relations);
    }

    /**
     * checks if model has relationships and notifies the user to dessociate before delete
     * especially in hasMany/belongsTo relationship
     * $model - model instance
     * $relations - array of model's relations
     */
    public function isRelatedTo(Model $model, array $relations){ // if model hasMany relations
        $relation_array = [];
        foreach($relations as $relation){
            if($model->$relation->count() > 0){
                array_push($relation_array,$relation);
            }
        }
        if( count($relation_array) > 0 ){
            return implode(',',$relation_array);
        }
        return false;
    }

    /**
     * detaches belongsToMany model relations during delete
     * $model - model in use
     * $relationships - array of relations
     */
    public function detachRelations(Model $model, array $relationships){
        foreach($relationships as $relations){
            //check if model has relations
            if($model_relations = $model->$relations){
                foreach($model_relations as $relation){
                    //detach the model from the relations
                    $model->relations->detach($relation);
                }
            }
        }
    }

    /**
     * check if value exists in model's table
     * $column - column in the table
     * $value - value to check for
     */
    public function valueExists($column,$value,$id=null){
        $old_value = $this->getModel()->where($column,$value)->whereNotIn('id',[$id])->first();
        if($old_value){
            return true;
        }
        return false;
     }

    //  public function valueExistsExcept($column,$value){
    //     $old_value = $this->getModel()->where($column,$value)->where('id',)first();
    //     if($old_value){
    //         return true;
    //     }
    //     return false;
    //  }

     /**
     * remove duplicate ids from the request
     * this is useful when attaching in many-to-many relationships, so you could 
     * remove ids that already exists in the db from the request and return the rest
     * $model - model instance
     * $relation - static model relationship
     * $id - array of id | any other variable you want to detach
     */
    public function removeDuplicateRelations(Model $model,$relation,$ids){
        $collection = collect($ids); $idExists = [];
        //dd($collection);
        foreach($collection->all() as $key=>$val){
            if($model->$relation->contains($val)){
                array_push($idExists,$key);
            }
        }
        return $collection->except($idExists);
    }

    /**
     * set unique value
     * $num - length of value
     * $column - coulumn name
     */
    public function setUniqueValue($column,$num=7){
        $val = Str::random($num);
        $old_val = $this->getModel()->where($column,$val)->first();
        if($old_val){
            $this->setUniqueValue($num,$column);
        }
        return $val;
    }
}