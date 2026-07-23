<?php
// Set page title for header
$page_title = "Abstract Submitted Successfully";
require_once $_SERVER['DOCUMENT_ROOT'].'/conference/config/config.php';
require_once BASE_PATH . 'includes/header.php';

$ref = $_GET['ref'] ?? 'N/A';
?>

<!-- Page Header -->
<section class="page-header bg-success text-white py-4">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="display-5 fw-bold mb-3">
                    <i class="fas fa-check-circle me-3"></i>Submission Successful
                </h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="<?php echo BASE_URL; ?>" class="text-white-50">Home</a>
                        </li>
                        <li class="breadcrumb-item active text-white" aria-current="page">
                            Abstract Submitted
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Success Content -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                <div class="card shadow-sm border-0">
                    <div class="card-body p-5 text-center">

                        <div class="mb-4">
                            <i class="fas fa-paper-plane fa-4x text-success mb-3"></i>
                            <h2 class="text-success fw-bold">Abstract Submitted Successfully!</h2>
                            <p class="text-muted mb-0">
                                Thank you for submitting your abstract to the KALRO Conference.
                            </p>
                        </div>

                        <div class="alert alert-success border-0 mt-4">
                            <h5 class="mb-2">Your Submission Reference Number</h5>
                            <div class="display-6 fw-bold text-dark">
                                <?php echo htmlspecialchars($ref); ?>
                            </div>
                            <small class="text-muted">
                                Please keep this reference number for future communication.
                            </small>
                        </div>

                        <div class="mt-4">
                            <p>
                                A confirmation email has been  sent to the email provided.  
                                If you do not see it in your inbox, please check your spam folder.
                            </p>
                        </div>

                        <div class="d-flex justify-content-center gap-3 mt-4">
                            <a href="<?php echo BASE_URL; ?>" class="btn btn-outline-secondary px-4">
                                <i class="fas fa-home me-2"></i>Home
                            </a>
                            <a href="<?php echo BASE_URL; ?>pages/submit_abstract.php" class="btn btn-success px-4">
                                <i class="fas fa-plus me-2"></i>Submit Another Abstract
                            </a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
<?php if (isset($_SESSION['email_sent']) && $_SESSION['email_sent']): ?>
<div class="alert alert-success mt-4">
    <i class="fas fa-envelope me-2"></i>
    <strong>Confirmation Email Sent:</strong> A confirmation email has been sent to <?php echo htmlspecialchars($_SESSION['corresponding_email']); ?> with your submission details.
</div>
<?php elseif (isset($_SESSION['email_error'])): ?>
<div class="alert alert-warning mt-4">
    <i class="fas fa-exclamation-triangle me-2"></i>
    <strong>Note:</strong> Your submission was successful but we couldn't send the confirmation email. Please save your submission code for reference.
</div>
<?php endif; ?>
<?php require_once BASE_PATH . 'includes/footer.php'; ?>
