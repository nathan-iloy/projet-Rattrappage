<?php require_once APPROOT . '/views/inc/header.php'; ?>

<div class="container">
    <h1>Demander un rendez-vous</h1>
    
    <form action="<?php echo URLROOT; ?>/patient/demanderRendezVous" method="post">
        <div class="form-group">
            <label for="specialite">Spécialité :</label>
            <select name="specialite" id="specialite" class="form-control" required>
                <option value="">-- Sélectionnez une spécialité --</option>
                <?php foreach($data['specialites'] as $spec) : ?>
                <option value="<?php echo $spec->specialite; ?>"><?php echo $spec->specialite; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="form-group">
            <label for="medecin_id">Médecin :</label>
            <select name="medecin_id" id="medecin_id" class="form-control" required disabled>
                <option value="">-- Sélectionnez d'abord une spécialité --</option>
            </select>
        </div>
        
        <div class="form-group">
            <label for="date">Date :</label>
            <input type="date" name="date" id="date" class="form-control" required min="<?php echo date('Y-m-d'); ?>">
        </div>
        
        <div class="form-group">
            <label for="heure">Heure :</label>
            <select name="heure" id="heure" class="form-control" required disabled>
                <option value="">-- Sélectionnez d'abord un médecin et une date --</option>
            </select>
        </div>
        
        <div class="form-group">
            <label for="motif">Motif :</label>
            <textarea name="motif" id="motif" class="form-control" rows="3" required></textarea>
        </div>
        
        <button type="submit" class="btn btn-primary">Demander le rendez-vous</button>
    </form>
</div>

<script>
$(document).ready(function() {
    // Chargement des médecins selon la spécialité sélectionnée
    $('#specialite').change(function() {
        if ($(this).val() == '') {
            $('#medecin_id').html('<option value="">-- Sélectionnez d\'abord une spécialité --</option>').prop('disabled', true);
            return;
        }
        
        $.ajax({
            url: '<?php echo URLROOT; ?>/patient/getMedecins',
            method: 'POST',
            data: { specialite: $(this).val() },
            dataType: 'json',
            success: function(data) {
                let options = '<option value="">-- Sélectionnez un médecin --</option>';
                data.forEach(function(medecin) {
                    options += `<option value="${medecin.id}">Dr. ${medecin.nom} ${medecin.prenom}</option>`;
                });
                $('#medecin_id').html(options).prop('disabled', false);
            }
        });
    });
    
    // Chargement des disponibilités selon le médecin et la date sélectionnés
    $('#medecin_id, #date').change(function() {
        if ($('#medecin_id').val() == '' || $('#date').val() == '') {
            $('#heure').html('<option value="">-- Sélectionnez d\'abord un médecin et une date --</option>').prop('disabled', true);
            return;
        }
        
        $.ajax({
            url: '<?php echo URLROOT; ?>/patient/getDisponibilites',
            method: 'POST',
            data: { 
                medecin_id: $('#medecin_id').val(), 
                date: $('#date').val() 
            },
            dataType: 'json',
            success: function(data) {
                // Générer les créneaux disponibles (exemple: toutes les 30 minutes de 8h à 18h)
                let heuresOccupees = data.map(item => item.date_heure.substr(11, 5));
                
                let options = '<option value="">-- Sélectionnez une heure --</option>';
                for (let h = 8; h < 18; h++) {
                    for (let m = 0; m < 60; m += 30) {
                        let heure = `${h.toString().padStart(2, '0')}:${m.toString().padStart(2, '0')}`;
                        if (!heuresOccupees.includes(heure)) {
                            options += `<option value="${heure}">${heure}</option>`;
                        }
                    }
                }
                $('#heure').html(options).prop('disabled', false);
            }
        });
    });
});
</script>

<?php require_once APPROOT . '/views/inc/footer.php'; ?>