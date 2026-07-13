<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
     <script src="https://cdn.datatables.net/2.3.8/js/dataTables.js"></script>
     <script src="https://cdn.datatables.net/2.3.8/js/dataTables.bootstrap5.js"></script>

     <script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js" integrity="sha384-rOA1PnstxnOBLzVIv3gi88pLM79OOERmoK7Doc5vOM53M51b7w1A0g6xoO8uJWX" crossorigin="anonymous"></script>

     <script src="https://cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>

    <script>
        CKEDITOR.replace('alamat', {
            filebrowserBrowseUrl: 'assets/ckfinder/ckfinder.html',
            filebrowserUploadUrl: 'assets/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
            height: '400px'
        });
    </script>

     <script>
        CKEDITOR.replace('alamat');
     </script>

     <script>
        $(document).ready(function () {
            $('#table').DataTable();
        });
     </script>
</body>

</html>