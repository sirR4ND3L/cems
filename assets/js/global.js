function showCustomConfirm(title, message, callback, options = {}) {
    const modal = document.getElementById('custom-modal');
    const cancelBtn = document.getElementById('btn-cancel');
    const confirmBtn = document.getElementById('btn-confirm');

    document.getElementById('modal-title').innerText = title;
    document.getElementById('modal-message').innerText = message;
    
    // Configure buttons based on options (useful for success alerts vs destructive confirms)
    confirmBtn.innerText = options.confirmText || 'Confirm';
    cancelBtn.style.display = options.hideCancel ? 'none' : 'inline-block';
    
    if (options.isSuccess) {
        confirmBtn.classList.remove('btn-delete');
        confirmBtn.classList.add('btn-edit'); // Professional Blue/Indigo style
    } else {
        confirmBtn.classList.add('btn-delete'); // Warning Red style
        confirmBtn.classList.remove('btn-edit');
    }

    modal.style.display = 'flex';
    
    cancelBtn.onclick = () => modal.style.display = 'none';
    confirmBtn.onclick = () => {
        modal.style.display = 'none';
        if (callback) callback();
    };
}

function filterEvents() {
    const input = document.getElementById("searchBar");
    if (!input) return;
    const filter = input.value.toLowerCase();
    const rows = document.querySelectorAll(".data-table tbody tr");
    rows.forEach(row => {
        const title = row.cells[0].innerText.toLowerCase();
        row.style.display = title.includes(filter) ? "" : "none";
    });
}

function deleteEvent(id, rowElement) {
    showCustomConfirm("Delete Event", "Are you sure you want to delete this event? This action cannot be undone.", async () => {
        await fetch(`../api/delete-event.php?id=${id}`);
        rowElement.remove();
    });
}

function copyLink(id) {
    const link = window.location.origin + "/CEMS/student/student-register-event.php?id=" + id;
    navigator.clipboard.writeText(link);

    showCustomConfirm(
        "Link Copied",
        "The event registration link has been copied to your clipboard.",
        null,
        { confirmText: "OK", hideCancel: true, isSuccess: true }
    );
}