    </div> <!-- Tutup container -->

    <footer class="bg-white border-top text-center mt-5 py-3 shadow-sm">
        <small class="text-muted">
            &copy; <?= date('Y') ?> LesTrack. Dibuat dengan ❤️ untuk pendidikan anak.
        </small>
    </footer>

    <!-- Validasi Form -->
    <script>
(() => {
    'use strict'
    const forms = document.querySelectorAll('.needs-validation')
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }
            form.classList.add('was-validated')
        }, false)
    })
})()
    </script>
    </body>

    </html>