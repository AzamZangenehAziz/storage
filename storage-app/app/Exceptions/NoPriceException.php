<?php

namespace App\Exceptions;

use Exception;

class NoPriceException extends Exception
{
    public function render(){
        return response()->json(['message' => $this->getMessage()], 400);
    }
}
