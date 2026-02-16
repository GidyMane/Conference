<!-- Footer -->
<footer class="footer bg-dark text-white pt-5 pb-4">
    <div class="container">
        <div class="row">
            <!-- About Column -->
            <div class="col-lg-4 col-md-6 mb-4">
                <h5 class="text-uppercase mb-4">
                    <i class="fas fa-seedling me-2"></i>KALRO Conference
                </h5>
                <p> 
                    The annual conference bringing together researchers, policymakers, 
                    and stakeholders in agricultural research for sustainable development.
                </p>
                <div class="social-icons mt-4">
                    <a href="#" class="text-white me-3"><i class="fab fa-twitter fa-lg"></i></a>
                    <a href="#" class="text-white me-3"><i class="fab fa-facebook fa-lg"></i></a>
                    <a href="#" class="text-white me-3"><i class="fab fa-linkedin fa-lg"></i></a>
                    <a href="#" class="text-white"><i class="fab fa-youtube fa-lg"></i></a>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="col-lg-2 col-md-6 mb-4">
                <h5 class="text-uppercase mb-4">Quick Links</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="/" class="text-white-50"><i class="fas fa-home me-1"></i>Home</a></li>
                    <li class="mb-2"><a href="/about" class="text-white-50"><i class="fas fa-info-circle me-1"></i>About</a></li>
                    <li class="mb-2"><a href="/conference-theme" class="text-white-50"><i class="fas fa-book-open me-1"></i>Conference Theme</a></li>
                    <li class="mb-2"><a href="/conference-procedure" class="text-white-50"><i class="fas fa-tasks me-1"></i>Procedure</a></li>
                    <li class="mb-2"><a href="/submit-abstract" class="text-white-50"><i class="fas fa-paper-plane me-1"></i>Submit Abstract</a></li>
                    <li class="mb-2"><a href="/conference/register" class="text-white-50"><i class="fas fa-user-plus me-1"></i>Register as Participant</a></li>
                    <li class="mb-2"><a href="/exhibition/register" class="text-white-50"><i class="fas fa-handshake me-1"></i>Become an Exhibitor</a></li>
                </ul>
            </div>

            <!-- Important Dates -->
            <div class="col-lg-3 col-md-6 mb-4">
                <h5 class="text-uppercase mb-4">Important Dates</h5>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <small>Abstract Submission:</small><br>
                        <span class="text-success">Feb 13, 2026</span>
                    </li>
                    
                    <li>
                        <small>Conference Dates:</small><br>
                        <span class="text-success">18th to 22nd May 2026</span>
                    </li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div class="col-lg-3 col-md-6 mb-4">
                <h5 class="text-uppercase mb-4">Contact Us</h5>
                <address>
                    <p class="mb-2">
                        <i class="fas fa-map-marker-alt me-2"></i>
                        KALRO Headquarters,<br>
                        <span class="ms-4">Nairobi, Kenya</span>
                    </p>
                    <p class="mb-2">
                        <i class="fas fa-phone me-2"></i>
                        <a href="tel:+254800721741" class="text-white-50">0800 721741</a>
                    </p>
                    <p class="mb-2">
                        <i class="fas fa-envelope me-2"></i>
                        <a href="mailto:kalroconference2026@gmail.com" class="text-white-50">kalroconference2026@gmail.com</a>
                    </p>
                </address>
            </div>
        </div>

        <hr class="mb-4" style="border-color: rgba(255,255,255,0.1);">

        <!-- Copyright -->
        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start">
                <p class="mb-0">&copy; <?php echo date('Y'); ?> KALRO Conference. All Rights Reserved.</p>
            </div>
            <div class="col-md-6 text-center text-md-end">
                <p class="mb-0">
                    <a href="#" class="text-white-50 me-3">Privacy Policy</a>
                    <a href="#" class="text-white-50">Terms of Use</a>
                </p>
            </div>
        </div>
    </div>
</footer>

<!-- Back to Top Button -->
<a href="#" class="back-to-top" id="backToTop">
    <i class="fas fa-chevron-up"></i>
</a>

<!-- Bootstrap JS Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Custom JavaScript -->
<script>
    // Back to Top Button
    const backToTop = document.getElementById('backToTop');
    window.addEventListener('scroll', () => {
        if (window.pageYOffset > 300) {
            backToTop.classList.add('visible');
        } else {
            backToTop.classList.remove('visible');
        }
    });

    backToTop.addEventListener('click', (e) => {
        e.preventDefault();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });

    // Carousel auto-play
    document.addEventListener('DOMContentLoaded', function() {
        const myCarousel = document.getElementById('mainCarousel');
        if (myCarousel) {
            const carousel = new bootstrap.Carousel(myCarousel, {
                interval: 5000,
                wrap: true
            });
        }
    });

    // Navbar scroll effect
    window.addEventListener('scroll', function() {
        const navbar = document.querySelector('.kalro-nav');
        if (window.scrollY > 100) {
            navbar.classList.add('navbar-scrolled');
        } else {
            navbar.classList.remove('navbar-scrolled');
        }
    });

    // Objective cards hover effect
    document.addEventListener('DOMContentLoaded', function() {
        const objectiveCards = document.querySelectorAll('.objective-card');
        objectiveCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-10px)';
                this.style.boxShadow = '0 8px 25px rgba(0,0,0,0.15)';
            });
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = '0 4px 15px rgba(0,0,0,0.1)';
            });
        });
    });
</script>
