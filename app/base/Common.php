<?php

namespace Reserving\base;

class Common
{
    protected $timeFormat;
    protected $branch_option;
    protected $time_slots;

    public function get_time_format()
    {
        $this->timeFormat = reserving_setting_option('reserving_time_format', '12hours');
        return $this->timeFormat;
    }

    public function get_branch_option()
    {
        $this->branch_option = reserving_setting_option('reserving_branch_option', 'multi_branch');
        return $this->branch_option;
    }

    public function get_time_slots()
    {
        $opening_time     = reserving_setting_option('reserving_opening_time', '09:00');
        $closing_time     = reserving_setting_option('reserving_closing_time', '11:00');
        $this->time_slots = reservingCreateTimeSlots($opening_time, $closing_time, "60");
        return $this->time_slots;
    }
}
