<?php
namespace App\Models;

use App\Config\Database;
use App\Models\BaseModel;
use PDO;
use App\core\Session;
use Exception;

class Event {
    protected $connection;
    private $id;
    private $title;
    private $type;
    private $event_type;
    private $category_id;
    private $couverture;
    private $prix;
    private $lien;
    private $adresse;
    private $nombre_place;
    private $id_ville;
    private $date_event;
    private $date_fin;
    private $user_id;
    private $id_region;
    private $description;
    private $table = 'events';
    private $crud;
    private $session;

    public function __construct() {
        $this->connection = Database::connect();
        $this->crud = new BaseModel();
        $this->session = new Session();
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getCategoryId() {
        return $this->category_id;
    }

    public function setCategoryId($category_id) {
        $this->category_id = $category_id;
    }

    public function getUserId() {
        return $this->user_id;
    }

    public function setUserId($user_id) {
        $this->user_id = $user_id;
    }

    public function getIdVille() {
        return $this->id_ville;
    }

    public function setIdVille($id_ville) {
        $this->id_ville = $id_ville;
    }

    public function getIdRegion() {
        return $this->id_region;
    }

    public function setIdRegion($id_region) {
        $this->id_region = $id_region;
    }

    public function getTitle() {
        return $this->title;
    }
    
    public function setTitle($title) {
        $this->title = $title;
    }
    
    public function getType() {
        return $this->type;
    }
    
    public function setType($type) {
        $this->type = $type;
    }
    
    public function getEventType() {
        return $this->event_type;
    }
    
    public function setEventType($event_type) {
        $this->event_type = $event_type;
    }
    
    public function getCouverture() {
        return $this->couverture;
    }
    
    public function setCouverture($couverture) {
        $this->couverture = $couverture;
    }
    
    public function getPrix() {
        return $this->prix;
    }
    
    public function setPrix($prix) {
        $this->prix = $prix;
    }
    
    public function getLien() {
        return $this->lien;
    }
    
    public function setLien($lien) {
        $this->lien = $lien;
    }
    
    public function getAdresse() {
        return $this->adresse;
    }
    
    public function setAdresse($adresse) {
        $this->adresse = $adresse;
    }
    
    public function getNombrePlace() {
        return $this->nombre_place;
    }
    
    public function setNombrePlace($nombre_place) {
        $this->nombre_place = $nombre_place;
    }
    
    public function getDateEvent() {
        return $this->date_event;
    }
    
    public function setDateEvent($date_event) {
        $this->date_event = $date_event;
    }
    
    public function getDateFin() {
        return $this->date_fin;
    }
    
    public function setDateFin($date_fin) {
        $this->date_fin = $date_fin;
    }

    public function getDescription() {
        return $this->description;
    }
    
    public function setDescription($description) {
        $this->description = $description;
    }

    public function getEvents(){
        $query = "select events.id, titre as title, events.couverture, status, users.name as organizer_name ,categories.name as category_name, date_event as date, adresse as location
        FROM events 
        LEFT JOIN categories ON events.id_categorie = categories.id 
        left join users on events.id_user = users.id where status = 'pending'";
        $stmt = $this->connection->query($query);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function refuseEvent(){
        $data = [
            'status' => 'refuse'
        ];
        return $this->crud->updateRecord($this->table, $data, $this->id);
    }
    public function acceptEvent(){
        $data = [
            'status' => 'accepted'
        ];
        return $this->crud->updateRecord($this->table, $data, $this->id);
    }

    public function pendingCount(){
        $data = [
            'status' => 'pending'
        ];
        return $this->crud->readWithCondition($this->table, $data);
    }
    

    public function getAllEvents() {
        try {
            $query = "
                SELECT 
                    e.*, 
                    v.name AS ville,
                    c.name AS categorie,
                    COUNT(l.id_user) as likes,
                   COUNT(d.id_user) as dislikes,
                    GROUP_CONCAT(s.name SEPARATOR ', ') AS sponsors
                FROM events e
                LEFT JOIN villes v ON e.id_ville = v.id
                LEFT JOIN categories c ON e.id_categorie = c.id
                LEFT JOIN event_sponsor es ON e.id = es.id_event
                LEFT JOIN sponsors s ON es.id_sponsor = s.id
                LEFT JOIN likes_event l ON e.id = l.id_event
                LEFT JOIN dislikes_event d ON e.id = d.id_event
                GROUP BY e.id
            ";
            
            $stmt = $this->connection->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (\PDOException $e) {
            die("Erreur lors de la récupération des événements : " . $e->getMessage());
        }
    }

    public function toggleLike($id_event) {
        try {
            $user_id = $this->session->get('user_id');

            $queryCheck = "SELECT COUNT(*) FROM likes_event WHERE id_event = :id_event AND id_user = :id_user";
            $stmtCheck = $this->connection->prepare($queryCheck);
            $stmtCheck->execute([':id_event' => $id_event, ':id_user' => $user_id]);
            $alreadyLiked = $stmtCheck->fetchColumn();
    
            if ($alreadyLiked > 0) {
                $queryDelete = "DELETE FROM likes_event WHERE id_event = :id_event AND id_user = :id_user";
                $stmtDelete = $this->connection->prepare($queryDelete);
                $stmtDelete->execute([':id_event' => $id_event, ':id_user' => $user_id]);
                return "Like retiré";
            } else {
                $queryInsert = "INSERT INTO likes_event (id_event, id_user) VALUES (:id_event, :id_user)";
                $stmtInsert = $this->connection->prepare($queryInsert);
                $stmtInsert->execute([':id_event' => $id_event, ':id_user' => $user_id]);
                return "Like ajouté";
            }
        } catch (PDOException $e) {
            error_log("Erreur lors du toggle du like : " . $e->getMessage());
            throw new Exception("Échec du toggle du like.");
        }
    }
    
    public function toggleDislike($id_event) {
        try {
            $user_id = $this->session->get('user_id');

            $queryCheck = "SELECT COUNT(*) FROM dislikes_event WHERE id_event = :id_event AND id_user = :id_user";
            $stmtCheck = $this->connection->prepare($queryCheck);
            $stmtCheck->execute([':id_event' => $id_event, ':id_user' => $user_id]);
            $alreadyDisliked = $stmtCheck->fetchColumn();
    
            if ($alreadyDisliked > 0) {

                $queryDelete = "DELETE FROM dislikes_event WHERE id_event = :id_event AND id_user = :id_user";
                $stmtDelete = $this->connection->prepare($queryDelete);
                $stmtDelete->execute([':id_event' => $id_event, ':id_user' => $user_id]);
                return "Dislike retiré";
            } else {

                $queryInsert = "INSERT INTO dislikes_event (id_event, id_user) VALUES (:id_event, :id_user)";
                $stmtInsert = $this->connection->prepare($queryInsert);
                $stmtInsert->execute([':id_event' => $id_event, ':id_user' => $user_id]);
                return "Dislike ajouté";
            }
        } catch (PDOException $e) {
            error_log("Erreur lors du toggle du dislike : " . $e->getMessage());
            throw new Exception("Échec du toggle du dislike.");
        }
    }
    public function getEventsByUserId() {
        try {
            $query = "
                SELECT 
                    e.*, 
                    v.name AS ville,
                    c.name AS categorie,
                    GROUP_CONCAT(s.name SEPARATOR ', ') AS sponsors
                FROM events e
                LEFT JOIN villes v ON e.id_ville = v.id
                LEFT JOIN categories c ON e.id_categorie = c.id
                LEFT JOIN event_sponsor es ON e.id = es.id_event
                LEFT JOIN sponsors s ON es.id_sponsor = s.id
                WHERE e.id_user = :id_user
                GROUP BY e.id
            ";
            
            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(':id_user', $this->user_id, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (\PDOException $e) {
            die("Erreur lors de la récupération des événements de l'utilisateur : " . $e->getMessage());
        }
    }

    public function countEventsByUserId() {
        try {
            $countQuery = "
                SELECT COUNT(*) AS total_events_by_user 
                FROM events 
                WHERE id_user = :id_user
            ";
            
            $countStmt = $this->connection->prepare($countQuery);
            $countStmt->bindParam(':id_user', $this->user_id, PDO::PARAM_INT);
            $countStmt->execute();
            
            $totalEventsByUser = $countStmt->fetch(PDO::FETCH_ASSOC)['total_events_by_user'];
    
            return $totalEventsByUser;
    
        } catch (\PDOException $e) {
            die("Erreur lors du comptage des événements de l'utilisateur : " . $e->getMessage());
        }
    }

    public function countReservationsByEventIdAndUserId() {
        try {
            $countQuery = "
                SELECT 
                    e.id AS event_id,
                    e.titre as title, 
                    COUNT(r.id) AS total_reservations 
                FROM events e
                LEFT JOIN reservations r ON e.id = r.id_event
                WHERE e.id_user = :id_user
                GROUP BY e.id
            ";
            
            $stmt = $this->connection->prepare($countQuery);
            $stmt->bindParam(':id_user', $this->user_id, PDO::PARAM_INT);
            $stmt->execute();
            
            $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            return $reservations;
    
        } catch (\PDOException $e) {
            die("Erreur lors du comptage des réservations : " . $e->getMessage());
        }
    }
    
    public function hasReservationsForOrganizer() {
        try {
            $query = "
                SELECT 
                    CASE 
                        WHEN COUNT(r.id) > 0 THEN 1 
                        ELSE 0 
                    END AS has_reservations
                FROM events e
                LEFT JOIN reservations r ON e.id = r.id_event
                WHERE e.id = :id AND e.id_user = :id_user
                GROUP BY e.id
            ";
    
            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
            $stmt->bindParam(':id_user', $this->user_id, PDO::PARAM_INT);
            $stmt->execute();
    
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            return $result ? (bool) $result['has_reservations'] : false;
    
        } catch (\PDOException $e) {
            error_log("Erreur lors de la vérification des réservations : " . $e->getMessage());
            return false;
        }
    }
    
    
    public function getReservedEventsByOrganizer() {
        try {
            $query = "
                SELECT 
                    e.id AS event_id,
                    e.titre AS title,
                    e.couverture AS cover_image,
                    u.name AS participant_name
                FROM events e
                LEFT JOIN reservations r ON e.id = r.id_event
                LEFT JOIN users u ON r.id_user = u.id
                WHERE e.id_user = :id_user
                AND r.status = 'reserved'
            ";
    
            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(':id_user', $this->user_id, PDO::PARAM_INT);
            $stmt->execute();
    
            $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            return $events;
    
        } catch (\PDOException $e) {
            die("Error fetching events for the organizer: " . $e->getMessage());
        }
    }
    
    
    
    
    
    public function deleteSponsor() {
        try {
            $this->removeSponsors($this->id);

            $stmt = $this->connection->prepare("DELETE FROM events WHERE id = :id");
            $stmt->execute(['id' => $this->id]);

            return true;
        } catch (PDOException $e) {
            error_log("Erreur lors de la suppression de l'event : " . $e->getMessage());
            return false;
        }
    }
    
    public function getAllVilles() {
        $stmt = $this->connection->prepare("SELECT * FROM villes where id_region = :id");
        $stmt->execute(['id' => $this->id_region]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC); 
    }

    public function getAllRegions() {
        $stmt = $this->connection->prepare("SELECT * FROM region");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); 
    }

    public function getAllCategories() {
        $stmt = $this->connection->prepare("SELECT * FROM categories");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); 
    }

    public function createEvent($data) {
        try {
            $query = "INSERT INTO events (titre, type, event_type, id_categorie, couverture, prix, lien, adresse, nombre_place, id_ville, date_event, date_fin, id_user,description) 
                      VALUES (:titre, :type, :event_type, :id_categorie, :couverture, :prix, :lien, :adresse, :nombre_place, :id_ville, :date_event, :date_fin, :id_user,:description)";
    
            $stmt = $this->connection->prepare($query);
    
            $stmt->bindParam(':titre', $data['titre']);
            $stmt->bindParam(':type', $data['type']);
            $stmt->bindParam(':event_type', $data['event_type']);
            $stmt->bindParam(':id_categorie', $data['id_categorie']);
            $stmt->bindParam(':couverture', $data['couverture']);
            $stmt->bindParam(':prix', $data['prix']);
            $stmt->bindParam(':lien', $data['lien']);
            $stmt->bindParam(':adresse', $data['adresse']);
            $stmt->bindParam(':nombre_place', $data['nombre_place']);
            $stmt->bindParam(':id_ville', $data['id_ville']);
            $stmt->bindParam(':date_event', $data['date_event']);
            $stmt->bindParam(':date_fin', $data['date_fin']);
            $stmt->bindParam(':id_user', $data['id_user']);
            $stmt->bindParam(':description', $data['description']);
    
            $stmt->execute();
    
            $eventId = $this->connection->lastInsertId();
    
            if (!$eventId) {
                throw new Exception("L'événement n'a pas été inséré correctement.");
            }
    
            if (!empty($data['sponsors'])) {
                $this->addSponsors($eventId, $data['sponsors']);
            }
    
            return $eventId;
        } catch (PDOException $e) {
            echo "Erreur lors de la création de l'event : " . $e->getMessage();
            return false;
        }
    }
    

    private function addSponsors($eventId, $sponsors) {
        try {
            
            $stmt = $this->connection->prepare("
                INSERT INTO event_sponsor (id_event, id_sponsor)
                VALUES (:id_event, :id_sponsor)
            ");
    
            $this->connection->beginTransaction();
    
            foreach ($sponsors as $sponsorId) {
                $stmt->execute(['id_event' => $eventId, 'id_sponsor' => $sponsorId]);
            }

            $this->connection->commit();
    
        } catch (PDOException $e) {
            $this->connection->rollBack();
            error_log("Erreur lors de l'ajout des sponsors : " . $e->getMessage());
            throw new Exception("Failed to add sponsors to event.");
        }
    }
    

    private function updateSponsors($eventId, $sponsors) {
        $this->removeSponsors($eventId);
        $this->addSponsors($eventId, $sponsors);
    }

    private function removeSponsors($eventId) {
        try {
            $stmt = $this->connection->prepare("DELETE FROM event_sponsor WHERE id_event = :id_event");
            $stmt->execute(['id_event' => $eventId]);
        } catch (PDOException $e) {
            error_log("Erreur lors de la suppression des sponsros : " . $e->getMessage());
        }
    }

    public function getEventById() {
        try {
            $query = "
                SELECT 
                    e.*, 
                    v.name AS ville,
                    c.name AS categorie,
                    GROUP_CONCAT(s.name SEPARATOR ', ') AS sponsors
                FROM events e
                LEFT JOIN villes v ON e.id_ville = v.id
                LEFT JOIN categories c ON e.id_categorie = c.id
                LEFT JOIN event_sponsor es ON e.id = es.id_event
                LEFT JOIN sponsors s ON es.id_sponsor = s.id
                WHERE e.id = :id
                GROUP BY e.id
            ";
    
            $stmt = $this->connection->prepare($query);
            $stmt->execute(['id' => $this->id]);
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            die("Erreur lors de la récupération de l'événement : " . $e->getMessage());
        }
    }

    public function updateEvent($data) {
        try {
            $query = "UPDATE events 
                      SET titre = :titre, 
                          type = :type, 
                          event_type = :event_type, 
                          id_categorie = :id_categorie, 
                          couverture = :couverture, 
                          prix = :prix, 
                          lien = :lien, 
                          adresse = :adresse, 
                          nombre_place = :nombre_place, 
                          id_ville = :ville_id, 
                          date_event = :date_event, 
                          date_fin = :date_fin ,
                          description = :description 
                      WHERE id = :id";
    
            $stmt = $this->connection->prepare($query);
    
            $stmt->bindParam(':id', $this->id);
            $stmt->bindParam(':titre', $data['titre']);
            $stmt->bindParam(':type', $data['type']);
            $stmt->bindParam(':event_type', $data['event_type']);
            $stmt->bindParam(':id_categorie', $data['id_categorie']);
            $stmt->bindParam(':couverture', $data['couverture']);
            $stmt->bindParam(':prix', $data['prix']);
            $stmt->bindParam(':lien', $data['lien']);
            $stmt->bindParam(':adresse', $data['adresse']);
            $stmt->bindParam(':nombre_place', $data['nombre_place']);
            $stmt->bindParam(':ville_id', $data['ville_id']);
            $stmt->bindParam(':date_event', $data['date_event']);
            $stmt->bindParam(':date_fin', $data['date_fin']);
            $stmt->bindParam(':description', $data['description']);
    
            $stmt->execute();
    
            if (!empty($data['sponsors'])) {
                $this->updateSponsors($this->id, $data['sponsors']);
            }
    
            return true;
        } catch (PDOException $e) {
            error_log("Erreur lors de la mise à jour de l'événement : " . $e->getMessage());
            return false;
        }
    }
    
    public function getTopEvents(){
        $query = "SELECT COUNT(r.id ) as total, e.id ,e.titre, e.nombre_place, adresse FROM `events` e
                    LEFT JOIN reservations r ON e.id = r.id_event 
                    WHERE e.status = 'accepted' 
                    GROUP BY e.id 
                    ORDER BY total desc;";
        $stmt = $this->connection->query($query);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function countReservationsByEvent(){
        $query = "SELECT COUNT(r.id ) as total_reservation,e.titre as events_name FROM `events` e
                    LEFT JOIN reservations r ON e.id = r.id_event 
                    WHERE e.status = 'accepted' 
                    GROUP BY e.id;";
        $stmt = $this->connection->query($query);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function CountAcceptedEvents(){
        $data = [
            'status' => 'accepted'
        ];
        return $this->crud->countWithCondition($this->table, $data);
    }


    public function searchByTitle($limit, $offset) {
        try {
            $query = "
                SELECT 
                    e.*, 
                    v.name AS ville,
                    c.name AS categorie,
                    GROUP_CONCAT(s.name SEPARATOR ', ') AS sponsors
                FROM events e
                LEFT JOIN villes v ON e.id_ville = v.id
                LEFT JOIN categories c ON e.id_categorie = c.id
                LEFT JOIN event_sponsor es ON e.id = es.id_event
                LEFT JOIN sponsors s ON es.id_sponsor = s.id
                WHERE e.titre LIKE :title
                GROUP BY e.id
                LIMIT :limit OFFSET :offset
            ";
    
            $stmt = $this->connection->prepare($query);
            $stmt->bindValue(':title', '%' . $this->title . '%', PDO::PARAM_STR);
            $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', (int) $offset, PDO::PARAM_INT);
            $stmt->execute();
    
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            die("Error while searching for events: " . $e->getMessage());
        }
    }

    public function getTotalSearchEvents() {
        try {
            $query = "
                SELECT COUNT(DISTINCT e.id) AS total
                FROM events e
                LEFT JOIN villes v ON e.id_ville = v.id
                LEFT JOIN categories c ON e.id_categorie = c.id
                LEFT JOIN event_sponsor es ON e.id = es.id_event
                LEFT JOIN sponsors s ON es.id_sponsor = s.id
                WHERE e.titre LIKE :title
            ";
    
            $stmt = $this->connection->prepare($query);
            $stmt->bindValue(':title', '%' . $this->title . '%', PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            return $result['total'] ?? 0;
        } catch (\PDOException $e) {
            die("Error while counting events: " . $e->getMessage());
        }
    }
    
    

    public function getPaginatedEvents($limit, $offset, $categoryId = null) {
        try {
            $query = "
                SELECT 
                    e.*, 
                    v.name AS ville,
                    c.name AS categorie,
                    GROUP_CONCAT(s.name SEPARATOR ', ') AS sponsors
                FROM events e
                LEFT JOIN villes v ON e.id_ville = v.id
                LEFT JOIN categories c ON e.id_categorie = c.id
                LEFT JOIN event_sponsor es ON e.id = es.id_event
                LEFT JOIN sponsors s ON es.id_sponsor = s.id
            ";
            if ($categoryId) {
                $query .= " WHERE e.id_categorie = :category ";
            }
    
            $query .= " GROUP BY e.id LIMIT :limit OFFSET :offset";
            $stmt = $this->connection->prepare($query);
    
            if ($categoryId) {
                $stmt->bindValue(':category', $categoryId);
            }
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            die("Error while retrieving events: " . $e->getMessage());
        }
    }
    
    
    public function getTotalEvents($categoryId = null) {
        try {
            $query = "SELECT COUNT(*) as total FROM events e";
            if ($categoryId) {
                $query .= " WHERE e.id_categorie = :category";
            }
            $stmt = $this->connection->prepare($query);
            if ($categoryId) {
                $stmt->bindValue(':category', $categoryId, PDO::PARAM_INT);
            }
    
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        } catch (\PDOException $e) {
            die("Erreur lors de la récupération du nombre total d'événements : " . $e->getMessage());
        }
    }
    

    public function getFilteredEventsByCategory($category, $limit, $offset) {
        try {
            $query = "
                SELECT 
                    e.*, 
                    v.name AS ville,
                    c.name AS categorie,
                    GROUP_CONCAT(s.name SEPARATOR ', ') AS sponsors
                FROM events e
                LEFT JOIN villes v ON e.id_ville = v.id
                LEFT JOIN categories c ON e.id_categorie = c.id
                LEFT JOIN event_sponsor es ON e.id = es.id_event
                LEFT JOIN sponsors s ON es.id_sponsor = s.id
                WHERE c.id = :category
                GROUP BY e.id
                LIMIT :limit OFFSET :offset
            ";
    
            $stmt = $this->connection->prepare($query);
            $stmt->bindValue(':category', $category, PDO::PARAM_INT);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
    
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            die("Error while filtering events: " . $e->getMessage());
        }
    }
    
    
    
}
