<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Read extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->output->enable_profiler(FALSE);
    }

}