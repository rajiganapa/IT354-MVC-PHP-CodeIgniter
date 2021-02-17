<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tasks extends CI_Controller
{
    public function display($task_id)
    {
        $data['project_id'] = $this->task_model->get_task_project_id($task_id);
        $data['project_name'] = $this->task_model->get_project_name($data['project_id']);

        $data['task'] = $this->task_model->get_task($task_id);
        $data['main_view'] = "tasks/display";
        $this->load->view('layouts/main', $data);
    }

    //1. Below function in this controller will be routed to tasks section in view and call create_tasks view pages
    //2. After getting information from the view, the tasks webpage will be displayed
    //3. Then it will post all the information that users enters into database table (tasks) through task_model

    public function create_tasks($project_id)
    {
        $this->form_validation->set_rules('task_name', 'Task Name', 'trim|required');
        $this->form_validation->set_rules('task_body', 'Task Description', 'trim|required');
        $this->form_validation->set_rules('due_date', 'Task DueDate', 'trim|required');

        if ($this->form_validation->run() == false) {
            $data['main_view'] = 'tasks/create_tasks';
            $this->load->view('layouts/main', $data);
        } else {
            $data = array(
                'project_id' => $project_id,
                'task_name' => $this->input->post('task_name'),
                'task_body' => $this->input->post('task_body'),
                'due_date' => $this->input->post('due_date')
                );

            if ($this->task_model->create_task($data)) {
                $this->session->set_flashdata('task_created', 'Your tasks has been created');

                redirect('projects/display/'.$project_id);
            }
        }
    }
    
    
    // your new methods go here
    
	
}
