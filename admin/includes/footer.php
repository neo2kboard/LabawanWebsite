
            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span></span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->
         

</body>

</html>

<script>
document.getElementById('password_toggle').addEventListener('click', function() {
    var passwordField = document.getElementById('edit_password');
    var icon = document.getElementById('toggle_icon');
    
    // Toggle the type of the password field between 'password' and 'text'
    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');  // Change icon to "eye-slash" when password is visible
    } else {
        passwordField.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');  // Change back to "eye" when password is hidden
    }
});
</script>
