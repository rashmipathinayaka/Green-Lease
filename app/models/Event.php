<?php
class Event
{
    use Model;

    protected $table = 'event';

    public function getAvailableEvents()
    {
        return $this->query("SELECT * FROM event WHERE status = 'Available'");
    }
}
