$('.select2-produk').select2({
    theme: 'bootstrap-5',
    placeholder: 'Ketikkan nama barang/produk',
    allowClear: true,
    width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
    minimumInputLength: 1, // Agar pencarian hanya dimulai setelah 1 karakter
    ajax: {
        dataType: 'json',
        url: './app/produk/select2.php', // Ganti dengan URL endpoint server yang benar
        data: function (params) {
            return {
                search: params.term // Mengirimkan parameter pencarian
            };
        },
        processResults: function (data, page) {
            return {
                results: data // Menangani data hasil dari server
            };
        },
    }
}).on('select2:select', function (evt) {
    // Mendapatkan data yang dipilih dari event
    var selectedData = evt.params.data;
    console.log(selectedData); // Menampilkan data yang dipilih
    // Jika Anda ingin mendapatkan ID atau teks produk, Anda bisa melakukannya:
    var productId = selectedData.id;
    var productName = selectedData.text;
    console.log('ID Produk: ', productId);
    console.log('Nama Produk: ', productName);
});
