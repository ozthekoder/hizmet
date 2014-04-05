<?php
    
class Object 
{   
    public function __construct($nvp) 
    {
        foreach($nvp as $k => $v)
        {
            $this->$k = $v;
        }
    }
    
    public function save()
    {
        if(isset($this->id) && !empty($this->id))
        {
            if(EventManager::$db->update(get_class($this), (array)$this))
                return $this;
            else
                return false;
        }
        else
        {
            return EventManager::$db->insert(get_class($this), (array)$this);
        }
    }
    
    public function load()
    {
        $class = get_class($this);
        return EventManager::$db->select($class, (array)$this);
    }
}

?>
