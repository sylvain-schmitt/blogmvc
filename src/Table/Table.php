<?php
namespace App\Table;

use PDO;
use App\Table\Exception\NotFoundException;
use Exception;

abstract class Table{

    protected $pdo;
    protected $table = null;
    protected $class = null;

    /**
     *Constructeur de la classe Table
     * @param \Pdo $pdo
     */
    public function __construct(Pdo $pdo)
    {
        if ($this->table === null){
            throw new Exception("La class " . get_class($this) . " n'a pas de propriété \$table");
        }
        if ($this->class === null){
            throw new Exception("La class " . get_class($this) . " n'a pas de propriété \$class");
        }
        $this->pdo = $pdo;
    }

    public function find (int $id)
    {

        $query = $this->pdo->prepare('SELECT * FROM ' . $this->table . ' Where id = :id');
        $query->execute(['id' => $id]);
        $query->setFetchMode(PDO::FETCH_CLASS, $this->class);
        $result = $query->fetch();
        if ($result === false){
            throw new NotFoundException($this->table, $id);
        }
        return  $result;

    }

    

}