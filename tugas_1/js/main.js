document.addEventListener("DOMContentLoaded", function () {
  // SET TAHUN OTOMATIS DI FOOTER
  const yearEl = document.getElementById("year");
  if (yearEl) {
    yearEl.textContent = new Date().getFullYear();
  }

  // DARK MODE (dengan penyimpanan preferensi)
  const darkToggle = document.getElementById("darkToggle");

  // Jika user sebelumnya aktifkan dark mode → aktifkan lagi
  if (localStorage.getItem("darkMode") === "enabled") {
    document.body.classList.add("dark-mode");
  }

  if (darkToggle) {
    darkToggle.addEventListener("click", () => {
      document.body.classList.toggle("dark-mode");

      // Simpan preferensi ke localStorage
      if (document.body.classList.contains("dark-mode")) {
        localStorage.setItem("darkMode", "enabled");
      } else {
        localStorage.removeItem("darkMode");
      }
    });
  }

  // MENU MOBILE (TOGGLE)
  const mainNav = document.getElementById("mainNav");
  const navToggle = document.getElementById("navToggle");

  if (navToggle) {
    navToggle.addEventListener("click", () => {
      mainNav.classList.toggle("show");
    });
  }

  // Tutup menu setelah klik link saat di HP
  document.querySelectorAll(".main-nav a").forEach((link) => {
    link.addEventListener("click", () => {
      if (window.innerWidth < 750) {
        mainNav.classList.remove("show");
      }
    });
  });

  // SMOOTH SCROLL UNTUK LINK ANCHOR
  document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener("click", function (e) {
      const target = document.querySelector(this.getAttribute("href"));
      if (target) {
        e.preventDefault();
        target.scrollIntoView({ behavior: "smooth", block: "start" });
      }
    });
  });

  // ANIMASI MUNCUL SAAT DI SCROLL
  const animElements = document.querySelectorAll(".anim");

  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add("inview");
        }
      });
    },
    { threshold: 0.15 }
  );

  animElements.forEach((el) => observer.observe(el));

  // LIGHTBOX GALERI
  const galleryItems = document.querySelectorAll(".m-item");

  galleryItems.forEach((img) => {
    img.addEventListener("click", () => {
      // Buat overlay gelap
      const overlay = document.createElement("div");
      overlay.className = "lightbox-overlay";
      overlay.style.cssText = `
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.9);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 2000;
        cursor: zoom-out;
      `;

      // Gambar besar
      const big = document.createElement("img");
      big.src = img.src;
      big.style.cssText = `
        max-width: 92%;
        max-height: 92%;
        border-radius: 12px;
        box-shadow: 0 0 20px rgba(255,255,255,0.2);
      `;

      overlay.appendChild(big);
      document.body.appendChild(overlay);

      // Tutup saat klik overlay
      overlay.addEventListener("click", () => overlay.remove());
    });
  });

  // EFEK PARALLAX DI BANNER (lembut)
  const banner = document.querySelector(".banner");

  if (banner) {
    banner.addEventListener("mousemove", (e) => {
      const rect = banner.getBoundingClientRect();
      const x = (e.clientX - rect.left) / rect.width - 0.5;
      const y = (e.clientY - rect.top) / rect.height - 0.5;

      banner.style.transform = `translate3d(${x * 10}px, ${y * 7}px, 0)`;
    });

    banner.addEventListener("mouseleave", () => {
      banner.style.transform = "";
    });
  }

  // AUTO CLOSE NAV SAAT RESIZE KE DESKTOP
  window.addEventListener("resize", () => {
    if (window.innerWidth >= 750) {
      mainNav.classList.remove("show");
    }
  });
});

// FORM PEMESANAN → KIRIM KE WHATSAPP
const formPemesanan = document.getElementById("formPemesanan");

if (formPemesanan) {
  formPemesanan.addEventListener("submit", function (e) {
    e.preventDefault();

    const nama = document.getElementById("nama").value;
    const wa = document.getElementById("wa").value;
    const paket = document.getElementById("paket").value;
    const tanggal = document.getElementById("tanggal").value;
    const catatan = document.getElementById("catatan").value;

    // Format pesan WA
    const pesan = `Halo Admin Situ Cipanten,
Saya ingin melakukan pemesanan wisata:

Nama: ${nama}
Nomor WA: ${wa}
Paket: ${paket}
Tanggal Kunjungan: ${tanggal}

Catatan:
${catatan}

Terima kasih.`;

    // Encode pesan WA
    const url = "https://wa.me/6281234567890?text=" + encodeURIComponent(pesan);

    // Buka WhatsApp
    window.open(url, "_blank");
  });
}
