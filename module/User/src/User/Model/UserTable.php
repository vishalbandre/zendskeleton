<?php
namespace User\Model;
use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Where;
//use Zend\Db\TableGateway\TableGateway;

class UserTable extends AbstractTableGateway
{
    protected $table = 'user';
    protected $id = 'id';
    
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->initialize();
    }
    
    public function getDataX() {
        $stmt = $this->adapter->createStatement('SELECT * FROM ' . $this->table);
        $stmt->prepare();
        $result = $stmt->execute();

        if ($result instanceof ResultInterface && $result->isQueryResult()) {
            $resultSet = new ResultSet;
            $resultSet->initialize($result);
        }
        
        return $resultSet;
    }
    
    public function getData() {
        $sql = new Sql($this->adapter);
        $select = $sql->select();
        $select->from($this->table);
        $select->order("id DESC");
//               ->join('album', 'tracks.album_id = album.id');

//        $where = new  Where();
//        $where->equalTo($this->id, $id) ;
//        $select->where($where);

        //you can check your query by echo-ing :
       // echo $select->getSqlString();
        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();

        if ($result instanceof ResultInterface && $result->isQueryResult()) {
            $resultSet = new ResultSet;
            $resultSet->initialize($result);
        }
        
        return $resultSet;
        
        return $result;
    }
    
    /*
     * Get user data by primary key
     * @param int $id. user id
     * @return object 
     */
    public function getDataById($id = null) {
        if(empty($id)) {
            return null;
        }
        $id = (int) $id;
        $sql = new Sql($this->adapter);
        $select = $sql->select();
        $select->from($this->table);
        $select->order("id DESC");
//               ->join('album', 'tracks.album_id = album.id');

        $where = new  Where();
        $where->equalTo($this->id, $id) ;
        $select->where($where);
        
        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();

        if ($result instanceof ResultInterface && $result->isQueryResult()) {
            $resultSet = new ResultSet;
            $resultSet->initialize($result);
        }
        return $resultSet;
    }
    
    /*
     * Get user data by columns
     * @param array $columns[column_name] = value
     * @return object
     */
    public function getDataBy($columns = array()) {
        if(empty($columns)) {
            return null;
        }
        if(!is_array($columns)) {
            $columns = array($columns);
        }
        
        $sql = new Sql($this->adapter);
        $select = $sql->select();
        $select->from($this->table);
        $select->order("id DESC");
//               ->join('album', 'tracks.album_id = album.id');

        $where = new  Where();
        foreach($columns as $key => $value) {
            $where->equalTo($key, $value);
        }
        $select->where($where);
        
        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();

        if ($result instanceof ResultInterface && $result->isQueryResult()) {
            $resultSet = new ResultSet;
            $resultSet->initialize($result);
        }
        return $resultSet;
    }
}
