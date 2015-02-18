<?php

/**
 * Display one or all of the quotes on file.
 * 
 * controllers/Viewer.php
 *
 * ------------------------------------------------------------------------
 */
class Viewer extends Application {

    function __construct()
    {
	parent::__construct();
    }

    //-------------------------------------------------------------
    //  The normal pages
    //-------------------------------------------------------------

    function index()
    {
	$this->data['pagebody'] = 'homepage';    // this is the view we want shown
	$this->data['authors'] = $this->quotes->all();
	$this->render();
    }

    // method to display just a single quote
    function quote($id)
    {
        $quote = $this->quotes->get($id);
        $this->data['average'] = 
            ($quote->vote_count > 0) ? 
                ($quote->vote_total / $quote->vote_count) : 0;
        
	$this->data['pagebody'] = 'justone';    // this is the view we want shown
	$this->caboose->needed('jrating', 'hollywood');
        $this->data = array_merge($this->data, (array) $quote);
	$this->render();
    }

    function rate()
    {
        if (!isset($_POST['action']))
            redirect("/");
        
        $id = intval($_POST['idBox']);
        $rate = intval($_POST['rate']);
        
        $record = $this->quotes->get($id);
        if ($record != null)
        {
            $record->vote_total += $rate;
            $record->vote_count++;
            $this->quotes->update($record);
        }
        
        $response = 'Thanks for voting!';
        echo json_encode($response);
    }
}

/* End of file Welcome.php */
/* Location: application/controllers/Welcome.php */