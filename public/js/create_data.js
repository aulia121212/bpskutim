document.addEventListener("DOMContentLoaded", function () {
    const indikator = document.getElementById("indikator");
    const judul = document.getElementById("judul");

    const kecilEl = document.getElementById("kecil");
    const besarEl = document.getElementById("besar");
    const tetapEl = document.getElementById("tetap");
    const preview = document.getElementById("preview");

    // ===============================
    // FILTER JUDUL BERDASARKAN INDIKATOR
    // ===============================
    indikator.addEventListener("change", function () {
        const value = this.value;

        // reset judul
        judul.innerHTML = "";

        if (!value) {
            judul.disabled = true;
            judul.innerHTML = `<option>-- Pilih indikator dulu --</option>`;
            preview.style.display = "none";
            return;
        }

        // enable select
        judul.disabled = false;

        // default option
        judul.innerHTML = `<option value="">-- Pilih Judul --</option>`;

        // filter data
        const filtered = ALL_TITLES.filter(
            (item) => item.indikator_data === value,
        );

        filtered.forEach((item) => {
            const option = document.createElement("option");
            option.value = item.id;
            option.textContent = item.judul_data;
            judul.appendChild(option);
        });
    });

    // ===============================
    // FETCH INTERPRETASI
    // ===============================
    judul.addEventListener("change", async function () {
        const id = this.value;

        if (!id) {
            preview.style.display = "none";
            return;
        }

        try {
            const res = await fetch(`/api/statistic-titles/${id}`);
            const data = await res.json();

            kecilEl.textContent = data.interpretasi_lebih_kecil || "-";
            besarEl.textContent = data.interpretasi_lebih_besar || "-";
            tetapEl.textContent = data.interpretasi_tetap || "-";

            preview.style.display = "block";
        } catch (err) {
            console.error(err);
        }
    });
});
