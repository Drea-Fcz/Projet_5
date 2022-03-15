<?php

namespace App\Models;

use App\Core\Db;
use PDOStatement;

class Model extends Db
{
    // Table de la base de données
    protected $table;

    // Instance de Db
    private $db;


    /**
     * @return array|false
     */
    public function findAll()
    {
        $query = $this->request('SELECT * FROM ' . $this->table);
        return $query->fetchAll();
    }

    /**
     * @param array $criteria
     * @return array|false
     */
    public function findBy(array $criteria)
    {
        $fields = [];
        $values = [];

        // On boucle pour éclater le tableau
        foreach ($criteria as $field => $value) {
            // SELECT * FROM comment WHERE is_valid = ?
            // bindValue(1, valeur)
            $fields[] = "$field = ?";
            $values[] = $value;
        }

        // On transforme le tableau "fields" en une chaine de caractères
        $fieldList = implode(' AND ', $fields);

        // On exécute la requête
        return $this->request('SELECT * FROM ' . $this->table . ' WHERE ' . $fieldList, $values)->fetchAll();
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function find(int $id)
    {
        return $this->request("SELECT * FROM {$this->table} WHERE id = $id")->fetch();
    }

    /**
     * @return false|PDOStatement
     */
    public function create()
    {
        $fields = [];
        $inter = [];
        $values = [];

        // On boucle pour éclater le tableau
        foreach ($this as $field => $value) {
            // INSERT INTO posts (titre, description, actif) VALUES (?, ?, ?)
            if ($value !== null && $field != 'db' && $field != 'table') {
                $fields[] = $field;
                $inter[] = "?";
                $values[] = $value;
            }
        }

        // On transforme le tableau "champs" en une chaine de caractères
        $fieldList = implode(', ', $fields);
        $interList = implode(', ', $inter);

        // On exécute la requête
        return $this->request('INSERT INTO ' . $this->table . ' (' . $fieldList . ')VALUES(' . $interList . ')', $values);
    }

    /**
     * @return false|PDOStatement
     */
    public function update()
    {
        $fields = [];
        $values = [];

        // On boucle pour éclater le tableau
        foreach ($this as $field => $value) {
            // UPDATE annonces SET titre = ?, description = ?, actif = ? WHERE id= ?
            if ($value !== null && $field != 'db' && $field != 'table') {
                $fields[] = "$field = ?";
                $values[] = $value;
            }
        }
        $values[] = $this->id;

        // On transforme le tableau "champs" en une chaine de caractères
        $fieldList = implode(', ', $fields);

        // On exécute la requête
        return $this->request('UPDATE ' . $this->table . ' SET ' . $fieldList . ' WHERE id = ?', $values);
    }

    /**
     * @param int $id
     * @return false|PDOStatement
     */
    public function delete(int $id)
    {
        return $this->request("DELETE FROM {$this->table} WHERE id = ?", [$id]);
    }


    /**
     * @param string $sql
     * @param array|null $attributes
     * @return false|PDOStatement
     */
    public function request(string $sql, array $attributes = null)
    {
        // On récupère l'instance de Db
        $this->db = Db::getInstance();
        // On vérifie si on a des attributs
        if ($attributes !== null) {
            // Requête préparée
            $query = $this->db->prepare($sql);
            $query->execute($attributes);
            return $query;
        } else {
            // Requête simple
            return $this->db->query($sql);
        }
    }


    /**
     * @param $data
     * @return $this
     */
    public function hydrate($data): Model
    {
        foreach ($data as $key => $value) {
            // On récupère le nom du setter correspondant à la clé (key)
            // titre -> setTitre
            $setter = 'set' . ucfirst($key);

            // On vérifie si le setter existe
            if (method_exists($this, $setter)) {
                // On appelle le setter
                $this->$setter($value);
            }
        }
        return $this;
    }
}
