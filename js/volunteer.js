// js/volunteer.js
document.addEventListener('DOMContentLoaded', () => {
  loadOpportunities();
});

function loadOpportunities() {
  const c = document.getElementById('browseContainer');
  if (!c) return;
  c.innerHTML = 'Loading...';
  fetch('backend/get_opportunities.php')
    .then(r => r.json())
    .then(data => {
      c.innerHTML = '';
      if (!data.length) { c.innerHTML = '<p>No opportunities.</p>'; return; }
      data.forEach(o => {
        const div = document.createElement('div');
        div.className = 'post-card';
        div.innerHTML = `<h3>${escapeHtml(o.title)}</h3>
                         <p>${escapeHtml(o.description)}</p>
                         <div class="meta">${escapeHtml(o.school_name)} • Need: ${o.num_volunteers} • Applied: ${o.applied_count}</div>
                         <button data-id="${o.id}" class="apply-btn">Apply</button>`;
        c.appendChild(div);
        const btn = div.querySelector('.apply-btn');
        btn.addEventListener('click', () => applyFor(o.id, btn));
      });
    });
}

function applyFor(opportunityId, btn) {
  const message = prompt('Optional message to the school:','');
  fetch('backend/apply.php', {
    method: 'POST',
    headers: {'Content-Type':'application/json'},
    body: JSON.stringify({opportunity_id: opportunityId, message})
  })
  .then(r => r.json())
  .then(res => {
    alert(res.message);
    if (res.success) { btn.disabled = true; btn.textContent = 'Applied'; }
  })
  .catch(err => { console.error(err); alert('Error applying'); });
}

function escapeHtml(s){ return String(s).replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":"&#39;"}[c])); }
