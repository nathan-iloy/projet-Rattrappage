<?php
class Patient {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    public function getPatientById($id) {
        $this->db->query('SELECT * FROM patients WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
    
    public function getRendezVous($patientId) {
        $this->db->query('SELECT rv.*, m.nom as medecin_nom, m.specialite 
                         FROM rendez_vous rv 
                         JOIN medecins m ON rv.medecin_id = m.id 
                         WHERE rv.patient_id = :patient_id 
                         ORDER BY rv.date_heure');
        $this->db->bind(':patient_id', $patientId);
        return $this->db->resultSet();
    }
    
    public function demanderAnnulation($rvId, $patientId) {
        // Vérifier si le rendez-vous peut être annulé (48h avant)
        $this->db->query('SELECT date_heure FROM rendez_vous WHERE id = :id AND patient_id = :patient_id');
        $this->db->bind(':id', $rvId);
        $this->db->bind(':patient_id', $patientId);
        $rv = $this->db->single();
        
        if (!$rv) return false;
        
        $now = new DateTime();
        $rvDate = new DateTime($rv->date_heure);
        $diff = $now->diff($rvDate);
        
        if ($diff->days < 2) return false;
        
        // Enregistrer la demande d'annulation
        $this->db->query('UPDATE rendez_vous SET statut = "demande_annulation" WHERE id = :id');
        $this->db->bind(':id', $rvId);
        return $this->db->execute();
    }
}
?>