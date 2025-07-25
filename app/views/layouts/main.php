 <!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITENAME; ?> | <?php echo $data['title'] ?? ''; ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/css/style.css">
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="<?php echo URLROOT; ?>"><?php echo SITENAME; ?></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExampleDefault">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarsExampleDefault">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo URLROOT; ?>"><i class="fas fa-home"></i> Accueil</a>
                    </li>
                    <?php if(isset($_SESSION['patient_id'])) : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo URLROOT; ?>/patient/dashboard"><i class="fas fa-tachometer-alt"></i> Tableau de bord</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo URLROOT; ?>/patient/mesRendezVous"><i class="fas fa-calendar-check"></i> Mes rendez-vous</a>
                        </li>
                    <?php endif; ?>
                </ul>

                <ul class="navbar-nav ms-auto">
                    <?php if(isset($_SESSION['patient_id'])) : ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user"></i> <?php echo $_SESSION['patient_nom'] ?? ''; ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="<?php echo URLROOT; ?>/patients/profile"><i class="fas fa-user-circle"></i> Profil</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="<?php echo URLROOT; ?>/patients/logout">
                                        <i class="fas fa-sign-out-alt"></i> Déconnexion
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <?php else : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo URLROOT; ?>/patients/login"><i class="fas fa-sign-in-alt"></i> Connexion</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo URLROOT; ?>/patients/register"><i class="fas fa-user-plus"></i> Inscription</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container my-4">
        <!-- Flash Messages -->
        <?php if($message = flash('rv_message')) : ?>
            <div class="alert alert-success alert-dismissible fade show">
                <?php echo $message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <?php if($error = flash('rv_error')) : ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <?php echo $error; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <!-- Page-specific content will be inserted here -->
        <?php echo $content ?? ''; ?>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white mt-5">
        <div class="container py-4">
            <div class="row">
                <div class="col-md-6">
                    <h5><?php echo SITENAME; ?></h5>
                    <p>Gestion des rendez-vous médicaux en ligne</p>
                </div>
                <div class="col-md-3">
                    <h5>Liens rapides</h5>
                    <ul class="list-unstyled">
                        <li><a href="<?php echo URLROOT; ?>" class="text-white">Accueil</a></li>
                        <?php if(isset($_SESSION['patient_id'])) : ?>
                            <li><a href="<?php echo URLROOT; ?>/patient/dashboard" class="text-white">Tableau de bord</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5>Contact</h5>
                    <address>
                        <i class="fas fa-map-marker-alt"></i> 123 Rue de la Clinique<br>
                        <i class="fas fa-phone"></i> 01 23 45 67 89<br>
                        <i class="fas fa-envelope"></i> contact@clinique-exemple.fr
                    </address>
                </div>
            </div>
            <hr>
            <div class="text-center">
                <p class="mb-0">&copy; <?php echo date('Y'); ?> <?php echo SITENAME; ?>. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo URLROOT; ?>/assets/js/main.js"></script>
    
    <!-- Page-specific JavaScript -->
    <?php if(isset($data['javascript'])) : ?>
        <script src="<?php echo URLROOT; ?>/assets/js/<?php echo $data['javascript']; ?>.js"></script>
    <?php endif; ?>
</body>
</html>