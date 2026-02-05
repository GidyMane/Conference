<div class="modal fade" id="paperModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-file-pdf me-2"></i>Full Paper Details
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <!-- Paper Details -->
                <div class="paper-details">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong><i class="fas fa-hashtag me-2"></i>Abstract Code:</strong> 
                               <span id="modalAbstractCode" class="text-primary fw-bold"></span></p>
                            <p><strong><i class="fas fa-user me-2"></i>Author:</strong> 
                               <span id="modalAuthor"></span></p>
                            <p><strong><i class="fas fa-envelope me-2"></i>Email:</strong> 
                               <span id="modalEmail"></span></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong><i class="fas fa-tag me-2"></i>Sub-Theme:</strong> 
                               <span id="modalTheme" class="badge bg-secondary"></span></p>
                            <p><strong><i class="fas fa-circle me-2"></i>Status:</strong> 
                               <span id="modalStatus"></span></p>
                            <p><strong><i class="fas fa-calendar me-2"></i>Submitted:</strong> 
                               <span id="modalSubmitted"></span></p>
                        </div>
                    </div>
                    <p><strong><i class="fas fa-heading me-2"></i>Title:</strong></p>
                    <h5 id="modalTitle" class="text-primary"></h5>
                </div>

                <!-- Documents Section -->
                <div class="documents-section">
                    <h6 class="mb-3">
                        <i class="fas fa-folder-open me-2"></i>Submitted Documents
                    </h6>

                    <!-- Full Paper -->
                    <div id="paperDoc" class="document-item" style="display: none;">
                        <div class="document-info">
                            <div class="document-icon">
                                <i class="fas fa-file-pdf"></i>
                            </div>
                            <div class="document-meta">
                                <h6>Full Paper Document</h6>
                                <p>Main research paper (PDF/DOC/DOCX)</p>
                            </div>
                        </div>
                        <a id="paperDownload" href="#" class="btn btn-download btn-sm" target="_blank">
                            <i class="fas fa-download me-1"></i> Download
                        </a>
                    </div>

                    <!-- Presentation -->
                    <div id="presentationDoc" class="document-item" style="display: none;">
                        <div class="document-info">
                            <div class="document-icon">
                                <i class="fas fa-file-powerpoint text-danger"></i>
                            </div>
                            <div class="document-meta">
                                <h6>Presentation Slides</h6>
                                <p>PowerPoint presentation (PPT/PPTX)</p>
                            </div>
                        </div>
                        <a id="presentationDownload" href="#" class="btn btn-download btn-sm" target="_blank">
                            <i class="fas fa-download me-1"></i> Download
                        </a>
                    </div>

                    <!-- Supplementary -->
                    <div id="supplementaryDoc" class="document-item" style="display: none;">
                        <div class="document-info">
                            <div class="document-icon">
                                <i class="fas fa-paperclip text-warning"></i>
                            </div>
                            <div class="document-meta">
                                <h6>Supplementary Files</h6>
                                <p>Additional supporting documents</p>
                            </div>
                        </div>
                        <button class="btn btn-view btn-sm" onclick="alert('Supplementary files viewer coming soon')">
                            <i class="fas fa-eye me-1"></i> View Files
                        </button>
                    </div>

                    <div id="noDocuments" class="text-center text-muted py-3" style="display: none;">
                        <i class="fas fa-inbox fa-2x mb-2"></i>
                        <p>No documents uploaded yet</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.view-paper').forEach(btn => {
        btn.addEventListener('click', () => {
            const data = btn.dataset;
            
            // Set basic info
            document.getElementById('modalAbstractCode').textContent = data.abstractCode;
            document.getElementById('modalTitle').textContent = data.title;
            document.getElementById('modalAuthor').textContent = data.author;
            document.getElementById('modalEmail').textContent = data.email;
            document.getElementById('modalTheme').textContent = data.theme;
            document.getElementById('modalSubmitted').textContent = data.submitted;
            
            // Set status
            const statusEl = document.getElementById('modalStatus');
            const statusClass = data.status.toLowerCase().replace('_', '-');
            statusEl.className = `status-badge ${statusClass}`;
            statusEl.textContent = data.status.charAt(0).toUpperCase() + data.status.slice(1);
            
            // Show/hide documents
            const paperDoc = document.getElementById('paperDoc');
            const presentationDoc = document.getElementById('presentationDoc');
            const supplementaryDoc = document.getElementById('supplementaryDoc');
            const noDocuments = document.getElementById('noDocuments');
            
            let hasAnyDoc = false;
            
            if (data.hasPaper === '1') {
                paperDoc.style.display = 'flex';
                document.getElementById('paperDownload').href = data.paperUrl;
                hasAnyDoc = true;
            } else {
                paperDoc.style.display = 'none';
            }
            
            if (data.hasPresentation === '1') {
                presentationDoc.style.display = 'flex';
                document.getElementById('presentationDownload').href = data.presentationUrl;
                hasAnyDoc = true;
            } else {
                presentationDoc.style.display = 'none';
            }
            
            if (data.hasSupplementary === '1') {
                supplementaryDoc.style.display = 'flex';
                hasAnyDoc = true;
            } else {
                supplementaryDoc.style.display = 'none';
            }
            
            noDocuments.style.display = hasAnyDoc ? 'none' : 'block';
        });
    });
});
</script>
@endsection