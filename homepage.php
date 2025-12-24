<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dolphin CRM</title>
  <link rel="stylesheet" href="layout.css">
  <link rel="stylesheet" href="contacts.css">
</head>
<body>

  <?php include 'sidebar.php'; ?>

  <div class="main-content">
    <div class="header-row">
      <h1>Dashboard</h1>
      <a class="add-user-btn" href="new-contact.php">+ Add Contact</a>
    </div>

    <div style="display:flex; gap:10px; margin-top:10px;">
      <button type="button" id="filterAll">All</button>
      <button type="button" id="filterSales">Sales Leads</button>
      <button type="button" id="filterSupport">Support</button>
      <button type="button" id="filterMine">Assigned to me</button>
    </div>

    <table>
      <thead>
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Company</th>
          <th>Type</th>
          <th></th>
        </tr>
      </thead>
      <tbody id="contactsBody">
        <tr><td colspan="5">Loading contacts...</td></tr>
      </tbody>
    </table>
  </div>

<script>
async function loadContacts(filter = "all") {
  const res = await fetch(`homepage_contacts.php?filter=${encodeURIComponent(filter)}`);
  const tbody = document.getElementById("contactsBody");

  if (!res.ok) {
    tbody.innerHTML = `<tr><td colspan="5">Error loading contacts.</td></tr>`;
    return;
  }

  const contacts = await res.json();
  tbody.innerHTML = "";

  if (!Array.isArray(contacts) || contacts.length === 0) {
    tbody.innerHTML = `<tr><td colspan="5">No contacts found.</td></tr>`;
    return;
  }

  contacts.forEach(c => {
    const tr = document.createElement("tr");
    tr.innerHTML = `
      <td>${escapeHtml(c.title)} ${escapeHtml(c.firstname)} ${escapeHtml(c.lastname)}</td>
      <td>${escapeHtml(c.email)}</td>
      <td>${escapeHtml(c.company)}</td>
      <td>${escapeHtml(c.type)}</td>
      <td><a href="contact-details.php?id=${encodeURIComponent(c.id)}">View</a></td>
    `;
    tbody.appendChild(tr);
  });
}

function escapeHtml(str) {
  return String(str ?? "")
    .replaceAll("&", "&amp;")
    .replaceAll("<", "&lt;")
    .replaceAll(">", "&gt;")
    .replaceAll('"', "&quot;")
    .replaceAll("'", "&#039;");
}

document.addEventListener("DOMContentLoaded", () => {
  loadContacts("all");
  document.getElementById("filterAll").onclick = () => loadContacts("all");
  document.getElementById("filterSales").onclick = () => loadContacts("sales");
  document.getElementById("filterSupport").onclick = () => loadContacts("support");
  document.getElementById("filterMine").onclick = () => loadContacts("mine");
});
</script>

</body>
</html>
