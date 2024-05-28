<?php

namespace App\Services;

use Illuminate\Http\Request;

class ApiFilter 
{
    protected $safeParms = [];
    protected $columnMap = [];
    protected $operatorMap = [];
    function transform(Request $request)
    {
        $eloRequest = [];
        foreach ($this->safeParms as $param => $operators) {
            $query = $request->query($param);
            if (!isset($query)) {
                continue;
            }

            $column =  $this->columnMap[$param] ?? $param;
            
            foreach ($operators as $operator) {
                if (isset($query[$operator])) {
                    $eloRequest[] = [$column, $this->operatorMap[$operator], $query[$operator]];
                }
            }
        }
        return $eloRequest;
    }
}
