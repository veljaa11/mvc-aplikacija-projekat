document.addEventListener("DOMContentLoaded", function() {
    const tabela = document.getElementById("api-prijave");
    const API_BASE = "/sup25/vk/public/index.php?url=";

    ucitajPrijave();

    async function ucitajPrijave() {
        try {
            const response = await fetch(`${API_BASE}api/prijave`);
            const data = await response.json();
            
            if (data.error) throw new Error(data.error);
            
            renderPrijave(data);
        } catch (error) {
            console.error("Greška pri učitavanju:", error);
            tabela.innerHTML = `<tr><td colspan="4">${error.message}</td></tr>`;
        }
    }

    function renderPrijave(prijave) {
        tabela.innerHTML = prijave.map(prijava => `
            <tr>
                <td>${prijava.id}</td>
                <td>${prijava.opis}</td>
                <td>${prijava.status}</td>
                <td>${prijava.datum_prijave}</td>
            </tr>
        `).join("");
    }
});
