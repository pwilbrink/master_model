<?php
class master_model extends CI_Model {

    var $table_name = 'pages';

    function __construct()
    {
        parent::__construct();
    }
    function initialize($params = array()){
        $qualifiers = array('table_name');
        foreach($qualifiers as $qualifier):
            if(isset($params[$qualifier])):
                $this->$qualifier = $params[$qualifier];
            endif;
        endforeach;
    }
    function insert_entry($entry){
        $qualifiers = array('url','title','body');
        foreach($qualifiers as $qualifier):
            if(isset($entry[$qualifier])):
                $this->$qualifier = $entry[$qualifier];
            endif;
        endforeach;

        $this->created          = date('Y-m-d H:i:s',now());
        $this->modified         = date('Y-m-d H:i:s',now());
     
        if($this->db->insert($this->table_name, $this)):
            return $this->db->insert_id(); 
        else:
            return false;
        endif; 
    }

    function fetch_entries($options = array()){
        $qualifiers = array('id','url','title');
        foreach($qualifiers as $qualifier):
            if(isset($options[$qualifier])):
                $this->db->where($qualifier,$options[$qualifier]);
            endif;
        endforeach;

        if(isset($options['limit'])):
            if(isset($options['offset'])):
                $this->db->limit($options['offset'],$options['limit']);
            else:
                $this->db->limit($options['limit']);
            endif;
        endif;

        $q = $this->db->get($this->table_name);
        if($q->num_rows() > 0){
            $data = $q->result_array();
            if(isset($options['id']) || isset($options['url'])):
                return $data[0];
            else:
                return $data;
            endif;
        }else{
            return false;
        }
    }
    function update_entry($options = array()){
        if(!isset($options['id'])):
            return false;
        endif;
        $qualifiers = array('url','title','body');
        foreach($qualifiers as $qualifier):
            if(isset($options[$qualifier])):
                $this->db->set($qualifier,$options[$qualifier]);
            endif;
        endforeach;
        $this->load->helper('date');
        $this->db->set('modified',date("Y-m-d H:i:s",now()));
        $this->db->where('id',$options['id']);
        $this->db->update($this->table_name);
    }
    function delete_entry($id = null){
        if(!$id):
            return false;
        endif;
        if(!$entry = $this->fetch_entries(array('id'=>$id))):
            return false;
        endif;
        $this->db->where('id',$entry['id']);
        $this->db->delete($this->table_name);
    }
}
?>