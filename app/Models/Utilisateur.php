<?php

namespace App\Models;


class Utilisateur extends Model
{

    protected $table = 'utilisateur';

    protected $id = 'idUtilisateur';

    private $idUtilisateur;		    // nombre
    private $nom;				        // chaîne de caractères
    private $prenom;				    // chaîne de caractères
    private $email;				        // chaîne de caractères
    private $password;	                // chaîne de caractères
    
    public function getLogin(string $email, string $password): array
    {
        $results = $this->query("SELECT idUtilisateur, email, password FROM {$this->table} WHERE email = ?", [$email], true);
        
        if ($results && isset($results['email'])) {              
            if (password_verify($password, $results['password'])) {
                $this->idUtilisateur = $results['idUtilisateur'];
                $this->email = $results['email'];
                
                $retour = ['isSuccess' => true, 'idUtilisateur' => $this->idUtilisateur, 'message' => 'Connexion'];
            } else {
                // Mot de passe incorrect
                $retour = ['isSuccess' => false, 'message' => 'Mot de passe invalide'];
            }
        } else {
            // Aucun utilisateur trouvé avec cet email
            $retour = ['isSuccess' => false, 'message' => 'Email introuvable'];
        }
        return $retour;
    }

    public function newCompte(string $email, string $nom, string $prenom, string $password): array
    {
        $results = $this->query("SELECT email FROM {$this->table} WHERE email = ?", [$email], true);
        
        if ($results === false) {

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
            $this->query("INSERT INTO {$this->table} (email, nom, prenom, password) VALUES (?, ?, ?, ?)", [$email, $nom, $prenom, $hashedPassword]);

            $idResult = $this->query("SELECT idUtilisateur FROM {$this->table} WHERE email = ?" , [$email], true);
            // $idResult = $this->db->getPDO()->lastInsertId();
            
            $this->idUtilisateur = $idResult;
            $this->email = $email;

            return ['idUtilisateur' => $this->idUtilisateur, 'isSuccess' => true, 'message' => 'Utilisateur ajouté avec succès'];
        } else {
            return ['isSuccess' => false, 'message' => 'Le mail est déjà existant'];
        }
    }
         

        public function lireUser(int $id)
        {
            // Construire la requête SQL pour récupérer les informations de l'utilisateur par ID
            $sql = "SELECT idUtilisateur, nom, prenom, email FROM {$this->table} WHERE {$this->id} = ? LIMIT 1";
            // Exécuter la requête en passant l'ID de l'utilisateur
            $result = $this->query($sql, [$id], true); 
            
            if ($result) {
                // $this->idUtilisateur = $result['idUtilisateur'];
                $this->nom = $result['nom'];
                $this->prenom = $result['prenom'];
                $this->email = $result['email'];
        
                return [
                    // 'idUtilisateur' => $this->idUtilisateur,
                    'nom' => $this->nom,
                    'prenom' => $this->prenom,
                    'email' => $this->email,
                ];
            }
            
            return ;
        }

        public function infoUpdate(int $id, $data)
        {
            // Requête pour mettre à jour les informations utilisateur
            $sql = "UPDATE {$this->table} SET nom = :nom, prenom = :prenom, email = :email WHERE {$this->id} = :id LIMIT 1";
            $this->query($sql, [
                'nom' => $data['nom'],
                'prenom' => $data['prenom'],
                'email' => $data['email'],
                'id' => $id
            ]);
    
            // Requête pour récupérer les informations mises à jour après modification
            $sql = "SELECT nom, prenom, email FROM {$this->table} WHERE {$this->id} = :id LIMIT 1";
            $result = $this->query($sql, ['id' => $id], true);
    
            if ($result) {
                $this->nom = $result['nom'];
                $this->prenom = $result['prenom'];
                $this->email = $result['email'];
    
                return [
                    'nom' => $this->nom,
                    'prenom' => $this->prenom,
                    'email' => $this->email,
                    'isSuccess' => true,
                    'message' => 'Les modifications ont été pris en compte'
                ];
            }else {
                return ['isSuccess' => false, 'message' => 'Problème avec compte a été rencontré'];
            }
    
        }
        



    // public function update()
    // {

    //     global $dbh;

    //     $sql = "UPDATE " . self::$table . " SET";
    //     $sql .= ", Nom = '" . $this->Nom . "'";
    //     $sql .= ", Prenom = '" . $this->Prenom . "'";
    //     $sql .= ", email = '" . $this->Email . "'";
    //     $sql .= ", password = '" . $this->Password . "'";
    //     $sql .= " WHERE " . self::$id . " = '" . $this->id . "' LIMIT 1;";
    //     $result = $dbh->exec($sql);

    //     return $result;
    // }

    public function delete()
    {

        global $dbh;

        $sql = "DELETE FROM " . self::$table;
        $sql .= " WHERE " . self::$id . " = '" . $this->id . "' LIMIT 1;";
        $result = $dbh->exec($sql);

        return $result;
    }


}