$(document).ready(function(){ // Ketika halaman sudah siap (sudah selesai di load)
	// Kita sembunyikan dulu untuk loadingnya
	$("#loading").hide();
	
	$("#provinsi").change(function(){ // Ketika user mengganti atau memilih data provinsi
		$("#kota").hide(); // Sembunyikan dulu combobox kota nya
		$("#loading").show(); // Tampilkan loadingnya
	
		$.ajax({
			type: "POST", // Method pengiriman data bisa dengan GET atau POST
			url: "{{ route('RegistersController.config') }}", // Isi dengan url/path file php yang dituju
			data: {provinsi : $("#provinsi").val()}, // data yang akan dikirim ke file yang dituju
			dataType: "json",
			success: function(response){ // Ketika proses pengiriman berhasil
				$("#loading").hide(); // Sembunyikan loadingnya

				// set isi dari combobox kota
				// lalu munculkan kembali combobox kotanya
				$("#kota").html(response.data_kota).show();
			},
			error: function (xhr, ajaxOptions, thrownError) { // Ketika ada error
				alert(thrownError); // Munculkan alert error
			}
		});
    });
});
