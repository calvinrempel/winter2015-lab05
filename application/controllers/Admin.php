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
        $this->load->helper('formfields');
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
    
    function confirm()
    {
        $record = $this->quotes->create();
        
        // Get Input
        $record->id = $this->input->post('id');
        $record->who = $this->input->post('who');
        $record->mug = $this->input->post('mug');
        $record->what = $this->input->post('what');
        
        // Error Check
        if (empty($record->who))
            $this->errors[] = 'You must specify an author.';
        if (strlen($record->what) < 20)
            $this->errors[] = 'A quotation must be at least 20 characters long.';
        
        // Redisplay if errors were found
        if (count($this->errors) > 0)
        {
            $this->present($record);
        }
        else
        {
            // Save the Quote
            if (empty($record->id))
                $this->quotes->add($record);
            else
                $this->quotes->update($record);

            redirect('/admin');
        }
    }
    
    function present($quote)
    {
        // Create Error Message Output
        $message = '';
        if (count($this->errors) > 0)
        {
            foreach($this->errors as $error)
            {
                $message .= $error . BR;
            }
        }
        $this->data['message'] = $message;
        
        // Create Form
        $this->data['fid'] = makeTextField('ID#',
                                           'id',
                                           $quote->id,
                                           "Unique quote identifier,system-assigned",
                                           10,
                                           10,
                                           true);
        $this->data['fwho'] = makeTextField('Author', 'who', $quote->who);
        $this->data['fmug'] = makeTextField('Picture', 'mug', $quote->mug);
        $this->data['fwhat'] = makeTextArea('The Quote', 'what', $quote->what);
        $this->data['pagebody'] = 'quote_edit';
        $this->data['fsubmit'] = makeSubmitButton('Process Quote', "Click to valitate data", 'btn-success');
        $this->render();
    }
}

/* End of file Welcome.php */
/* Location: application/controllers/Welcome.php */