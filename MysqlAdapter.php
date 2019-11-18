<?php

class MysqlAdapter
{
    protected $_config=array();
    protected $_link;
    protected $_result;


    /**\
     * Constructor
     */
    public function __construct(array $config)
    {
        if (count($config)!==4)
        {
            throw new InvalidArgumentException('Invalid number of connection parameter');
        }
        $this->_config=$config;
    }

    /**
     * Connect to Mysql
     * 
     * Single Tone desgin pattern
     */
    public function connect()
    {
        if($this->link===null)
        {
            list($host,$user,$password,$database)=$this->_config;
            if(!$this->link=@mysqli_connect($host,$user,$password,$database))
            {
                throw new RuntimeException('Error connecting to server:'.mysqli_connect_error());

            }
            unset($host,$user,$password,$database);
        }
        return $this->_link;
    }
    /**
     * Excute the specefic query
     * 
     */

     public function query($query)
     {
         if(!is_string($query)||empty($query))
         {
             throw new InvalidArgumentException('The specified query is not valid');
         }
         $this->connect();
         if(!$this->result=mysqli_query($this->_link,$query))
         {
             throw new RuntimeException('Eror executing the spaceific query'.$query.mysqli_error($this->_link));

         }
         return $this->_result;
     }

     /**
      * Perferom an SELECT Statements
      */

      public function select($table, $where='',$fields='*',$order='',$limit=null,$offset=null)
      {
          $query='SELECT'.$field. 'FROM' .$table
                  .(($where)?'WHERE'.$where:'')
                  .(($limit)?'LIMIT'.$limit:'')
                  .(($offset && $limit)?'OFFSET'.$offset:'')
                  .(($order)?'ORDER BY'.$order:'');
                  $this->query($query);
                  return $this->countRows();


      }


      /**
       * Perform INSERT STATEMENTS
       */

       public function insert($table,array $data)
       {
           $fields=implode(',',array_key($data));
           $values=implode(',',array_map(array($this,'quoteValue'),array_values($data)));
           $query='INSERT INTO '.$table.' ('.$fields.')'. 'VALUES('.$values.')';
           $this->query($query);
           return $this->getInsertId();

       }


       /**
        * PERFORM an UPDATE STATMENTS
        */


        /**
         * Escape the specified value
         */

         public function update($table,array $data,$where='')
         {
             $set=array();
             foreach($data as $field=>$value)
             {
                 $set[]=$field.'='.$this->quoteValue($value);
             }
             $set =implode(',',$set);
             $query='UPDATE ' .$table. 'SET' .$set. (($where) ? 'WHERE' .$where:'');
             $this->query($query);
             return $this->getAffectedRows();
         }

         /**
          * Perform Delete Statment
          */

          public function delete($table,$where='')
          {
              $query='DELETE FROM' .$table
                      .(($where)? 'WHERE' .$where:'');
                      $this->query($query);
                      return $this->getAffectedRows();
          }

          /**
           * 
           * Escape the specified value
           */


        public function quoteValue($value)
        {
            $this->connect();
            if($value===null)
            {
                $value='NULL';
            }
            elseif(!is_numeric($value))
            {
                $value="'".mysqli_real_escape_string($this->_link,$value). "'";
            }
            return $value;

        }


        /**
         *fetch a single row from the current result set as assocative array
         */

         public function fetch()
         {
             if ($this->_result!==null)
             {
                 if(($row=mysqli_fetch_array($this->_result,MYSQL_ASSOC))===false)
                 {
                     $this->freeResult();
                 }
                 return $row;
             }
             return false;
         }

         /**
          * Fetch all rows from the current result set as an associative array
          */

          public function fetchAll()
          {
            if ($this->_result!==null)
            {
                if(($all=mysqli_fetch_all($this->_result,MYSQL_ASSOC))===false)
                {
                    $this->freeResult();
                }
                return $all;
            }
            return false;
          }



          /**
           *Get The insertion Id 
           */

           public function getinsertId()
           {
               return $this->_link!==null?mysqli_insert_id($this->_link):null;
           }


           /**
            * get the number of rows returned by the current result set
            */
            public function countRows()
            {
                return $this->_result!==null?mysqli_num_rows($this->_result):0;
            }

            /**
             * get the number  of affected rows
             */

             public function getAffectedRows()
             {
                 return $this->_link !==null?mysqli_affected_rows($this->_link):0;
             }

             /**
              * Free up the curent result

              */
             public function freeResult()
              {
                  if($this->_result===null)
                  {
                      return false;
                  }
                  mysqli_free_result($this->_result);
                  return true;
              }

              /**
               * Close explicity the database connection
               */
              public function disconnect()
              {
                  if($this->_link===null)
                  {
                      return false;
                  }
                  mysqli_close($this->_link);
                  $this->_link=null;
                  return true;
              }

              /**
               * close automatically the database connection when the insatnce of class is destoryed
               */

               public function __destruct()
               {
                   $this->disconnect();
               }








}