<?php require_once APPROOT . '/views/inc/header.php'; ?>

<div class="container">
    <h1>Bienvenue, <?php echo $data['patient']->prenom; ?></h1>
    
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Mes rendez-vous</h5>
                    <p class="card-text">Consultez ou gérez vos rendez-vous à venir.</p>
                    <a href="<?php echo URLROOT; ?>/patient/mesRendezVous" class="btn btn-primary">Voir mes RDV</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Demander un rendez-vous</h5>
                    <p class="card-text">Prenez un nouveau rendez-vous avec un médecin.</p>
                    <a href="<?php echo URLROOT; ?>/patient/demanderRendezVous" class="btn btn-success">Demander un RDV</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once APPROOT . '/views/inc/footer.php'; ?>