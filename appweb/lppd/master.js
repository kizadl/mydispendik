function bersihkan() {
	$("#lblhalaman").val("");
	$("#txttransid").val(""); $("#txttransketerangan").val(""); $("#txttransnmwilayah").val("");

	$("#txttransiddetailsekolah").val("");//// detail sekolah ////
	$("#txttransketkurikulum").val("");

	$(".lblkopgrafik1").text(""); $("#lblkopgrafik2").text("");
	$("#lblkopgrafik3").text(""); $("#lblkopgrafik4").text("");

	$("#area-halaman-utama").fadeOut("slow");
	$("#area-halaman-sekolah").fadeOut("slow");

	$("#area-peta").fadeOut("slow");
}