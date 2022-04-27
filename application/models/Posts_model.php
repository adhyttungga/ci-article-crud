<?php 

defined('BASEPATH') OR  exit('No direct script access allowed');

class Posts_model extends CI_Model
{
  private $_table = "posts";

  public $id;
  public $title;
  public $content;
  public $category;
  public $status;

  const PUBLISH = 'publish';
  const DRAFT = 'draft';
  const THRASH = 'thrash';

  public function rules() 
  {
    return [
      ['field'=>'title',
      'label'=>'Title',
      'rules'=>'required|min:20'],
      
      ['field'=>'content',
      'label'=>'Content',
      'rules'=>'required|min:200'],
      
      ['field'=>'category',
      'label'=>'Category',
      'rules'=>'required|min:3'],

      ['field'=>'status',
      'label'=>'Status',
      'rules'=>'required|in:' . self::PUBLISH . ',' . self::DRAFT . ',' . self::THRASH . '']
    ];
  }

  public function saveArticle()
  {
    $post = $this->input->post();
    $this->id = uniqid();
    $this->title = $post["title"];
    $this->content = $post["content"];
    $this->category = $post["category"];
    $this->status = $post["status"];
    return $this->db->update($this->_table, $this);
  }

  public function getAll()
  {
    return $this->db->get($this->_table)->result();
  }
  
  public function getById($id)
  {
    return $this->db->get_where($this->_table, ["id"=> $id])->row();
  }

  public function update()
  {
    $post = $this->input->post();
    $this->id = $post["id"];
    $this->title = $post["title"];
    $this->content = $post["content"];
    $this->category = $post["category"];
    $this->status = $post["status"];
    return $this->db->update($this->_table, $this, array('id'=>$post['id']));
  }

  public function delete($id)
  {
    return $this->db->delete($this->_table, array("id" => $id));
  }
}


