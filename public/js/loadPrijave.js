document.addEventListener("DOMContentLoaded", function() {
    const tabela = document.getElementById("api-prijave");
    const API_URL = "index.php?url=api/prijave";
    const STATUS_API = "index.php?url=korisnik/promeniStatus";

    async function ucitajPrijave() {
        try {
            showLoader();
            
            const response = await fetch(API_URL, {
                credentials: 'same-origin',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (!response.ok) throw new Error(`HTTP ${response.status}`);
            
            const data = await response.json();
            
            if (data.error) throw new Error(data.error);
            
            renderPrijave(data);
        } catch (error) {
            showError(error.message);
            console.error("Greška pri učitavanju:", error);
        } finally {
            hideLoader();
        }
    }

    function renderPrijave(prijave) {
        tabela.innerHTML = prijave.map(prijava => `
            <tr data-id="${prijava.id}">
                <td>${prijava.id}</td>
                <td>${prijava.opis || 'N/A'}</td>
                <td class="status-cell" data-status="${prijava.status}">
                    ${formatStatus(prijava.status)}
                </td>
                <td>${formatDatum(prijava.datum_prijave)}</td>
                <td>
                    <button class="btn-status" data-id="${prijava.id}" data-action="prihvaceno">
                        Prihvati
                    </button>
                    <button class="btn-status" data-id="${prijava.id}" data-action="zavrseno">
                        Završi
                    </button>
                </td>
            </tr>
        `).join('');

        initButtons();
    }

    function initButtons() {
        document.querySelectorAll('.btn-status').forEach(btn => {
            btn.addEventListener('click', function() {
                const { id, action } = this.dataset;
                if (confirm(`Promeniti status na ${action.toUpperCase()}?`)) {
                    promeniStatus(id, action);
                }
            });
        });
    }

    async function promeniStatus(id, status) {
        try {
            showLoader();
            
            const formData = new URLSearchParams();
            formData.append('id', id);
            formData.append('status', status);
            
            const response = await fetch(STATUS_API, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData,
                credentials: 'same-origin'
            });

            const contentType = response.headers.get('content-type');
            if (!contentType || !contentType.includes('application/json')) {
                const text = await response.text();
                throw new Error(`Server vratio: ${text.substring(0, 100)}`);
            }

            const result = await response.json();
            
            if (result.success) {
                updateStatus(id, status);
                showToast('Status uspešno ažuriran!');
            } else {
                throw new Error(result.error || 'Greška pri ažuriranju');
            }
        } catch (error) {
            console.error('Greška:', error);
            showToast(error.message, 'error');
        } finally {
            hideLoader();
        }
    }

    function updateStatus(id, newStatus) {
        const row = tabela.querySelector(`tr[data-id="${id}"]`);
        if (row) {
            const cell = row.querySelector('.status-cell');
            cell.dataset.status = newStatus;
            cell.innerHTML = formatStatus(newStatus);
        }
    }

    function formatStatus(status) {
        const statusMap = {
            'prihvaceno': '<span class="status-accepted">PRIHVAĆENO</span>',
            'zavrseno': '<span class="status-completed">ZAVRŠENO</span>',
            'default': '<span class="status-pending">NA ČEKANJU</span>'
        };
        return statusMap[status] || statusMap.default;
    }

    function formatDatum(datum) {
        return datum ? new Date(datum).toLocaleString('sr-RS') : 'N/A';
    }

    function showToast(message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = `toast ${type}`;
        toast.textContent = message;
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 3000);
    }

    function showLoader() {
        tabela.innerHTML = '<tr><td colspan="5" class="loading">Učitavanje...</td></tr>';
    }

    function hideLoader() {
        const loader = tabela.querySelector('.loading');
        if (loader) loader.remove();
    }

    function showError(message) {
        tabela.innerHTML = `<tr><td colspan="5" class="error">${message}</td></tr>`;
    }

    ucitajPrijave();
});