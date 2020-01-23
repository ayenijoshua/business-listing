<?php
namespace App\Traits;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Log;

/**
 * A simple trait to help handling responses
 */
trait HelpsResponse {

    /**
     * Recieves an exception and logs it
     */
    public function errorLog(\Exception $ex): void {
        Log::info('Error Message -'.$ex->getMessage());
        Log::info('Error FIle -'.$ex->getFile());
        Log::info('Error Line -'.$ex->getLine());
        Log::info('Error Code -'.$ex->getcode());  
    }

    /**
     * get exception error
     * $msg - Exception message to show user
     */
    public function exceptionResponse($e,$msg='An error occured, please try again',$status_code=500){
        $this->errorLog($e);
        $ajax = response()->json([
            'message' => $msg,
            'success' => false
        ],$status_code);
        $non_ajax = back()->with('error',$msg)->withInput();
        return $this->checkAjax($ajax,$non_ajax);
    }

    /** check if request is an ajax request or not
     * $ajax - ajax request
     * $non_ajax - non aja request
     */
    public  function checkAjax($ajax,$non_ajax){
        if(Request::expectsJson()){
            return $ajax;
        }else{
            return $non_ajax;
        }
    }

    /**$v validator
     * get validation error
     */
    public function validationErrorResponse($v,$msg=null,$status_code=200){
        $ajax = response()->json([
            'message' => $v ? $v->messages()->all():$msg,
            'success' => false
        ],$status_code);
        $non_ajax = back()->withErrors($v?$v:$msg)->withInput();
        return $this->checkAjax($ajax,$non_ajax);
    }

    /**get response error
     * $msg - message to return
     * $v - validator
     */
    public function errorResponse($msg=null,$status_code=200){
        return $this->validationErrorResponse(null,$msg,$status_code);
    }

    /**
     * $msg - message to return with response
     * $resourse - resourse data to be returned with response
     * $resourse_name - name of resourse data to be returned with response
     * $redirect - redirect path (not needed if returning back)
     * 
     */
    public function successResponse($msg=null,$resourse=null,$resourse_name=null,$status_code=201,$redirect=null){
        $ajax = response()->json([
            'message' => $msg,
            $resourse_name??'data'=> $resourse,
            'success' => true
        ],$status_code);
        $non_ajax = $this->successMessage($msg,$redirect); //$redirect ? redirect($redirect)->withSuccess($msg) : back()->withSuccess($msg);
        return $this->checkAjax($ajax,$non_ajax);
    }

    /**returns a success message
     * $mgs - message to return
     * $redirect - redirect path
     */ 
    public function successMessage($msg,$redirect=null){
        return  $redirect ? redirect($redirect)->withSuccess($msg) : back()->withSuccess($msg);
    }

    /**
     * simple success response
     * may be useful for simple redirects
     * may be useful if you want to change the status code
     */
    public function simpleSuccessResponse($msg,$status_code=201,$redirect=null){
        return $this->successResponse($msg,$resourse=null,$resourse_name=null,$status_code,$redirect);
    }
}