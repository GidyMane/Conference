@extends('layouts.header')

@section('title')
    Submit Abstract
@endsection

@section('content')

    <!-- Page Header -->
    <section class="page-header bg-success text-white py-4">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1 class="display-5 fw-bold mb-3">
                        <i class="fas fa-paper-plane me-3"></i>Abstract Submission
                    </h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="/" class="text-white-50">Home</a></li>
                            <li class="breadcrumb-item active text-white" aria-current="page">Submit Abstract</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <!-- Submission Guidelines -->
    <section class="submission-guidelines py-4 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-info border-0">
                        <div class="d-flex">
                            <div class="me-3">
                                <i class="fas fa-info-circle fa-2x"></i>
                            </div>
                            <div>
                                <h5 class="alert-heading mb-2">Submission Guidelines</h5>
                                <ul class="mb-0">
                                    <li>Abstracts must not exceed 300 words</li>
                                    <li>All fields marked with <span class="text-danger">*</span> are required</li>
                                    <li>Ensure all author information is accurate</li>
                                    <li>You will receive a confirmation email upon successful submission</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Success Message (if redirected back) -->
    {{--
        @if($submitted)
            <div class="container mt-4">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    <strong>Success!</strong> Your abstract has been submitted successfully. You will receive a confirmation email shortly.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif

        <!-- Error Message -->
        @if($error_message)
            <div class="container mt-4">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <strong>Error!</strong> {{ $error_message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif

    --}}

    <!-- Main Form -->
    <section class="abstract-submission py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="form-card p-4 p-md-5 rounded shadow-sm">
                        <div class="text-center mb-5">
                            <h2 class="h1 mb-3 text-success">
                                <i class="fas fa-file-alt me-2"></i>Abstract Submission Form
                            </h2>
                            <p class="text-muted">Submit your research abstract for the KALRO SEPD Conference 2024</p>
                        </div>

                        <form id="abstractForm" method="POST" action="" novalidate>
                            <input type="hidden" name="submission_id" value="">
                            
                            <!-- Section 1: Corresponding Author Information -->
                            <div class="section-card mb-5">
                                <div class="section-header mb-4">
                                    <h3 class="h4 mb-2 text-success">
                                        <span class="section-number">1</span>
                                        Corresponding Author Information
                                    </h3>
                                    <p class="text-muted mb-0">Primary contact for this submission</p>
                                </div>
                                
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="corresponding_name" name="corresponding_name" 
                                                placeholder="Full Name" required>
                                            <label for="corresponding_name">Full Name <span class="text-danger">*</span></label>
                                            <div class="invalid-feedback">Please enter the corresponding author's full name.</div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="email" class="form-control" id="corresponding_email" name="corresponding_email" 
                                                placeholder="Email Address" required>
                                            <label for="corresponding_email">Email Address <span class="text-danger">*</span></label>
                                            <div class="invalid-feedback">Please enter a valid email address.</div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="tel" class="form-control" id="corresponding_phone" name="corresponding_phone" 
                                                placeholder="Phone Number" required>
                                            <label for="corresponding_phone">Phone Number <span class="text-danger">*</span></label>
                                            <div class="form-text">Format: +254728463410 or 0728463410</div>
                                            <div class="invalid-feedback">Please enter a valid Kenyan phone number (e.g., +254728463410 or 0728463410).</div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="organization" name="organization" 
                                                placeholder="Organization/Institution" required>
                                            <label for="organization">Organization/Institution <span class="text-danger">*</span></label>
                                            <div class="invalid-feedback">Please enter your organization name.</div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="department" name="department" 
                                                placeholder="Department">
                                            <label for="department">Department</label>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="position" name="position" 
                                                placeholder="Position/Title">
                                            <label for="position">Position/Title</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Section 2: Submission Details -->
                            <div class="section-card mb-5">
                                <div class="section-header mb-4">
                                    <h3 class="h4 mb-2 text-success">
                                        <span class="section-number">2</span>
                                        Submission Details
                                    </h3>
                                    <p class="text-muted mb-0">Information about your submission</p>
                                </div>
                                
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <select class="form-select" id="submission_type" name="submission_type" required>
                                                <option value="" selected disabled>Select Submission Type</option>
                                                <option value="abstract">Abstract Submission</option>
                                                <option value="full_paper" disabled>Full Paper Submission</option>
                                                <option value="final_paper" disabled>Final Version of Accepted Paper</option>
                                                <option value="presentation" disabled>Pre-recorded Presentation</option>
                                                <option value="poster" disabled>Poster Submission</option>
                                            </select>
                                            <label for="submission_type">Submission Type <span class="text-danger">*</span></label>
                                            <div class="form-text">Only abstract submissions are currently open</div>
                                            <div class="invalid-feedback">Please select a submission type.</div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <select class="form-select" id="sub_theme" name="sub_theme" required>
                                                <option value="" selected disabled>Select Sub-theme</option>
                                                <option value="cropVarieties">Crop Varieties and Integrated Production Management</option>
                                                <option value="seedSystems">Sustainable Seed Systems and Quality Assurance</option>
                                                <option value="cropProtection">Diagnostics, Surveillance and Phytosanitary Measures</option>
                                                <option value="soilHealth">Plant Nutrition, Soil Health and Conservation Agriculture</option>
                                                <option value="waterSystems">Water Harvesting, Conservation and Irrigation Systems</option>
                                                <option value="organicCircular">Ecological Organic Farming, Renewable Energy and Circular Economy</option>
                                                <option value="climateLand">Climate Change, Land Degradation and Reclamation</option>
                                                <option value="agrodiversity">Agrodiversity and Genetic Resources</option>
                                                <option value="animalFeeds">Animal Feed Resources, Nutrition and Husbandry Practices</option>
                                                <option value="livestockBreeding">Livestock Breeds, Breeding Practices and Emerging Species</option>
                                                <option value="animalHealth">Animal Health, Sanitary Systems and Emerging Diseases</option>
                                                <option value="apiculture">Apiculture, Beneficial Insects and Ecosystem Services</option>
                                                <option value="biotechnology">Biotechnological Solutions for Agriculture and Natural Resources</option>
                                                <option value="foodSafety">Food Safety, Value Addition and Cottage Industries</option>
                                                <option value="mechanization">Mechanization in Agricultural Systems</option>
                                                <option value="techTransfer">Technology Transfer, ICT and Precision Agriculture Systems</option>
                                                <option value="agribusiness">Agribusiness Models, Financing, Policy and Entrepreneurship</option>
                                            </select>
                                            <label for="sub_theme">Conference Sub-theme <span class="text-danger">*</span></label>
                                            <div class="invalid-feedback">Please select a sub-theme.</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Section 3: Paper Information -->
                            <div class="section-card mb-5">
                                <div class="section-header mb-4">
                                    <h3 class="h4 mb-2 text-success">
                                        <span class="section-number">3</span>
                                        Paper Information
                                    </h3>
                                    <p class="text-muted mb-0">Details about your research paper</p>
                                </div>
                                
                                <div class="mb-4">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="paper_title" name="paper_title" 
                                            placeholder="Paper Title" required>
                                        <label for="paper_title">Paper Title <span class="text-danger">*</span></label>
                                        <div class="invalid-feedback">Please enter your paper title.</div>
                                    </div>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="abstract" class="form-label fw-semibold">
                                        Abstract <span class="text-danger">*</span>
                                        <span class="text-muted fw-normal">(Maximum 300 words)</span>
                                    </label>
                                    <textarea class="form-control" id="abstract" name="abstract" rows="6" 
                                            placeholder="Enter your abstract here..." required></textarea>
                                    <div class="d-flex justify-content-between align-items-center mt-2">
                                        <div>
                                            <span id="wordCount" class="badge bg-light text-dark">0 words</span>
                                            <span id="wordLimit" class="badge bg-light text-dark">Limit: 300 words</span>
                                        </div>
                                        <div id="abstractStatus" class="text-muted small"></div>
                                    </div>
                                    <div class="invalid-feedback">Please enter your abstract (maximum 300 words).</div>
                                </div>
                                
                                <div class="mb-3">
                                    <div class="form-floating">
                                        <textarea class="form-control" id="keywords" name="keywords" 
                                                placeholder="Keywords (comma separated)" style="height: 100px"></textarea>
                                        <label for="keywords">Keywords</label>
                                        <div class="form-text">Separate keywords with commas (e.g., climate-smart, agriculture, sustainability)</div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Section 4: Co-Authors -->
                            <div class="section-card mb-5">
                                <div class="section-header mb-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h3 class="h4 mb-2 text-success">
                                                <span class="section-number">4</span>
                                                Co-Authors Information
                                            </h3>
                                            <p class="text-muted mb-0">Add all authors in order of contribution</p>
                                        </div>
                                        <button type="button" class="btn btn-outline-success btn-sm" id="addAuthorBtn">
                                            <i class="fas fa-user-plus me-1"></i> Add Author
                                        </button>
                                    </div>
                                </div>
                                
                                <div id="authorsContainer">
                                    <!-- Author 1 (Corresponding Author - Hidden fields) -->
                                    <div class="author-card mb-3 p-3 border rounded" data-author-index="1">
                                        <div class="row g-3 align-items-end">
                                            <div class="col-md-2">
                                                <div class="author-order">
                                                    <span class="badge bg-success">1</span>
                                                    <small class="text-muted d-block mt-1">Author</small>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control author-name" 
                                                        name="authors[1][name]" 
                                                        id="author1_name"
                                                        placeholder="Author Name" 
                                                        value=""
                                                        readonly
                                                        style="background-color: #f8f9fa;">
                                                    <label for="author1_name">Author Name</label>
                                                    <div class="form-text small">Auto-filled from corresponding author</div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control author-institution" 
                                                        name="authors[1][institution]" 
                                                        id="author1_institution"
                                                        placeholder="Institution" 
                                                        value=""
                                                        readonly
                                                        style="background-color: #f8f9fa;">
                                                    <label for="author1_institution">Institution</label>
                                                    <div class="form-text small">Auto-filled from organization</div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" 
                                                        name="authors[1][corresponding]" 
                                                        id="author1_corresponding" 
                                                        checked 
                                                        value="on">
                                                    <label class="form-check-label small" for="author1_corresponding">
                                                        Corresponding
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="text-center mt-3">
                                    <p class="text-muted small">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Author 1 is automatically set as the corresponding author. Add more authors below.
                                    </p>
                                </div>
                            </div>
                            
                            <!-- Section 5: Additional Information -->
                            <div class="section-card mb-5">
                                <div class="section-header mb-4">
                                    <h3 class="h4 mb-2 text-success">
                                        <span class="section-number">5</span>
                                        Additional Information
                                    </h3>
                                    <p class="text-muted mb-0">Optional details for your submission</p>
                                </div>
                                
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <select class="form-select" id="presentation_preference" name="presentation_preference">
                                                <option value="" selected>No preference</option>
                                                <option value="oral">Oral Presentation</option>
                                                <option value="poster">Poster Presentation</option>
                                                <option value="either">Either Oral or Poster</option>
                                            </select>
                                            <label for="presentation_preference">Presentation Preference</label>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <select class="form-select" id="attendance_mode" name="attendance_mode">
                                                <option value="" selected>Not specified</option>
                                                <option value="in_person">In-person Attendance</option>
                                                <option value="virtual">Virtual Attendance</option>
                                            </select>
                                            <label for="attendance_mode">Preferred Attendance Mode</label>
                                        </div>
                                    </div>
                                    
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <textarea class="form-control" id="special_requirements" name="special_requirements" 
                                                    placeholder="Any special requirements or comments" style="height: 100px"></textarea>
                                            <label for="special_requirements">Special Requirements or Comments</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Terms and Conditions -->
                            <div class="mb-5">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="terms" name="terms" required value="on">
                                    <label class="form-check-label" for="terms">
                                        I confirm that this abstract is original work and has not been published previously.
                                        I agree to the <a href="#" target="_blank">Terms and Conditions</a>.
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="invalid-feedback">You must agree to the terms and conditions.</div>
                                </div>
                            </div>
                            
                            <!-- Submit Button -->
                            <div class="text-center">
                                <button type="submit" class="btn btn-success btn-lg px-5" id="submitBtn" disabled>
                                    <i class="fas fa-paper-plane me-2"></i>
                                    Submit Abstract
                                </button>
                                <button type="reset" class="btn btn-outline-secondary btn-lg ms-3" id="resetBtn">
                                    <i class="fas fa-redo me-2"></i>
                                    Reset Form
                                </button>
                            </div>
                            
                            <!-- Progress Indicator -->
                            <div class="mt-4">
                                <div class="progress" style="height: 5px;">
                                    <div class="progress-bar bg-success" id="formProgress" style="width: 0%"></div>
                                </div>
                                <div class="text-center mt-2">
                                    <small class="text-muted" id="progressText">Form completeness: 0%</small>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Template for new author -->
    <template id="authorTemplate">
        <div class="author-card mb-3 p-3 border rounded" data-author-index="{index}">
            <div class="row g-3 align-items-end">
                <div class="col-md-2">
                    <div class="author-order">
                        <span class="badge bg-secondary">{order}</span>
                        <small class="text-muted d-block mt-1">Author</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating">
                        <input type="text" class="form-control author-name" 
                            name="authors[{index}][name]" 
                            placeholder="Author Name">
                        <label>Author Name</label>
                        <div class="invalid-feedback">Please enter author name.</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating">
                        <input type="text" class="form-control author-institution" 
                            name="authors[{index}][institution]" 
                            placeholder="Institution">
                        <label>Institution</label>
                        <div class="invalid-feedback">Please enter institution.</div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="d-flex gap-2">
                        <div class="form-check">
                            <input class="form-check-input corresponding-checkbox" type="checkbox" 
                                name="authors[{index}][corresponding]" 
                                id="author{index}_corresponding"
                                value="on">
                            <label class="form-check-label small" for="author{index}_corresponding">
                                Corresponding
                            </label>
                        </div>
                        <button type="button" class="btn btn-outline-danger btn-sm remove-author" 
                                data-bs-toggle="tooltip" title="Remove author">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </template>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('abstractForm');
    const submitBtn = document.getElementById('submitBtn');
    const addAuthorBtn = document.getElementById('addAuthorBtn');
    const authorsContainer = document.getElementById('authorsContainer');
    const authorTemplate = document.getElementById('authorTemplate').innerHTML;
    const abstractTextarea = document.getElementById('abstract');
    const wordCountElement = document.getElementById('wordCount');
    const abstractStatus = document.getElementById('abstractStatus');
    const progressBar = document.getElementById('formProgress');
    const progressText = document.getElementById('progressText');
    const phoneInput = document.getElementById('corresponding_phone');
    const correspondingNameInput = document.getElementById('corresponding_name');
    const organizationInput = document.getElementById('organization');
    const resetBtn = document.getElementById('resetBtn');
    const author1NameInput = document.getElementById('author1_name');
    const author1InstitutionInput = document.getElementById('author1_institution');
    const author1Checkbox = document.getElementById('author1_corresponding');

    let authorCount = 1; // corresponding author already exists

    // Update first author info
    function updateFirstAuthor() {
        if (author1NameInput) {
            const name = correspondingNameInput.value.trim();
            author1NameInput.value = name;
            // Also set value attribute for form submission
            author1NameInput.setAttribute('value', name);
        }
        if (author1InstitutionInput) {
            const institution = organizationInput.value.trim();
            author1InstitutionInput.value = institution;
            author1InstitutionInput.setAttribute('value', institution);
        }
    }
    
    correspondingNameInput.addEventListener('input', updateFirstAuthor);
    organizationInput.addEventListener('input', updateFirstAuthor);

    // Add new author
    addAuthorBtn.addEventListener('click', function() {
        authorCount++;
        const html = authorTemplate
            .replace(/{index}/g, authorCount)
            .replace(/{order}/g, authorCount);
        const tempDiv = document.createElement('div');
        tempDiv.innerHTML = html;
        const newAuthor = tempDiv.firstElementChild;
        authorsContainer.appendChild(newAuthor);

        // Remove author
        newAuthor.querySelector('.remove-author').addEventListener('click', function() {
            if (confirm('Remove this author?')) {
                newAuthor.remove();
                renumberAuthors();
                calculateFormProgress();
            }
        });

        // Handle corresponding author checkbox
        const newCheckbox = newAuthor.querySelector('.corresponding-checkbox');
        if (newCheckbox) {
            newCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    // Uncheck all other corresponding checkboxes
                    document.querySelectorAll('.corresponding-checkbox').forEach(cb => {
                        if (cb !== this) cb.checked = false;
                    });
                    // Also uncheck first author if it's not this one
                    if (author1Checkbox && author1Checkbox !== this) {
                        author1Checkbox.checked = false;
                    }
                }
            });
        }

        renumberAuthors();
        calculateFormProgress();
    });

    // Handle first author checkbox change
    if (author1Checkbox) {
        author1Checkbox.addEventListener('change', function() {
            if (this.checked) {
                // Uncheck all other corresponding checkboxes
                document.querySelectorAll('.corresponding-checkbox').forEach(cb => {
                    if (cb !== this) cb.checked = false;
                });
            }
        });
    }

    // Renumber authors
    function renumberAuthors() {
        const authorCards = authorsContainer.querySelectorAll('.author-card');
        authorCards.forEach((card, i) => {
            const idx = i + 1;
            card.dataset.authorIndex = idx;
            const badge = card.querySelector('.badge');
            if (badge) {
                badge.textContent = idx;
                badge.className = idx === 1 ? 'badge bg-success' : 'badge bg-secondary';
            }
            
            const inputs = card.querySelectorAll('input');
            inputs.forEach(input => {
                input.name = input.name.replace(/authors\[\d+\]/, `authors[${idx}]`);
                if (input.id) {
                    input.id = input.id.replace(/author\d+/, `author${idx}`);
                }
            });
            
            const labels = card.querySelectorAll('label[for^="author"]');
            labels.forEach(label => {
                label.htmlFor = label.htmlFor.replace(/author\d+/, `author${idx}`);
            });
        });
        authorCount = authorCards.length;
    }

    // Word count for abstract
    function countWords(text) {
        return text.trim().split(/\s+/).filter(w => w.length > 0).length;
    }
    
    abstractTextarea.addEventListener('input', function() {
        const words = countWords(this.value);
        const maxWords = 300;
        wordCountElement.textContent = `${words} words`;
        if (words > maxWords) {
            wordCountElement.className = 'badge bg-danger text-white';
            abstractStatus.textContent = `⚠️ ${words - maxWords} words over limit`;
            abstractStatus.className = 'text-danger';
            this.classList.add('is-invalid');
        } else if (words > 0) {
            wordCountElement.className = 'badge bg-success text-white';
            abstractStatus.textContent = `✓ ${maxWords - words} words remaining`;
            abstractStatus.className = 'text-success';
            this.classList.remove('is-invalid');
        } else {
            wordCountElement.className = 'badge bg-light text-dark';
            abstractStatus.textContent = '';
            this.classList.remove('is-invalid');
        }
        calculateFormProgress();
    });

    // Phone validation
    function validatePhone(phone) {
        const cleaned = phone.replace(/\s+/g, '');
        return /^(\+?254|0)[17]\d{8}$/.test(cleaned);
    }
    
    phoneInput.addEventListener('input', function() {
        if (this.value.trim() === '') {
            this.classList.remove('is-valid', 'is-invalid');
        } else if (validatePhone(this.value)) {
            this.classList.add('is-valid');
            this.classList.remove('is-invalid');
        } else {
            this.classList.add('is-invalid');
            this.classList.remove('is-valid');
        }
        calculateFormProgress();
    });

    // Calculate form progress
    function calculateFormProgress() {
        // Get only the original required fields (not dynamically added author fields)
        const originalRequiredFields = form.querySelectorAll(
            '#corresponding_name[required], ' +
            '#corresponding_email[required], ' +
            '#corresponding_phone[required], ' +
            '#organization[required], ' +
            '#submission_type[required], ' +
            '#sub_theme[required], ' +
            '#paper_title[required], ' +
            '#abstract[required], ' +
            '#terms[required]'
        );
        
        let filled = 0;
        originalRequiredFields.forEach(f => {
            if (f.type === 'checkbox') {
                if (f.checked) filled++;
            } else if (f.value.trim() !== '') {
                filled++;
            }
        });

        // Abstract validation (max 300 words)
        const wordCount = countWords(abstractTextarea.value);
        const abstractValid = wordCount > 0 && wordCount <= 300;
        
        // Phone validation
        const phoneValid = validatePhone(phoneInput.value);
        
        // Calculate progress
        const baseProgress = (filled / originalRequiredFields.length) * 80;
        const totalProgress = Math.min(baseProgress + (abstractValid ? 20 : 0), 100);
        progressBar.style.width = totalProgress + '%';
        progressText.textContent = `Form completeness: ${Math.round(totalProgress)}%`;

        // Enable submit only if original required fields are filled AND abstract is valid AND phone is valid
        const allOriginalFieldsFilled = filled === originalRequiredFields.length;
        submitBtn.disabled = !(allOriginalFieldsFilled && abstractValid && phoneValid);
    }

    // Form submission
    form.addEventListener('submit', function(e) {
        // Update first author before submission
        updateFirstAuthor();
        
        // Validate original required fields
        let isValid = true;
        
        // Check original required fields
        const requiredFields = [
            correspondingNameInput,
            document.getElementById('corresponding_email'),
            phoneInput,
            organizationInput,
            document.getElementById('submission_type'),
            document.getElementById('sub_theme'),
            document.getElementById('paper_title'),
            abstractTextarea,
            document.getElementById('terms')
        ];
        
        requiredFields.forEach(field => {
            if (field.type === 'checkbox') {
                if (!field.checked) {
                    isValid = false;
                    field.classList.add('is-invalid');
                }
            } else if (field.value.trim() === '') {
                isValid = false;
                field.classList.add('is-invalid');
            }
        });
        
        // Validate abstract word count
        const wordCount = countWords(abstractTextarea.value);
        if (wordCount === 0 || wordCount > 300) {
            isValid = false;
            abstractTextarea.classList.add('is-invalid');
        }
        
        // Validate phone
        if (!validatePhone(phoneInput.value)) {
            isValid = false;
            phoneInput.classList.add('is-invalid');
        }
        
        if (!isValid) {
            e.preventDefault();
            e.stopPropagation();
            form.classList.add('was-validated');
            
            // Scroll to first error
            const firstError = form.querySelector('.is-invalid');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                firstError.focus();
            }
            return;
        }
        
        // If valid, show loading state
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Submitting...';
        submitBtn.disabled = true;
    });

    // Reset form handler
    resetBtn.addEventListener('click', function() {
        // Remove all added authors except the first one
        const authorCards = authorsContainer.querySelectorAll('.author-card');
        authorCards.forEach((card, index) => {
            if (index > 0) { // Keep only the first author
                card.remove();
            }
        });
        
        // Reset author count
        authorCount = 1;
        
        // Reset first author fields
        if (author1NameInput) author1NameInput.value = '';
        if (author1InstitutionInput) author1InstitutionInput.value = '';
        if (author1Checkbox) {
            author1Checkbox.checked = true;
        }
        
        // Reset form validation
        form.classList.remove('was-validated');
        form.querySelectorAll('.is-invalid, .is-valid').forEach(el => {
            el.classList.remove('is-invalid', 'is-valid');
        });
        
        // Reset word count display
        wordCountElement.textContent = '0 words';
        wordCountElement.className = 'badge bg-light text-dark';
        abstractStatus.textContent = '';
        
        // Reset progress bar
        setTimeout(() => {
            calculateFormProgress();
        }, 100);
    });

    // Attach validation listeners
    form.querySelectorAll('input, select, textarea').forEach(f => {
        f.addEventListener('input', calculateFormProgress);
        f.addEventListener('change', calculateFormProgress);
    });

    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Initial setup
    updateFirstAuthor();
    calculateFormProgress();
});
</script>

@endsection