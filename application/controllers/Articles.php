<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Articles extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model("posts_model");
    $this->load->library('form_validation');
  }
  
  public function index()
  {
    $data["articles"] = $this->posts_model->getAll();
    $this->load->view("/article/list", $data);
  }
  
  public function add()
  {
    $article = $this->posts_model;
    $validation = $this->form_validation;
    $validation->set_rules($article->rules());

    if ($validation->run()) {
      $article->save();
      $this->session->set_flashdata('success', 'Berhasil Tersimpan');
    }

    $this->load->view("/article/new_form");
  }
  
  public function edit($id = null)
  {
    if (!isset($id)) redirect('/articles');

    $article = $this->posts_model;
    $validation = $this->form_validation;
    $validation->set_rules($article->rules());

    if ($validation->run()) {
      $article->update();
      $this->session->set_flashdata('success', 'Berhasil Tersimpan');
    }

    $data["article"] = $article->getById($id);
    if (!$data["article"]) show_404();

    $this->load->view("/article/edit_form", $data);
  }
  
  public function delete($id = null)
  {
    if (!isset($id)) show_404();

    if ($this->posts_model->delte($id)) {
      redirect(site_url('/articles'));
    }
  }
}