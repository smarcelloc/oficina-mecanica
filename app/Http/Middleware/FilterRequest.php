<?php

namespace App\Http\Middleware;

use Closure;

class FilterRequest
{

    private $path = [
        'clients', 'providers', 'orders',
        'products', 'vehicles', 'users'
    ];


    private $number = [
        'cpf', 'cnpj', 'phone', 'address_number',
        'cep', 'amount'
    ];


    private $alphanum = [
        'plate'
    ];




    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->pathVerify($request)) {
            $postData = $request->input();
            $this->attrNumber($postData);
            $this->attrAlphaNumber($postData);
            $request->merge($postData);
        }
        return $next($request);
    }


    /******   Path Verificar   ******/
    private function pathVerify($request)
    {
        $arrayRequestPath = explode('/', $request->path());
        $pathSave = $arrayRequestPath[2];
        $pathMain = $arrayRequestPath[1];

        if ($pathSave == 'add-save' || $pathSave == 'edit-save')
            return in_array($pathMain, $this->path);
        else
            return false;
    }




    private function attrNumber(array &$postData)
    {
        foreach ($postData as $key => $value) {
            if (in_array($key, $this->number)){
                $postData[$key] = preg_replace('/[^0-9]/', '', $value);
            }
        }
    }



    private function attrAlphaNumber(array &$postData)
    {
        foreach ($postData as $key => $value) {
            if (in_array($key, $this->alphanum)){
                $upperLetters = mb_convert_case($value, MB_CASE_UPPER);
                $postData[$key] = preg_replace('/[^0-9A-Z]/', '', $upperLetters);
            }
        }
    }




}
