<?php
class RendezVous {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    public function creerRendezVous($data) {
        $this->db->query('INSERT INTO rendez_vous (patient_id, medecin_id, specialite, date_heure, motif, statut) 
                         VALUES (:patient_id, :medecin_id, :specialite, :date_heure, :motif, "en_attente")');
        
        $this->db->bind(':patient_id', $data['patient_id']);
        $this->db->bind(':medecin_id', $data['medecin_id']);
        $this->db->bind(':specialite', $data['specialite']);
        $this->db->bind(':date_heure', $data['date_heure']);
        $this->db->bind(':motif', $data['motif']);
        
        return $this->db->execute();
    }
    
    public function getDisponibilitesMedecin($medecinId, $date) {
        $this->db->query('SELECT date_heure FROM rendez_vous 
                         WHERE medecin_id = :medecin_id 
                         AND DATE(date_heure) = :date
                         AND statut != "annule"');
        $this->db->bind(':medecin_id', $medecinId);
        $this->db->bind(':date', $date);
        return $this->db->resultSet();
    }
    
    public function getSpecialitesDisponibles() {
        $this->db->query('SELECT DISTINCT specialite FROM medecins WHERE actif = 1');
        return $this->db->resultSet();
    }
    
    public function getMedecinsBySpecialite($specialite) {
        $this->db->query('SELECT id, nom, prenom FROM medecins WHERE specialite = :specialite AND actif = 1');
        $this->db->bind(':specialite', $specialite);
        return $this->db->resultSet();
    }
}
?>