Load the model:
$this->load->model('master_model');

Set the table for the model
$this->master_model->initialize(array('table_name'=>'pages'));

Get all entries
$this->master_model->fetch_entries();

Get entry by id
$this->master_model->fetch_entries(array('id'=>1));


Insert entry
$entry = array(
	'title'		=> $this->input->post('title'),
	'body'		=> $this->input->post('body'),
	'url'		=> $this->input->post('url')
);


Update entry
$update = array(
	'id'		=> $this->input->post('id'),
	'body'		=> $this->input->post('body'),
	'url'		=> $this->input->post('url'),
	'title'		=> $this->input->post('title')
);
$this->master_model->update_entry($update);


Delete entry
$this->master_model->delete_entry($id);

