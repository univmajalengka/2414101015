document.addEventListener("DOMContentLoaded", () => {
  const modal = document.getElementById("product-modal");
  const modalClose = document.getElementById("modal-close");
  const modalImg = document.getElementById("modal-img");
  const modalName = document.getElementById("modal-name");
  const modalPrice = document.getElementById("modal-price");
  const modalLensa = document.getElementById("modal-lensa");
  const modalQty = document.getElementById("modal-qty");
  const addToCartBtn = document.getElementById("add-to-cart");

  const cartBtn = document.getElementById("cart-btn");
  const cartSidebar = document.getElementById("cart-sidebar");
  const closeCartBtn = document.getElementById("close-cart");
  const cartItemsContainer = document.getElementById("cart-items");
  const cartCountEl = document.getElementById("cart-count");
  const cartSubtotalEl = document.getElementById("cart-subtotal");

  const adminIcon = document.getElementById("admin-icon");
  const logo = document.querySelector(".logo");

  let currentProduct = { id: null, nama: null, harga: 0, gambar: null };

  // product cards open modal
  document.querySelectorAll(".produk-card").forEach((card) => {
    card.addEventListener("click", () => {
      currentProduct.id = card.dataset.id;
      currentProduct.nama = card.dataset.nama;
      currentProduct.harga = parseFloat(card.dataset.harga);
      currentProduct.gambar = card.dataset.gambar;

      modalImg.src = currentProduct.gambar;
      modalImg.alt = currentProduct.nama;
      modalName.textContent = currentProduct.nama;
      modalPrice.textContent =
        "Rp " + numberWithCommas(currentProduct.harga.toFixed(0));
      modalLensa.selectedIndex = 0;
      modalQty.value = 1;

      openModal();
    });
    card.addEventListener("keypress", (e) => {
      if (e.key === "Enter") card.click();
    });
  });

  function openModal() {
    modal.setAttribute("aria-hidden", "false");
    document.body.style.overflow = "hidden";
  }
  function closeModal() {
    modal.setAttribute("aria-hidden", "true");
    document.body.style.overflow = "";
  }
  modalClose.addEventListener("click", closeModal);
  document
    .querySelectorAll(".modal-backdrop")
    .forEach((b) => b.addEventListener("click", closeModal));

  document
    .getElementById("qty-inc")
    .addEventListener(
      "click",
      () => (modalQty.value = Math.max(1, parseInt(modalQty.value || 1) + 1))
    );
  document
    .getElementById("qty-dec")
    .addEventListener(
      "click",
      () => (modalQty.value = Math.max(1, parseInt(modalQty.value || 1) - 1))
    );

  addToCartBtn.addEventListener("click", async () => {
    const lensa = modalLensa.value;
    const jumlah = Math.max(1, parseInt(modalQty.value || 1));
    const payload = {
      aksi: "tambah",
      id: currentProduct.id,
      nama: currentProduct.nama,
      harga: currentProduct.harga,
      lensa,
      jumlah,
    };

    try {
      const res = await fetch("proses_keranjang.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(payload),
      });
      const data = await res.json();
      if (data.success) {
        showToast("Berhasil ditambahkan ke keranjang");
        updateCartCount(data.totalJumlah);
        closeModal();
        openCart();
        renderCart();
      } else alert("Gagal menambah ke keranjang");
    } catch (e) {
      console.error(e);
      alert("Terjadi kesalahan");
    }
  });

  cartBtn.addEventListener("click", () => {
    openCart();
    renderCart();
  });
  closeCartBtn.addEventListener("click", () => {
    closeCart();
  });

  function openCart() {
    cartSidebar.classList.add("open");
    cartSidebar.setAttribute("aria-hidden", "false");
    renderCart();
  }
  function closeCart() {
    cartSidebar.classList.remove("open");
    cartSidebar.setAttribute("aria-hidden", "true");
  }

  async function renderCart() {
    try {
      const res = await fetch("proses_keranjang.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ aksi: "lihat" }),
      });
      const data = await res.json();
      const items = data.items || [];
      cartItemsContainer.innerHTML = "";

      if (items.length === 0) {
        cartItemsContainer.innerHTML =
          '<p class="small muted">Keranjang kosong</p>';
        cartSubtotalEl.textContent = "Rp 0";
        updateCartCount(0);
        return;
      }

      let subtotal = 0;
      items.forEach((it) => {
        subtotal += it.harga * it.jumlah;
        const div = document.createElement("div");
        div.className = "cart-item";
        div.innerHTML = `
          <img src="images/placeholder.png" alt="">
          <div class="meta">
            <div class="title">${escapeHtml(it.nama)}</div>
            <div class="sub">Lensa: ${escapeHtml(it.lensa)} • ${
          it.jumlah
        } × Rp ${numberWithCommas(it.harga)}</div>
          </div>
          <div>
            <button class="remove-btn" data-id="${it.id}">Hapus</button>
          </div>
        `;
        // try to use product image from product card if present
        const prodCard = document.querySelector(
          `.produk-card[data-id="${it.id}"]`
        );
        if (prodCard) {
          const img = prodCard.querySelector("img");
          if (img) div.querySelector("img").src = img.src;
        }
        cartItemsContainer.appendChild(div);
      });

      cartSubtotalEl.textContent =
        "Rp " + numberWithCommas(subtotal.toFixed(0));
      cartItemsContainer.querySelectorAll(".remove-btn").forEach((btn) => {
        btn.addEventListener("click", async () => {
          const id = btn.dataset.id;
          const body = `aksi=hapus&id=${encodeURIComponent(id)}`;
          await fetch("proses_keranjang.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body,
          });
          setTimeout(() => {
            renderCart();
            fetchCartCount();
          }, 200);
        });
      });
    } catch (e) {
      console.error(e);
      cartItemsContainer.innerHTML =
        '<p class="small muted">Gagal memuat keranjang</p>';
    }
  }

  function updateCartCount(n) {
    if (cartCountEl) cartCountEl.textContent = parseInt(n || 0);
  }
  async function fetchCartCount() {
    try {
      const res = await fetch("proses_keranjang.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ aksi: "lihat" }),
      });
      const data = await res.json();
      const total = (data.items || []).reduce((s, i) => s + i.jumlah, 0);
      updateCartCount(total);
    } catch (e) {
      console.error(e);
    }
  }

  function showToast(text) {
    const t = document.createElement("div");
    t.className = "toast";
    t.textContent = text;
    document.body.appendChild(t);
    setTimeout(() => t.remove(), 1200);
  }
  function numberWithCommas(x) {
    if (!x) return "0";
    const n = parseInt(x, 10);
    return n.toLocaleString("id-ID");
  }
  function escapeHtml(s) {
    return String(s).replace(
      /[&<>"']/g,
      (m) =>
        ({
          "&": "&amp;",
          "<": "&lt;",
          ">": "&gt;",
          '"': "&quot;",
          "'": "&#39;",
        }[m])
    );
  }

  // admin icon toggle by clicking logo (one click show/hide)
  if (logo && adminIcon) {
    logo.addEventListener("click", () => {
      adminIcon.style.display =
        adminIcon.style.display === "inline-block" ? "none" : "inline-block";
    });
    adminIcon.addEventListener(
      "click",
      () => (window.location.href = "admin/login.php")
    );
  }

  // initial render cart count
  fetchCartCount();
});
// inside items.forEach(it=>{
const imgEl = div.querySelector("img");
if (it.gambar) {
  imgEl.src = "images/" + it.gambar;
} else {
  // fallback: use product card image if available
  const prodCard = document.querySelector(`.produk-card[data-id="${it.id}"]`);
  if (prodCard) {
    const img = prodCard.querySelector("img");
    if (img) imgEl.src = img.src;
  }
}
