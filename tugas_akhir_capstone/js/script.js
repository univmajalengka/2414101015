function hitungTotal() {
  let hari = parseInt(document.getElementById("hari").value) || 0;
  let peserta = parseInt(document.getElementById("peserta").value) || 0;

  let hargaInap = document.getElementById("inap").checked ? 1000000 : 0;
  let hargaTransport = document.getElementById("transport").checked
    ? 1200000
    : 0;
  let hargaMakan = document.getElementById("makan").checked ? 500000 : 0;

  let hargaPaket = hargaInap + hargaTransport + hargaMakan;
  let totalTagihan = hari * peserta * hargaPaket;

  document.getElementById("harga_paket").value = hargaPaket;
  document.getElementById("total_tagihan").value = totalTagihan;
}

function validateForm() {
  let nama = document.getElementById("nama").value;
  let total = document.getElementById("total_tagihan").value;

  if (nama == "") {
    alert("Nama Pemesan Wajib Diisi!");
    return false;
  }
  if (total == 0 || total == "") {
    alert("Pilih minimal satu layanan paket (Penginapan/Transport/Makan)!");
    return false;
  }
  return true;
}

window.onload = function () {
  hitungTotal();
};
