    </div> <!-- Tutup container -->

    <footer style="background-color: #0D3B66;" class="border-top text-center mt-5 py-3 shadow-sm">
        <small style="color: white;">
            &copy; <?= date('Y') ?> LesTrack. Dibuat dengan ❤️ untuk pantau tugas anak Anda.
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