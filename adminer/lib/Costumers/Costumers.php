<?php
class Costumers
{
    /**
     *
     */
    public function __construct()
    {
    }

    /**
     *
     */
    public function __destruct()
    {
    }
    
    /**
     * Set friendly columns\' names to order tables\' entries
     */
    public function setOrderingValues()
    {
        $ordering = [
            'id' => 'ID',
            'name' => 'Name',
            'gender' => 'Gender',
            'phone' => 'Phone',
            'email' => 'Email',
            'last_login' => 'Last Login'
        ];

        return $ordering;
    }
}
?>
