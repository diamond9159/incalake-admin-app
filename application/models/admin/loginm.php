<?php
Class Loginm extends CI_Model
{
 function buscar($username, $password)
 {
   $this -> db -> select('*');
   $this -> db -> from('usuarios');
   $this -> db -> where('username_usuarios', $username);
   $this -> db -> where('password_usuarios', md5($password));
   $this -> db -> limit(1);
 
   $query = $this -> db -> get();
 
   if($query -> num_rows() == 1)
   {
     return $query->result();
   }
   else
   {
     return false;
   }
 }
}
?>