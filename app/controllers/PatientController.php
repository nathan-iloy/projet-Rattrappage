<?php
class PatientController {
    private $patientModel;
    private $rendezVousModel;
    
    public function __construct() {
        $this->patientModel = new Patient();
        $this->rendezVousModel = new RendezVous();
    }
    
    public function dashboard() {
        // Vérifier l'authentification
        if (!isset($_SESSION['patient_id'])) {
            redirect('users/login');
        }
        
        $patient = $this->patientModel->getPatientById($_SESSION['patient_id']);
        
        $data = [
            'patient' => $patient
        ];
        
        loadView('patient/dashboard', $data);
    }
    
    public function mesRendezVous() {
        if (!isset($_SESSION['patient_id'])) {
            redirect('users/login');
        }
        
        $rendezVous = $this->patientModel->getRendezVous($_SESSION['patient_id']);
        
        $data = [
            'rendezVous' => $rendezVous
        ];
        
        loadView('patient/mes_rv', $data);
    }
    
    public function demanderRendezVous() {
        if (!isset($_SESSION['patient_id'])) {
            redirect('users/login');
        }
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Traitement du formulaire
            $data = [
                'patient_id' => $_SESSION['patient_id'],
                'medecin_id' => $_POST['medecin_id'],
                'specialite' => $_POST['specialite'],
                'date_heure' => $_POST['date'] . ' ' . $_POST['heure'],
                'motif' => trim($_POST['motif'])
            ];
            
            if ($this->rendezVousModel->creerRendezVous($data)) {
                flash('rv_success', 'Votre demande de rendez-vous a été enregistrée');
                redirect('patient/mesRendezVous');
            } else {
                die('Une erreur est survenue');
            }
        } else {
            // Afficher le formulaire
            $specialites = $this->rendezVousModel->getSpecialitesDisponibles();
            
            $data = [
                'specialites' => $specialites,
                'medecins' => [],
                'creneaux' => []
            ];
            
            loadView('patient/demande_rv', $data);
        }
    }
    
    public function annulerRendezVous($rvId) {
        if (!isset($_SESSION['patient_id'])) {
            redirect('users/login');
        }
        
        if ($this->patientModel->demanderAnnulation($rvId, $_SESSION['patient_id'])) {
            flash('rv_message', 'Demande d\'annulation envoyée');
        } else {
            flash('rv_error', 'Impossible d\'annuler ce rendez-vous (délai dépassé ou RDV inexistant)');
        }
        
        redirect('patient/mesRendezVous');
    }
    
    public function getMedecins() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['specialite'])) {
            $medecins = $this->rendezVousModel->getMedecinsBySpecialite($_POST['specialite']);
            echo json_encode($medecins);
        } else {
            echo json_encode([]);
        }
    }
    
    public function getDisponibilites() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST'] && isset($_POST['medecin_id']) && isset($_POST['date'])) {
            $dispos = $this->rendezVousModel->getDisponibilitesMedecin($_POST['medecin_id'], $_POST['date']);
            echo json_encode($dispos);
        } else {
            echo json_encode([]);
        }
    }
}
?>