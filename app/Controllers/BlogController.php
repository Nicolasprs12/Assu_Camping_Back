<?php

namespace App\Controllers;

use App\Models\PrixVente;
use App\Models\Pays;
use App\Models\Utilisateur;
use App\Models\Contrat;
use App\Models\Garantie;
use App\Models\Conducteur;
use App\Models\Vehicule;
use App\Models\Documents;
use App\Models\JWTHandler;
use function App\Models\generateJWT;

class BlogController extends Controller
{
    
    public $secretKey = "Key2024";
    
    public function prix()
    {
        $prixVente = new PrixVente($this->getDB());
        $prix_vente = $prixVente->all();
        header('Content-Type: application/json');
        echo json_encode($prix_vente);
    }

    public function pays()
    {
        $newPays = new Pays($this->getDB());
        $pays = $newPays->all();
        header('Content-Type: application/json');
        echo json_encode($pays);
    }

    public function connexion()
    {

        $jsonData = file_get_contents('php://input');
        $data = json_decode($jsonData, true);

        $utilisateur = new Utilisateur($this->getDB());
        $user = $utilisateur->getLogin($data['email'], $data['password']);

        header('Content-Type: application/json');
        if ($user && $user['isSuccess']) {
            $stateToken = [
                'id' => $user['idUtilisateur'],
            ];

            // Générer un token JWT
            $token = generateJWT($stateToken, $this->secretKey);

            $response = [
                'isSuccess' => $user['isSuccess'],
                'message' => $user['message'],
            ];

            // Ajouter le token à la réponse
            $response['token'] = $token;

            echo json_encode($response);
        } else {
            http_response_code(401);
            $response = [
                'error' => true,
                'message' => 'email ou mot de passe invalide'
            ];
            echo json_encode($response);
        }
    }
    public function creacompte()
    {
 
        $jsonData = file_get_contents('php://input');
        $data = json_decode($jsonData, true);

        $utilisateur = new Utilisateur($this->getDB());
        $newUser = $utilisateur->newCompte($data['email'], $data['nom'], $data['prenom'], $data['password']);

        header('Content-Type: application/json');
        if ($newUser['isSuccess']) {
            $response = [
                'id' => $newUser['idUtilisateur'],
                'isSuccess' => $newUser['isSuccess'],
                'message' => $newUser['message'],
            ];

            echo json_encode($response);
        } else {
            http_response_code(401);
            $response = [
                'error' => true,
                'message' => 'L\'email est déjà enregistré'
            ];
            echo json_encode($response);
        }
    }

    public function compte()
    {
        
        $jwtHandler = new JWTHandler($this->secretKey);
        $jwt = $jwtHandler->getBearerToken();

        if (!$jwt) {
            http_response_code(401); // Unauthorized
            echo json_encode(['message' => 'Unauthorized']);
            return;
        }

        $payload = $jwtHandler->decodeJWT($jwt);

        if (!$payload) {
            http_response_code(401); // Unauthorized
            echo json_encode(['message' => 'Invalid token']);
            return;
        }


        // Récupérer les informations utilisateur
        $utilisateur = new Utilisateur($this->getDB());
        $infoUser = $utilisateur->lireUser($payload['id']);
        header('Content-Type: application/json');
        echo json_encode($infoUser);
    }

    public function compteUpdate()
    {

        $jsonData = file_get_contents('php://input');
        $data = json_decode($jsonData, true);

        $jwtHandler = new JWTHandler($this->secretKey);
        $jwt = $jwtHandler->getBearerToken();

        if (!$jwt) {
            http_response_code(401); // Unauthorized
            echo json_encode(['message' => 'Unauthorized']);
            return;
        }

        $payload = $jwtHandler->decodeJWT($jwt);

        if (!$payload) {
            http_response_code(401); // Unauthorized
            echo json_encode(['message' => 'Invalid token']);
            return;
        }

        $utilisateur = new Utilisateur($this->getDB());
        $infoUser = $utilisateur->infoUpdate($payload['id'], $data );
        header('Content-Type: application/json');
        echo json_encode($infoUser);
    }

    public function ContratsRecents()
    {
        $jwtHandler = new JWTHandler($this->secretKey);
        $jwt = $jwtHandler->getBearerToken();

        if (!$jwt) {
            http_response_code(401); // Unauthorized
            echo json_encode(['message' => 'Unauthorized']);
            return;
        }

        $payload = $jwtHandler->decodeJWT($jwt);

        if (!$payload) {
            http_response_code(401); // Unauthorized
            echo json_encode(['message' => 'Invalid token']);
            return;
        }

        $contrat = new Contrat($this->getDB());
        $infoContrat = $contrat->lireConRecents($payload['id']);
        header('Content-Type: application/json');
        echo json_encode($infoContrat);


    }
    public function contrat()
    {
        $jwtHandler = new JWTHandler("Key2024");
        $jwt = $jwtHandler->getBearerToken();

        if (!$jwt) {
            http_response_code(401); // Unauthorized
            echo json_encode(['message' => 'Unauthorized']);
            return;
        }

        $payload = $jwtHandler->decodeJWT($jwt);

        if (!$payload) {
            http_response_code(401); // Unauthorized
            echo json_encode(['message' => 'Invalid token']);
            return;
        }

        $contrat = new Contrat($this->getDB());
        $infoContrat = $contrat->lire($payload['id']);
        header('Content-Type: application/json');
        echo json_encode($infoContrat);

    }

    public function contratDelete()
    {
        $jsonData = file_get_contents('php://input');
        $data = json_decode($jsonData, true);

        $idContrat = isset($data['id']) ? (int)$data['id'] : null;

        $jwtHandler = new JWTHandler("Key2024");
        $jwt = $jwtHandler->getBearerToken();

        if (!$jwt) {
            http_response_code(401); 
            echo json_encode(['message' => 'Unauthorized']);
            return;
        }

        $payload = $jwtHandler->decodeJWT($jwt);

        if (!$payload) {
            http_response_code(401); 
            echo json_encode(['message' => 'Invalid token']);
            return;
        }

        $contrat = new Contrat($this->getDB());
        $infoContrat = $contrat->delete($idContrat);
        header('Content-Type: application/json');
        echo json_encode($infoContrat);

    }
    
    public function formulaire()
    {
        $jwtHandler = new JWTHandler("Key2024");
        $jwt = $jwtHandler->getBearerToken();
    
        if (!$jwt) {
            http_response_code(401); 
            echo json_encode(['message' => 'Unauthorized']);
            return;
        }
    
        $payload = $jwtHandler->decodeJWT($jwt);
    
        if (!$payload) {
            http_response_code(401); 
            echo json_encode(['message' => 'Invalid token']);
            return;
        }
    
        $jsonData = file_get_contents('php://input');
        $data = json_decode($jsonData, true);

        if (!is_array($data)) {
            http_response_code(400); 
            echo json_encode(['message' => 'Invalid JSON']);
            return;
        }
    
        $idUser = $payload['id'];
    
        $infoPersoData = new Conducteur($this->getDB());
        $infoPerso = $infoPersoData->ecrire($data['informationsPersonnelles']);
    
        
        $infoVehiData = new Vehicule($this->getDB());
        $infoVehi = $infoVehiData->ecrire($data['informationsVehicule']);


        $infoGarantieData = new Garantie($this->getDB());
        $infoGarantie = $infoGarantieData->ecrire($data['informationsGarantie']);
    

        $contratData = new Contrat($this->getDB());
        $newContrat = $contratData->ecrire($data['informationsGarantie'], $infoPerso[0], $infoVehi[0], $infoGarantie[0], $idUser);


        $docData = new Documents($this->getDB());
        $infoDoc = $docData->ecrire($data['documents'], $newContrat);


        $retour = ['contrat' => $newContrat];
    
        // Envoi de la réponse au format JSON
        header('Content-Type: application/json');
        echo json_encode($retour);
    }
    
    public function paiement()    
    {
        $jsonData = file_get_contents('php://input');
        $idContrat = json_decode($jsonData, true);

        $jwtHandler = new JWTHandler($this->secretKey);
        $jwt = $jwtHandler->getBearerToken();

        if (!$jwt) {
            http_response_code(401); 
            echo json_encode(['message' => 'Unauthorized']);
            return;
        }

        $payload = $jwtHandler->decodeJWT($jwt);

        if (!$payload) {
            http_response_code(401); 
            echo json_encode(['message' => 'Invalid token']);
            return;
        }

        $idUser = $payload['id'];

        $commande = new Contrat($this->getDB());
        $infoCommande = $commande->commande($idContrat);
        header('Content-Type: application/json');
        echo json_encode($infoCommande);
    }

    public function payer()    
    {
        $jsonData = file_get_contents('php://input');
        $data = json_decode($jsonData, true);

        $idContrat = isset($data['id']) ? (int)$data['id'] : null;


        $jwtHandler = new JWTHandler($this->secretKey);
        $jwt = $jwtHandler->getBearerToken();

        if (!$jwt) {
            http_response_code(401); 
            echo json_encode(['message' => 'Unauthorized']);
            return;
        }

        $payload = $jwtHandler->decodeJWT($jwt);

        if (!$payload) {
            http_response_code(401); 
            echo json_encode(['message' => 'Invalid token']);
            return;
        }

        $paiement = new Contrat($this->getDB());
        $infoPaiement = $paiement->payer($idContrat);
        header('Content-Type: application/json');
        echo json_encode($infoPaiement);
    }
    public function validation()    
    {
        $jsonData = file_get_contents('php://input');
        $data = json_decode($jsonData, true);

        $idContrat = isset($data['id']) ? (int)$data['id'] : null;

        $jwtHandler = new JWTHandler($this->secretKey);
        $jwt = $jwtHandler->getBearerToken();

        if (!$jwt) {
            http_response_code(401); 
            echo json_encode(['message' => 'Unauthorized']);
            return;
        }

        $payload = $jwtHandler->decodeJWT($jwt);

        if (!$payload) {
            http_response_code(401); 
            echo json_encode(['message' => 'Invalid token']);
            return;
        }

        $paiement = new Contrat($this->getDB());
        $infoPaiement = $paiement->validation($idContrat);
        header('Content-Type: application/json');
        echo json_encode($infoPaiement);
    }
}
