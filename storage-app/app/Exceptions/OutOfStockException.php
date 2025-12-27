<?php

namespace App\Exceptions;

use Exception;

class OutOfStockException extends Exception
{
    public function render()
    {
        return response()->json(['message' => $this->getMessage()], 422);
    }
}
