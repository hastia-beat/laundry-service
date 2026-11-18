// Interaktivitas LaundryKu (Modul III: DOM, event listener, classList, validasi)

// 1. Notifikasi hilang otomatis (transition di style.css)
document.querySelectorAll("#notifikasi").forEach(function (kotak) {
    setTimeout(function () {
        kotak.classList.add("hilang");
        setTimeout(function () { kotak.remove(); }, 400);
    }, 5000);
});

// 2. Konfirmasi sebelum aksi penting (hapus, dll.)
document.querySelectorAll("[data-konfirmasi]").forEach(function (tombol) {
    tombol.addEventListener("click", function (e) {
        if (!confirm(tombol.dataset.konfirmasi)) {
            e.preventDefault();
        }
    });
});

// 3. Kalkulator estimasi biaya pada form pesan
const pilihLayanan = document.querySelector("#layanan");
const inputJumlah = document.querySelector("#jumlah");
const teksEstimasi = document.querySelector("#estimasi");
const teksSatuan = document.querySelector("#satuan");

function hitungEstimasi() {
    const opsi = pilihLayanan.options[pilihLayanan.selectedIndex];
    const harga = parseFloat(opsi.dataset.harga) || 0;
    const jumlah = Math.max(0, parseFloat(inputJumlah.value) || 0);
    teksEstimasi.innerHTML = "Rp" + (harga * jumlah).toLocaleString("id-ID");
    teksSatuan.innerHTML = opsi.dataset.satuan || "-";
}
if (pilihLayanan && inputJumlah && teksEstimasi) {
    pilihLayanan.addEventListener("change", hitungEstimasi);
    inputJumlah.addEventListener("input", hitungEstimasi);
    hitungEstimasi();
}

// 4. Validasi sisi klien form register (validasi mengikat tetap di server)
const formRegister = document.querySelector("#form-register");
if (formRegister) {
    formRegister.addEventListener("submit", function (e) {
        const pass = document.querySelector("#password").value;
        const konfirmasi = document.querySelector("#konfirmasi").value;
        const error = document.querySelector("#error-konfirmasi");
        if (pass.length < 6) {
            e.preventDefault();
            error.innerHTML = "Password minimal 6 karakter.";
        } else if (pass !== konfirmasi) {
            e.preventDefault();
            error.innerHTML = "Konfirmasi password tidak sesuai.";
        } else {
            error.innerHTML = "";
        }
    });
}
