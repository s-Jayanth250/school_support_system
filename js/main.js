// js/main.js
document.addEventListener('DOMContentLoaded', () => {
  loadRecentPosts();

  document.getElementById('contactForm')?.addEventListener('submit', (e)=>{
    e.preventDefault();
    alert('✅ Message sent (frontend only)');
    e.target.reset();
  });
});

function loadRecentPosts(){
  const container = document.getElementById('postsContainer');
  if (!container) return;
  container.innerHTML = 'Loading...';
  fetch('backend/get_opportunities.php')
    .then(r => r.json())
    .then(data => {
      container.innerHTML = '';
      if (!data.length) {
        container.innerHTML = '<p>No opportunities posted yet.</p>';
        return;
      }
      data.forEach(o => {
        const div = document.createElement('div');
        div.className = 'post-card';
        div.innerHTML = `<h3>${escapeHtml(o.title)}</h3>
                         <p>${escapeHtml(o.description)}</p>
                         <div class="meta">${escapeHtml(o.school_name)} • ${escapeHtml(o.category || '')} • Need: ${o.num_volunteers} • Applied: ${o.applied_count}</div>`;
        container.appendChild(div);
      });
    }).catch(err=>{
      console.error(err);
      container.innerHTML = '<p>Could not load posts.</p>';
    });
}

function escapeHtml(s){ return String(s).replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":"&#39;"}[c])); }
