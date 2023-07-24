<?php
class Login_model extends CI_Model
{
    function can_login($email, $password)
    {
        $this->db->where('email', $email);
        $this->db->or_where('user_name', $email);
        $query = $this->db->get('user');
 
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                
                if ($row->is_email_verified == 'yes') {
                    $store_password = $this->encrypt->decode($row->password);
                    if ($password == $store_password) {
                        $this->session->set_userdata('id', $row->id);
                        $this->session->set_userdata('user_name', $row->user_name);
                    } else {
                        return 'Wrong Password';
                    }
                } else {
                    return 'First verified your email address';
                }
            }
        } else {
            return 'Wrong Email Address';
        }
    }
}

?>