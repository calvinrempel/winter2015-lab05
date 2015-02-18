<?php

/**
 * Our Admin Panel. Show the most recently added quote.
 * 
 * controllers/Admin.php
 *
 * ------------------------------------------------------------------------
 */
class Admin extends Application {

    function __construct()
    {
	parent::__construct();
    }

    //-------------------------------------------------------------
    //  The normal pages
    //-------------------------------------------------------------

    function index()
    {
        $this->data['title'] = 'Quotations Maintenance';
        $this->data['quotes'] = $this->quotes->all();
	$this->data['pagebody'] = 'admin_list';
	$this->render();
    }

    function add()
    {
        $quote = $this->quotes->create();
        $this->present($quote);
    }
    
    function present($quote)
    {
        $this->data['fid'] = makeTextField('ID#', 'id', $quote->id);
        $this->data['fwho'] = makeTextField('Author', 'who', $quote->who);
        $this->data['fmug'] = makeTextField('Picture', 'mug', $quote->mug);
        $this->data['fwhat'] = makeTextArea('The Quote', 'what', $quote->what);
        $this->data['pagebody'] = 'quote_edit';
        $this->render();
    }
}

/* End of file Welcome.php */
/* Location: application/controllers/Welcome.php */