<?php require_once APPROOT . '/views/inc/header.php'; ?>

<div class="container">
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card card-body bg-light mt-5">
                <h2 class="text-center">Demande d'annulation de rendez-vous</h2>
                
                <!-- Affichage des détails du rendez-vous -->
                <div class="alert alert-info mt-3">
                    <h5>Détails du rendez-vous</h5>
                    <p><strong>Date/Heure :</strong> <?php echo date('d/m/Y H:i', strtotime($data['rendezVous']->date_heure)); ?></p>
                    <p><strong>Médecin :</strong> Dr. <?php echo $data['rendezVous']->medecin_nom; ?></p>
                    <p><strong>Spécialité :</strong> <?php echo $data['rendezVous']->specialite; ?></p>
                    <p><strong>Motif :</strong> <?php echo $data['rendezVous']->motif; ?></p>
                </div>
                
                <!-- Vérification du délai de 48h -->
                <?php 
                $now = new DateTime();
                $rvDate = new DateTime($data['rendezVous']->date_heure);
                $diff = $now->diff($rvDate);
                $canCancel = ($diff->days >= 2);
                ?>
                
                <?php if ($canCancel) : ?>
                    <div class="alert alert-warning">
                        <p>Êtes-vous sûr de vouloir demander l'annulation de ce rendez-vous ?</p>
                        <p>Cette demande sera soumise à la secrétaire pour validation.</p>
                    </div>
                    
                    <form action="<?php echo URLROOT; ?>/patient/annulerRendezVous/<?php echo $data['rendezVous']->id; ?>" method="post">
                        <div class="form-group">
                            <label for="raison">Raison de l'annulation (optionnel) :</label>
                            <textarea name="raison" id="raison" class="form-control" rows="3"></textarea>
                        </div>
                        
                        <div class="row mt-3">
                            <div class="col">
                                <input type="submit" value="Confirmer la demande" class="btn btn-danger btn-block">
                            </div>
                            <div class="col">
                                <a href="<?php echo URLROOT; ?>/patient/mesRendezVous" class="btn btn-secondary btn-block">Annuler</a>
                            </div>
                        </div>
                    </form>
                <?php else : ?>
                    <div class="alert alert-danger">
                        <h5>Impossible d'annuler ce rendez-vous</h5>
                        <p>Le délai minimum de 48 heures avant le rendez-vous n'est pas respecté.</p>
                        <p>Veuillez contacter directement la clinique par téléphone pour toute annulation de dernière minute.</p>
                        <a href="<?php echo URLROOT; ?>/patient/mesRendezVous" class="btn btn-secondary">Retour</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php require_once APPROOT . '/views/inc/footer.php'; ?> 