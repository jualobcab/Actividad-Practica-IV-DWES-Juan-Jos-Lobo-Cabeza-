    </main>
    <footer class='d-flex flex-wrap justify-content-center align-items-center py-3 my-4 border-top'>
        <div class='col-md-4 d-flex align-items-center justify-content-center'>
            <p class='mb-3 mb-md-0 text-body-secondary'>© 2024 Company, Inc</p>
        </div>
    </footer>
    <?php
        if (isset($_SESSION['mensaje'])){
            echo "<script>alert('".$_SESSION['mensaje']."');</script>";
            unset($_SESSION['mensaje']);
        }
    ?>
</body>