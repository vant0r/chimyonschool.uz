    </main>
    
    <script>
        // Ripple effect for buttons
        document.querySelectorAll('.btn-admin').forEach(btn => {
            btn.addEventListener('click', function(e) {
                const ripple = document.createElement('span');
                ripple.classList.add('ripple');
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                ripple.style.width = ripple.style.height = size + 'px';
                ripple.style.left = (e.clientX - rect.left - size/2) + 'px';
                ripple.style.top = (e.clientY - rect.top - size/2) + 'px';
                this.appendChild(ripple);
                setTimeout(() => ripple.remove(), 600);
            });
        });
    </script>
</body>
</html>
