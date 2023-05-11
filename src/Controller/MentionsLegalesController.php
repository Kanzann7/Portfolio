<?php

namespace App\Controller;

class MentionsLegalesController
{
    function index()
    {
        $template = "mentionsLegales";
        include TEMPLATE_DIR . '/base.phtml';
    }
}
