<?php

defined('BASEPATH') or exit('No direct script access allowed');

class User extends App_Controller
{

     public function __construct()
     {
          parent::__construct();
          $this->load->model('user_model');
     }

     public function index()
     {

          if ($this->ion_auth->logged_in()) {
               redirect('dashboard');
          } else {
               redirect(strtolower(__CLASS__) . '/login');
          }
     }

     public function listuser()
     {
          $this->section = 'List users';
          $data['users'] = $this->ion_auth->get_all_users_with_group();
          $this->render_page(strtolower(__CLASS__) . '/index', $data);
     }

     public function login()
     {

          if ($this->ion_auth->logged_in()) {
               redirect('dashboard');
          }

          $this->template->set_layout('login');
          $this->page_title = 'Royaldrive | RDportal Login';

          $this->current_section = 'login';

          // validate form input
          $this->form_validation->set_rules('identity', 'Email', 'required');
          $this->form_validation->set_rules('password', 'Password', 'required');

          if ($this->form_validation->run() == true) {
               // check to see if the user is logging in
               // check for "remember me"
               $remember = (bool) $this->input->post('remember');

               if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember)) {

                    generate_log(array(
                         'log_title' => 'login',
                         'log_desc' => serialize($_POST),
                         'log_controller' => 'staff-login',
                         'log_action' => 'R',
                         'log_ref_id' => 101,
                         'log_added_by' => 0
                    ));
                    $this->session->set_flashdata('app_success', $this->ion_auth->messages());
                    redirect('dashboard');
               } else {
                    $this->session->set_flashdata('app_error', $this->ion_auth->errors());
                    redirect('user/login');
               }
          } else {
               // the user is not logging in so display the login page
               // set the flash data error message if there is one
               $data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

               $data['identity'] = array(
                    'name' => 'identity',
                    'id' => 'identity',
                    'type' => 'text',
                    'value' => $this->form_validation->set_value('identity'),
                    'class' => 'form-control',
                    'placeholder' => 'Username'
               );
               $data['password'] = array(
                    'name' => 'password',
                    'id' => 'password',
                    'type' => 'password',
                    'class' => 'form-control',
                    'placeholder' => 'Password'
               );

               $this->render_page('user/login', $data);
          }
     }

     public function logout()
     {
          // log the user out
          $logout = $this->ion_auth->logout();
          // redirect them back to the login page
          redirect(strtolower(__CLASS__) . '/login');
     }

     public function forgot_password()
     {
          if ($this->form_validation->run('user_forgot_password')) {
               $forgotten = $this->ion_auth->forgotten_password($this->input->post('email', TRUE));

               if ($forgotten) {
                    // if there were no errors
                    $this->session->set_flashdata('app_success', $this->ion_auth->messages());
                    redirect('login');
               } else {
                    $this->session->set_flashdata('app_error', $this->ion_auth->errors());
                    redirect('login');
               }
          }

          $this->body_class[] = 'forgot_password';

          $this->page_title = 'Forgot password';

          $this->current_section = 'forgot_password';

          $this->render_page('user/forgot_password');
     }

     public function account()
     {
          $this->body_class[] = 'my_account';

          $this->page_title = 'My Account';

          $this->current_section = 'my_account';

          $user = $this->ion_auth->user()->row_array();

          $this->render_page('user/account', array('user' => $user));
     }

     function change_password()
     {

          $this->section = 'Change Password';
          $this->body_class[] = 'skin-blue';
          $this->form_validation->set_rules('old', $this->lang->line('change_password_validation_old_password_label'), 'required');
          $this->form_validation->set_rules('new', $this->lang->line('change_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
          $this->form_validation->set_rules('new_confirm', $this->lang->line('change_password_validation_new_password_confirm_label'), 'required');

          if (!$this->ion_auth->logged_in()) {
               redirect('user/login', 'refresh');
          }

          $user = $this->ion_auth->user()->row();

          if ($this->form_validation->run() == false) {
               //set the flash data error message if there is one
               $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
               $this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
               $uname = isset($this->ion_auth->user()->row()->username) ? $this->ion_auth->user()->row()->username : '';
               $this->data['username'] = array(
                    'name' => 'uname',
                    'id' => 'uname',
                    'type' => 'test',
                    'class' => 'input-xxlarge',
                    'value' => $uname
               );
               $this->data['old_password'] = array(
                    'name' => 'old',
                    'id' => 'old',
                    'type' => 'password',
                    'class' => 'input-xxlarge'
               );
               $this->data['new_password'] = array(
                    'name' => 'new',
                    'id' => 'new',
                    'type' => 'password',
                    'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
                    'class' => 'input-xxlarge'
               );
               $this->data['new_password_confirm'] = array(
                    'name' => 'new_confirm',
                    'id' => 'new_confirm',
                    'type' => 'password',
                    'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
                    'class' => 'input-xxlarge'
               );
               $this->data['user_id'] = array(
                    'name' => 'user_id',
                    'id' => 'user_id',
                    'type' => 'hidden',
                    'value' => $user->id,
               );

               //render
               $this->render_page('user/change_password', $this->data);
               //$this->render_page('user/login', $data);
          } else {

               $identity = $this->session->userdata($this->config->item('identity', 'ion_auth'));

               $change = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'), $this->input->post('uname'));

               if ($change) {
                    //if the password was successfully changed
                    $this->session->set_flashdata('app_success', $this->ion_auth->messages());
                    $this->logout();
               } else {
                    $this->session->set_flashdata('app_error', $this->ion_auth->errors());
                    redirect('user/change_password', 'refresh');
               }
          }
     }

     function add()
     {
          $this->section = 'New User';
          $this->render_page('user/add');
     }

     function insert()
     {
          if (isset($_FILES['avatar']['name']) && !empty($_FILES['avatar']['name'])) {
               $this->load->library('upload');
               $newFileName = rand(9999999, 0) . $_FILES['avatar']['name'];
               $config['upload_path'] = '../assets/uploads/avatar/';
               $config['allowed_types'] = 'gif|jpg|png';
               $config['file_name'] = $newFileName;
               $this->upload->initialize($config);

               $angle['x1']['0'] = $_POST['x1'];
               $angle['x2']['0'] = $_POST['x2'];
               $angle['y1']['0'] = $_POST['y1'];
               $angle['y2']['0'] = $_POST['y2'];
               $angle['w']['0'] = $_POST['w'];
               $angle['h']['0'] = $_POST['h'];

               if ($this->upload->do_upload('avatar')) {
                    $data = $this->upload->data();
                    crop($this->upload->data(), $angle);
                    $_POST['user']['avatar'] = $data['file_name'];
               }
          }
          $username = $_POST['user']['username'];
          $password = trim($_POST['user']['password']);
          $email = $_POST['user']['email'];

          unset($_POST['user']['password_confirm']);
          unset($_POST['user']['username']);
          unset($_POST['user']['password']);
          unset($_POST['user']['email']);

          $this->ion_auth->register($username, $password, $email, $_POST['user']);
          $this->session->set_flashdata('app_success', 'User successfully created!');
          redirect(strtolower(__CLASS__) . '/listuser');
     }

     function update()
     {

          if (isset($_POST['user_id']) && !empty($_POST['user_id'])) {
               if (isset($_FILES['avatar']['name']) && !empty($_FILES['avatar']['name'])) {

                    $this->load->library('upload');
                    $newFileName = rand(9999999, 0) . $_FILES['avatar']['name'];
                    $config['upload_path'] = '../assets/uploads/avatar/';
                    $config['allowed_types'] = 'gif|jpg|png';
                    $config['file_name'] = $newFileName;
                    $this->upload->initialize($config);

                    $angle['x1']['0'] = $_POST['x1'];
                    $angle['x2']['0'] = $_POST['x2'];
                    $angle['y1']['0'] = $_POST['y1'];
                    $angle['y2']['0'] = $_POST['y2'];
                    $angle['w']['0'] = $_POST['w'];
                    $angle['h']['0'] = $_POST['h'];

                    if ($this->upload->do_upload('avatar')) {
                         $data = $this->upload->data();
                         crop($this->upload->data(), $angle);
                         $_POST['user']['avatar'] = $data['file_name'];
                    }
               }
               $this->ion_auth->update($_POST['user_id'], $_POST['user']);
               $this->session->set_flashdata('app_success', 'User successfully updated!');
               redirect(strtolower(__CLASS__) . '/listuser');
          }
     }

     function checkEmailExists()
     {
          $email = isset($_POST['user']['email']) ? $_POST['user']['email'] : '';
          $id = isset($_POST['id']) ? $_POST['id'] : '';
          echo ($this->ion_auth->email_check($email, $id)) ? 'false' : 'true';
     }

     function checkUsernameExists()
     {
          $username = isset($_POST['user']['username']) ? $_POST['user']['username'] : '';
          $id = isset($_POST['id']) ? $_POST['id'] : '';
          echo ($this->ion_auth->username_check($username, $id)) ? 'false' : 'true';
     }

     function delete($id)
     {
          if ($this->ion_auth->delete_user($id)) {
               echo json_encode(array('status' => 'success', 'msg' => 'User successfully deleted'));
          } else {
               echo json_encode(array('status' => 'fail', 'msg' => "Can't delete user"));
          }
     }

     function view_user($id)
     {
          $this->section = "Edit user";
          $this->data['userDetails'] = $this->ion_auth->user($id)->row_array();
          $this->render_page(strtolower(__CLASS__) . '/edit', $this->data);
     }

     function removeImage($id)
     {
          if ($this->ion_auth->removeAvatar($id)) {
               echo json_encode(array('status' => 'success', 'msg' => 'Avatar successfully deleted'));
          } else {
               echo json_encode(array('status' => 'fail', 'msg' => "Can't delete brand avatar"));
          }
     }
}
