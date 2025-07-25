<?php require_once APPROOT . '/views/inc/header.php'; ?>

<div class="container">
    <h1>Mes rendez-vous</h1>
    
    <?php flash('rv_message'); ?>
    <?php flash('rv_error'); ?>
    
    <table class="table table-striped mt-4">
        <thead>
            <tr>
                <th>Date/Heure</th>
                <th>Médecin</th>
                <th>Spécialité</th>
                <th>Motif</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($data['rendezVous'] as $rv) : ?>
            <tr>
                <td><?php echo date('d/m/Y H:i', strtotime($rv->date_heure)); ?></td>
                <td>Dr. <?php echo $rv->medecin_nom; ?></td>
                <td><?php echo $rv->specialite; ?></td>
                <td><?php echo $rv->motif; ?></td>
                <td>
                    <span class="badge badge-<?php 
                        echo $rv->statut == 'confirme' ? 'success' : 
                             ($rv->statut == 'en_attente' ? 'warning' : 
                             ($rv->statut == 'demande_annulation' ? 'info' : 'danger')); 
                    ?>">
                        <?php echo ucfirst(str_replace('_', ' ', $rv->statut)); ?>
                    </span>
                </td>
                <td>
                    <?php if ($rv->statut == 'en_attente' || $rv->statut == 'confirme') : ?>
                    <a href="<?php echo URLROOT; ?>/patient/annulerRendezVous/<?php echo $rv->id; ?>" 
                       class="btn btn-sm btn-danger" 
                       onclick="return confirm('Êtes-vous sûr de vouloir annuler ce rendez-vous?')">
                        Annuler
                    </a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once APPROOT . '/views/inc/footer.php'; ?>