<?php

namespace Ext\DirectBundle\Router;

/**
 * @author Semyon Velichko <semyon@velichko.net>
 */
class CallForm extends Call
{
    
    /**
     * Initialize the call properties from a form call.
     * 
     * @param array $call
     */
    public function initialize($call)
    {
        foreach(array('action' => 'extAction',
                      'method' => 'extMethod',
                      'type' => 'extType',
                      'tid' => 'extTID',
                      'upload' => 'extUpload') as $key => $value)
        {
            if(!isset($call[$value]))
                throw new \Ext\DirectBundle\Exception\InvalidJsonException(sprintf('%s key does not exist', $value));
            
            $this->$key = $call[$value];
            unset($call[$value]);
        }
        
        foreach ($call as $key => $value) {
            $this->data[$key] = $value;
        }
    }
    
}
