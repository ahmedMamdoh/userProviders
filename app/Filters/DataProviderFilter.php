<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class DataProviderFilter extends Filters
{
    /**
     * Filter data by provider.
     *
     * @param string $value
     *
     * @return Builder
     */
    public function provider($value)
    {   
        return $this->query->where('provider', $value);
    }

    /**
     * Filter data by currency.
     *
     * @param string $value
     *
     * @return Builder
     */
    public function currency($value)
    {   
        return $this->query->where('currency',$value);
    }
    /**
     * Filter data by status code.
     *
     * @param string $value
     *
     * @return Builder
     */
    public function statusCode($value)
    {    
        if($value == 'authorised')
        return $this->query->where('status',1)->orWhere('status',100);
        if($value == 'decline')
        return $this->query->where('status',2)->orWhere('status',200);    
        if($value == 'refunded')
        return $this->query->where('status',3)->orWhere('status',300);    
     
        return $this->query->where('status',$value);
      
    }
  /**
     * Filter data by min balance.
     *
     * @param string $value
     *
     * @return Builder
     */
    public function balanceMin($value)
    {    
       
        return $this->query->where('balance','>=',$value);
    }
    /**
     * Filter data by max balance.
     *
     * @param string $value
     *
     * @return Builder
     */
    public function balanceMax($value)
    {    
        return $this->query->where('balance','<=',$value);
    }
}