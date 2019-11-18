<?php

require 'MysqlAdapter.php';
require 'database_config.php';


class User extends MysqlAdapter
{
    //Set the table name
    private $_table='user';
    public function __construct()
    {
        global $config;

        //call the parent constructor
        parent::__construct($config);


    }
    /**
     * List all user 
     * @return array returns every user row as array of assocative array
     */

     public function getUsers()
     {
         $this->select($this->_table);
         return $this->fetchAll();
     }

     /**
      * show one user
      *@param int $user_id 
      */


      public function getUser($user_id)
      {
          $this->select($this->_table,'id ='.$user_id);
          return $this->fetch();
      }

      /**
       * add user 
       */

       public function addUser($user_data)
       {
           return $this->insert($this->_table,$user_data);
       }

       /**
        * update existing user
        */

        public function updateUSer($user_data,$user_id)
        {
            return $this->update($this->_table,$user_data,'id ='.$user_id);
        }


        /**
         * delete user
         */

         public function deleteUser($user_id)
         {
             return $this->delete($this->_table,'id='.$user_id);
         }

         /**
          * 
          */



}