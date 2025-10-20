// js/school.js
document.addEventListener('DOMContentLoaded', () => {
  loadSchoolPosts();
});

function loadSchoolPosts(){
  const el = document.getElementById('schoolPosts');
  if (!el) return;
  el.innerHTML = 'Loading...';
  fetch('backend/get_applications.php') // returns posts + applicants for this school
    .then(r => r.json())
    .then(data => {
      el.innerHTML = '';
      if (!data.posts || !data.posts.length) { el.innerHTML = '<p>No posts yet.</p>'; return; }
      data.posts.forEach(p => {
        const div = document.createElement('div');
        div.className = 'card';
        let applicantsHtml = '';
        if (p.applicants && p.applicants.length) {
          applicantsHtml = '<ul>' + p.applicants.map(a=>`<li><strong>${escapeHtml(a.volunteer_name)}</strong> (${escapeHtml(a.volunteer_email)}) - ${escapeHtml(a.message||'')}</li>`).join('') + '</ul>';
        } else applicantsHtml = '<p>No applicants yet.</p>';

        div.innerHTML = `<h4>${escapeHtml(p.title)} <small style="color:#777">[Applied: ${p.applied_count} / Need: ${p.num_volunteers}]</small></h4>
                         <p>${escapeHtml(p.description)}</p>
                         <p><strong>Applicants:</strong></p>
                         ${applicantsHtml}`;
        el.appendChild(div);
      });
    });
}

function escapeHtml(s){ return String(s).replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":"&#39;"}[c])); }
